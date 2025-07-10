<?php

namespace App\Controllers\User;

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
        $category = $this->request->getGet('category');
        $userId = session()->get('user_id');
        
        $query = $this->bookModel;

        if ($keyword) {
            $query = $query->groupStart()
                          ->like('title', $keyword)
                          ->orLike('author', $keyword)
                          ->orLike('publisher', $keyword)
                          ->orLike('isbn', $keyword)
                          ->groupEnd();
        }

        if ($category) {
            $query = $query->where('category', $category);
        }

        // Dapatkan daftar kategori unik untuk filter
        $categories = $this->bookModel->select('category')
                                    ->distinct()
                                    ->where('category IS NOT NULL')
                                    ->orderBy('category', 'ASC')
                                    ->findAll();

        // Dapatkan buku dengan pagination
        $books = $query->paginate(12, 'books');

        // Dapatkan peminjaman aktif user
        $activeBorrowings = $this->borrowingModel->getUserActiveBorrowings($userId);
        $activeBorrowingsMap = [];
        foreach ($activeBorrowings as $borrowing) {
            $activeBorrowingsMap[$borrowing['book_id']] = true;
        }

        // Tambahkan informasi peminjaman ke setiap buku
        foreach ($books as &$book) {
            $book['has_active_borrowing'] = isset($activeBorrowingsMap[$book['id']]);
        }

        $data = [
            'title' => 'Katalog Buku',
            'books' => $books,
            'pager' => $this->bookModel->pager,
            'keyword' => $keyword,
            'category' => $category,
            'categories' => array_column($categories, 'category'),
            'active_borrowings_count' => count($activeBorrowings)
        ];

        return view('user/books/index', $data);
    }

    public function show($id = null)
    {
        $book = $this->bookModel->find($id);
        
        if (!$book) {
            return redirect()->to('/user/books')->with('error', 'Buku tidak ditemukan');
        }

        $userId = session()->get('user_id');
        $hasActiveBorrowing = $this->borrowingModel->hasActiveBorrowing($userId, $id);
        $activeCount = count($this->borrowingModel->getActiveUserBorrowings($userId));

        $data = [
            'title' => 'Detail Buku',
            'book' => $book,
            'has_active_borrowing' => $hasActiveBorrowing,
            'can_borrow' => !$hasActiveBorrowing && $activeCount < 3 && $book['stock'] > 0,
            'active_borrowings_count' => $activeCount // Tambahkan ini
        ];

        return view('user/books/show', $data);
    }

    public function borrow($id = null)
    {
        try {
            // Validasi input
            if (!$id || !is_numeric($id)) {
                return redirect()->back()->with('error', 'ID buku tidak valid');
            }

            $userId = session()->get('user_id');
            if (!$userId) {
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
            }

            $book = $this->bookModel->find($id);

            if (!$book) {
                return redirect()->to('/user/books')->with('error', 'Buku tidak ditemukan');
            }

            // Cek stok buku
            if ($book['stock'] <= 0) {
                return redirect()->back()
                    ->with('error', 'Maaf, stok buku sedang tidak tersedia');
            }

            // Cek apakah user sudah meminjam buku ini
            try {
                if ($this->borrowingModel->hasActiveBorrowing($userId, $id)) {
                    return redirect()->back()
                        ->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini');
                }
            } catch (\Exception $e) {
                log_message('error', 'Error checking active borrowing: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memeriksa peminjaman aktif');
            }

            // Cek jumlah peminjaman aktif user
            try {
                if ($this->borrowingModel->countActiveBorrowings($userId) >= 3) {
                    return redirect()->back()
                        ->with('error', 'Anda telah mencapai batas maksimal peminjaman (3 buku)');
                }
            } catch (\Exception $e) {
                log_message('error', 'Error counting active borrowings: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memeriksa jumlah peminjaman');
            }

            // Cek apakah ada denda yang belum dibayar
            try {
                if ($this->borrowingModel->hasUnpaidFines($userId)) {
                    return redirect()->back()
                        ->with('error', 'Anda memiliki denda yang belum dibayar. Silakan selesaikan pembayaran terlebih dahulu');
                }
            } catch (\Exception $e) {
                log_message('error', 'Error checking unpaid fines: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat memeriksa denda');
            }

            $borrowData = [
                'user_id' => $userId,
                'book_id' => $id,
                'borrow_date' => date('Y-m-d'),
                'due_date' => date('Y-m-d', strtotime('+7 days')),
                'status' => 'borrowed'
            ];

            // Insert borrowing record
            try {
                if (!$this->borrowingModel->insert($borrowData)) {
                    $errors = $this->borrowingModel->errors();
                    log_message('error', 'Borrowing insert failed: ' . json_encode($errors));
                    return redirect()->back()
                        ->with('error', 'Gagal memproses peminjaman buku: ' . implode(', ', $errors));
                }
            } catch (\Exception $e) {
                log_message('error', 'Error inserting borrowing: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data peminjaman');
            }

            // Kurangi stok buku
            try {
                $this->bookModel->decreaseStock($id);
            } catch (\Exception $e) {
                log_message('error', 'Error decreasing stock: ' . $e->getMessage());
                // Rollback borrowing if stock update fails
                $this->borrowingModel->delete($this->borrowingModel->getInsertID());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate stok buku');
            }

            return redirect()->to('/user/borrowings')
                ->with('success', 'Buku berhasil dipinjam');

        } catch (\Exception $e) {
            log_message('error', 'General error in borrow method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Operasi tidak valid. Silakan coba lagi.');
        }
    }
}
