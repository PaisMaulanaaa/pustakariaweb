<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\BorrowingModel;

class Admin extends BaseController
{
    protected $bookModel;
    protected $userModel;
    protected $borrowingModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
        $this->borrowingModel = new BorrowingModel();
    }

    public function index()
    {
        $bookModel = new BookModel();
        $userModel = new UserModel();
        $borrowingModel = new BorrowingModel();

        $data = [
            'title' => 'Dashboard',
            'total_books' => $bookModel->countAllResults(),
            'total_users' => $userModel->where('role', 'user')->countAllResults(),
            'borrowing_stats' => $borrowingModel->getBorrowingStats(),
            'recent_borrowings' => $borrowingModel->select('borrowings.*, books.title as book_title, users.fullname as user_name')
                ->join('books', 'books.id = borrowings.book_id')
                ->join('users', 'users.id = borrowings.user_id')
                ->orderBy('borrow_date', 'DESC')
                ->limit(5)
                ->find()
        ];

        return view('admin/dashboard', $data);
    }

    public function books()
    {
        $data = [
            'title' => 'Manajemen Buku',
            'books' => $this->bookModel->findAll()
        ];

        return view('admin/books', $data);
    }

    public function addBook()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|numeric',
            'isbn' => 'required|min_length[10]',
            'stock' => 'required|numeric',
            'category' => 'required',
            'description' => 'required'
        ]);

        if ($this->request->getMethod() === 'post') {
            if ($validation->withRequest($this->request)->run()) {
                // Handle cover image upload
                $coverImage = $this->request->getFile('cover_image');
                $coverImageName = 'default.jpg';

                if ($coverImage->isValid() && !$coverImage->hasMoved()) {
                    $coverImageName = $coverImage->getRandomName();
                    $coverImage->move(ROOTPATH . 'uploads/covers', $coverImageName);
                }

                $this->bookModel->insert([
                    'title' => $this->request->getPost('title'),
                    'author' => $this->request->getPost('author'),
                    'publisher' => $this->request->getPost('publisher'),
                    'year' => $this->request->getPost('year'),
                    'isbn' => $this->request->getPost('isbn'),
                    'stock' => $this->request->getPost('stock'),
                    'category' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description'),
                    'cover_image' => $coverImageName
                ]);

                session()->setFlashdata('success', 'Buku berhasil ditambahkan');
                return redirect()->to(base_url('admin/books'));
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah Buku Baru',
            'validation' => $validation
        ];

        return view('admin/add_book', $data);
    }

    public function editBook($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/books'));
        }

        $book = $this->bookModel->find($id);
        if (!$book) {
            return redirect()->to(base_url('admin/books'));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|numeric',
            'isbn' => 'required|min_length[10]',
            'stock' => 'required|numeric',
            'category' => 'required',
            'description' => 'required'
        ]);

        if ($this->request->getMethod() === 'post') {
            if ($validation->withRequest($this->request)->run()) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'author' => $this->request->getPost('author'),
                    'publisher' => $this->request->getPost('publisher'),
                    'year' => $this->request->getPost('year'),
                    'isbn' => $this->request->getPost('isbn'),
                    'stock' => $this->request->getPost('stock'),
                    'category' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description')
                ];

                // Handle cover image upload if new image is uploaded
                $coverImage = $this->request->getFile('cover_image');
                if ($coverImage->isValid() && !$coverImage->hasMoved()) {
                    // Delete old cover image if it exists and is not default
                    if ($book['cover_image'] !== 'default.jpg') {
                        unlink(ROOTPATH . 'uploads/covers/' . $book['cover_image']);
                    }
                    
                    $coverImageName = $coverImage->getRandomName();
                    $coverImage->move(ROOTPATH . 'uploads/covers', $coverImageName);
                    $updateData['cover_image'] = $coverImageName;
                }

                $this->bookModel->update($id, $updateData);
                session()->setFlashdata('success', 'Buku berhasil diperbarui');
                return redirect()->to(base_url('admin/books'));
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit Buku',
            'book' => $book,
            'validation' => $validation
        ];

        return view('admin/edit_book', $data);
    }

    public function deleteBook($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/books'));
        }

        $book = $this->bookModel->find($id);
        if ($book) {
            // Delete cover image if it exists and is not default
            if ($book['cover_image'] !== 'default.jpg') {
                unlink(ROOTPATH . 'uploads/covers/' . $book['cover_image']);
            }
            
            $this->bookModel->delete($id);
            session()->setFlashdata('success', 'Buku berhasil dihapus');
        }

        return redirect()->to(base_url('admin/books'));
    }

    public function users()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->where('role', 'user')->findAll()
        ];

        return view('admin/users', $data);
    }

    public function addUser()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'fullname' => 'required',
        ]);

        if ($this->request->getMethod() === 'post') {
            if ($validation->withRequest($this->request)->run()) {
                $this->userModel->insert([
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'fullname' => $this->request->getPost('fullname'),
                    'role' => 'user',
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0
                ]);

                session()->setFlashdata('success', 'User berhasil ditambahkan');
                return redirect()->to(base_url('admin/users'));
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah User Baru',
            'validation' => $validation
        ];

        return view('admin/add_user', $data);
    }

    public function editUser($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/users'));
        }

        $user = $this->userModel->find($id);
        if (!$user || $user['role'] !== 'user') {
            return redirect()->to(base_url('admin/users'));
        }

        $validation = \Config\Services::validation();
        $rules = [
            'username' => "required|min_length[4]|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'fullname' => 'required',
        ];

        // Hanya validasi password jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        $validation->setRules($rules);

        if ($this->request->getMethod() === 'post') {
            if ($validation->withRequest($this->request)->run()) {
                $updateData = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'fullname' => $this->request->getPost('fullname'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0
                ];

                // Update password jika diisi
                if ($this->request->getPost('password')) {
                    $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }

                $this->userModel->update($id, $updateData);
                session()->setFlashdata('success', 'User berhasil diperbarui');
                return redirect()->to(base_url('admin/users'));
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'validation' => $validation
        ];

        return view('admin/edit_user', $data);
    }

    public function deleteUser($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/users'));
        }

        $user = $this->userModel->find($id);
        if ($user && $user['role'] === 'user') {
            // Cek apakah user masih memiliki peminjaman aktif
            $activeBorrowings = $this->borrowingModel
                ->where('user_id', $id)
                ->where('status', 'borrowed')
                ->countAllResults();

            if ($activeBorrowings > 0) {
                session()->setFlashdata('error', 'User tidak dapat dihapus karena masih memiliki peminjaman aktif');
            } else {
                $this->userModel->delete($id);
                session()->setFlashdata('success', 'User berhasil dihapus');
            }
        }

        return redirect()->to(base_url('admin/users'));
    }

    public function toggleUserStatus($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/users'));
        }

        $user = $this->userModel->find($id);
        if ($user && $user['role'] === 'user') {
            $this->userModel->update($id, [
                'is_active' => $user['is_active'] ? 0 : 1
            ]);
            
            $status = $user['is_active'] ? 'dinonaktifkan' : 'diaktifkan';
            session()->setFlashdata('success', "User berhasil $status");
        }

        return redirect()->to(base_url('admin/users'));
    }

    public function borrowings()
    {
        $borrowings = $this->borrowingModel
            ->select('borrowings.*, books.title as book_title, users.fullname as user_name')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->orderBy('borrow_date', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manajemen Peminjaman',
            'borrowings' => $borrowings
        ];

        return view('admin/borrowings', $data);
    }

    public function addBorrowing()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'user_id' => 'required',
            'book_id' => 'required',
            'borrow_date' => 'required|valid_date',
            'due_date' => 'required|valid_date'
        ]);

        if ($this->request->getMethod() === 'post') {
            if ($validation->withRequest($this->request)->run()) {
                // Cek stok buku
                $book = $this->bookModel->find($this->request->getPost('book_id'));
                if ($book['stock'] > 0) {
                    // Kurangi stok buku
                    $this->bookModel->update($book['id'], [
                        'stock' => $book['stock'] - 1
                    ]);

                    // Simpan peminjaman
                    $this->borrowingModel->insert([
                        'user_id' => $this->request->getPost('user_id'),
                        'book_id' => $this->request->getPost('book_id'),
                        'borrow_date' => $this->request->getPost('borrow_date'),
                        'due_date' => $this->request->getPost('due_date'),
                        'status' => 'borrowed'
                    ]);

                    session()->setFlashdata('success', 'Peminjaman berhasil ditambahkan');
                    return redirect()->to(base_url('admin/borrowings'));
                } else {
                    session()->setFlashdata('error', 'Stok buku tidak mencukupi');
                    return redirect()->back()->withInput();
                }
            } else {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Tambah Peminjaman',
            'users' => $this->userModel->where('role', 'user')->where('is_active', 1)->findAll(),
            'books' => $this->bookModel->where('stock >', 0)->findAll(),
            'validation' => $validation
        ];

        return view('admin/add_borrowing', $data);
    }

    public function returnBook($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/borrowings'));
        }

        $borrowing = $this->borrowingModel->find($id);
        if ($borrowing && $borrowing['status'] === 'borrowed') {
            // Kembalikan stok buku
            $book = $this->bookModel->find($borrowing['book_id']);
            $this->bookModel->update($book['id'], [
                'stock' => $book['stock'] + 1
            ]);

            // Update status peminjaman
            $this->borrowingModel->update($id, [
                'return_date' => date('Y-m-d'),
                'status' => 'returned'
            ]);

            // Hitung denda jika terlambat
            $dueDate = strtotime($borrowing['due_date']);
            $returnDate = strtotime(date('Y-m-d'));
            $daysLate = max(0, floor(($returnDate - $dueDate) / (60 * 60 * 24)));
            
            if ($daysLate > 0) {
                $fine = $daysLate * 1000; // Denda Rp 1.000 per hari
                session()->setFlashdata('warning', "Buku terlambat $daysLate hari. Denda: Rp " . number_format($fine, 0, ',', '.'));
            } else {
                session()->setFlashdata('success', 'Buku berhasil dikembalikan');
            }
        }

        return redirect()->to(base_url('admin/borrowings'));
    }

    public function cancelBorrowing($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('admin/borrowings'));
        }

        $borrowing = $this->borrowingModel->find($id);
        if ($borrowing && $borrowing['status'] === 'borrowed') {
            // Kembalikan stok buku
            $book = $this->bookModel->find($borrowing['book_id']);
            $this->bookModel->update($book['id'], [
                'stock' => $book['stock'] + 1
            ]);

            // Hapus peminjaman
            $this->borrowingModel->delete($id);
            session()->setFlashdata('success', 'Peminjaman berhasil dibatalkan');
        }

        return redirect()->to(base_url('admin/borrowings'));
    }
} 