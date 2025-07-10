<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\BorrowingModel;

class Books extends BaseController
{
    protected $bookModel;
    protected $borrowingModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->borrowingModel = new BorrowingModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $query = $this->bookModel;

        if ($keyword) {
            $query = $query->search($keyword);
        }

        $data = [
            'title' => 'Manajemen Buku',
            'books' => $query->paginate(10, 'books'),
            'pager' => $query->pager,
            'keyword' => $keyword,
            'categories' => $this->bookModel->getCategories()
        ];

        return view('admin/books/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Buku',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/books/create', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Buku Baru'
        ];

        return view('admin/books/create', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'publisher' => 'required|min_length[3]',
            'year' => 'required|numeric|min_length[4]|max_length[4]',
            'isbn' => 'required|min_length[10]|is_unique[books.isbn]',
            'stock' => 'required|numeric|greater_than_equal_to[0]',
            'category' => 'required',
            'description' => 'required|min_length[10]',
            'cover_image' => 'uploaded[cover_image]|max_size[cover_image,5120]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png,image/gif,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Handle file upload first
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage->isValid() && !$coverImage->hasMoved()) {
            $coverImageName = $coverImage->getRandomName();
            $coverImage->move(FCPATH . 'uploads/covers', $coverImageName);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupload gambar cover');
        }

        $bookData = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'publisher' => $this->request->getPost('publisher'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'stock' => $this->request->getPost('stock'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description'),
            'cover_image' => $coverImageName
        ];

        try {
            if (!$this->bookModel->insert($bookData)) {
                // If insert fails, delete the uploaded image
                if (file_exists(FCPATH . 'uploads/covers/' . $coverImageName)) {
                    unlink(FCPATH . 'uploads/covers/' . $coverImageName);
                }
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan buku baru');
            }
        } catch (\Exception $e) {
            // If any error occurs, delete the uploaded image
            if (file_exists(FCPATH . 'uploads/covers/' . $coverImageName)) {
                unlink(FCPATH . 'uploads/covers/' . $coverImageName);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/admin/books')
            ->with('success', 'Buku baru berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        $book = $this->bookModel->find($id); // Mengubah findBookById menjadi find

        if (!$book) {
            return redirect()->to('/admin/books')
                ->with('error', 'Buku tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Buku',
            'book' => $book
        ];

        return view('admin/books/edit', $data);
    }

    public function update($id = null)
    {
        $book = $this->bookModel->find($id); // Mengubah findBookById menjadi find

        if (!$book) {
            return redirect()->to('/admin/books')
                ->with('error', 'Buku tidak ditemukan');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'publisher' => 'required|min_length[3]',
            'year' => 'required|numeric|min_length[4]|max_length[4]',
            'isbn' => "required|min_length[10]|is_unique[books.isbn,id,$id]",
            'stock' => 'required|numeric|greater_than_equal_to[0]',
            'category' => 'required',
            'description' => 'required|min_length[10]'
        ];

        // Add cover image validation if uploaded
        if ($this->request->getFile('cover_image')->isValid()) {
            $rules['cover_image'] = 'uploaded[cover_image]|max_size[cover_image,5120]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png,image/gif,image/webp]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $bookData = [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'publisher' => $this->request->getPost('publisher'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'stock' => $this->request->getPost('stock'),
            'category' => $this->request->getPost('category'),
            'description' => $this->request->getPost('description')
        ];

        // Handle cover image update
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage->isValid()) {
            $coverImageName = $coverImage->getRandomName();
            $coverImage->move(FCPATH . 'uploads/covers', $coverImageName);
            $bookData['cover_image'] = $coverImageName;

            // Delete old cover image
            if ($book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])) {
                unlink(FCPATH . 'uploads/covers/' . $book['cover_image']);
            }
        }

        if (!$this->bookModel->update($id, $bookData)) {
            if (isset($coverImageName) && file_exists(FCPATH . 'uploads/covers/' . $coverImageName)) {
                unlink(FCPATH . 'uploads/covers/' . $coverImageName);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate buku');
        }

        return redirect()->to('/admin/books')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function delete($id = null)
    {
        // Validate ID
        if ($id === null || !is_numeric($id)) {
            return redirect()->to('/admin/books')
                ->with('error', 'ID buku tidak valid');
        }

        try {
            // Use raw query to ensure we get all fields including NULL values
            $db = \Config\Database::connect();
            $query = $db->query("SELECT id, title, cover_image FROM books WHERE id = ? AND deleted_at IS NULL", [$id]);
            $book = $query->getRowArray();

            if (!$book) {
                return redirect()->to('/admin/books')
                    ->with('error', 'Buku tidak ditemukan');
            }

            // Debug log to see what we got from database
            log_message('debug', 'Book data retrieved: ' . json_encode($book));

            // Check if book has active borrowings
            $activeBorrowings = $this->borrowingModel->where('book_id', $id)
                ->where('status !=', 'returned')
                ->countAllResults();

            if ($activeBorrowings > 0) {
                return redirect()->to('/admin/books')
                    ->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam');
            }

            // Safe way to handle cover image deletion with multiple checks
            $coverImage = null;

            // Check if cover_image key exists in array
            if (array_key_exists('cover_image', $book)) {
                $coverImage = $book['cover_image'];
            } else {
                log_message('warning', 'cover_image key not found in book data for ID: ' . $id);
            }

            // Only try to delete image if we have a valid cover image
            if (!empty($coverImage) && $coverImage !== 'default.jpg' && $coverImage !== '') {
                $imagePath = FCPATH . 'uploads/covers/' . $coverImage;
                if (file_exists($imagePath)) {
                    try {
                        unlink($imagePath);
                        log_message('info', 'Cover image deleted: ' . $coverImage);
                    } catch (\Exception $e) {
                        log_message('warning', 'Failed to delete cover image: ' . $e->getMessage());
                        // Continue with book deletion even if image deletion fails
                    }
                }
            } else {
                log_message('info', 'No cover image to delete for book ID: ' . $id);
            }

            // Delete the book (this will also trigger the model's deleteImage callback)
            if (!$this->bookModel->delete($id)) {
                return redirect()->to('/admin/books')
                    ->with('error', 'Gagal menghapus buku dari database');
            }

            $bookTitle = $book['title'] ?? 'Unknown';
            log_message('info', 'Book deleted successfully: ID ' . $id . ', Title: ' . $bookTitle);

            return redirect()->to('/admin/books')
                ->with('success', 'Buku "' . $bookTitle . '" berhasil dihapus');

        } catch (\Exception $e) {
            log_message('error', 'Error deleting book ID ' . $id . ': ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return redirect()->to('/admin/books')
                ->with('error', 'Terjadi kesalahan saat menghapus buku. Silakan coba lagi.');
        }
    }
}
