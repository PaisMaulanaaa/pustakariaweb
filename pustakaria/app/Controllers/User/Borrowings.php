<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\BorrowingModel;

class Borrowings extends BaseController
{
    protected $bookModel;
    protected $borrowingModel;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->borrowingModel = new BorrowingModel();
        $this->session = session();
        $this->db = \Config\Database::connect();

        // Load notification helper
        helper('notification');
    }

    public function index()
    {
        $userId = $this->session->get('user_id');
        $data = [
            'title' => 'Riwayat Peminjaman',
            'borrowings' => $this->borrowingModel->getUserBorrowings($userId),
            'active_borrowings' => $this->borrowingModel->getActiveBorrowings($userId),
            'overdue_borrowings' => $this->borrowingModel->getUserOverdueBorrowings($userId)
        ];

        return view('user/borrowings/index', $data);
    }

    public function borrow($bookId = null)
    {
        if (!$bookId) {
            return redirect()->back()->with('error', 'ID Buku tidak valid');
        }

        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        if (!$this->bookModel->isAvailable($bookId)) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        $userId = $this->session->get('user_id');
        
        // Cek apakah user masih memiliki peminjaman aktif untuk buku ini
        if ($this->borrowingModel->hasActiveBorrowing($userId, $bookId)) {
            return redirect()->back()->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini');
        }

        // Cek jumlah peminjaman aktif user
        if ($this->borrowingModel->countActiveBorrowings($userId) >= 3) {
            return redirect()->back()->with('error', 'Anda telah mencapai batas maksimal peminjaman (3 buku)');
        }

        // Cek apakah user memiliki denda yang belum dibayar
        if ($this->borrowingModel->hasUnpaidFines($userId)) {
            return redirect()->back()->with('error', 'Anda memiliki denda yang belum dibayar');
        }

        $borrowData = [
            'user_id' => $userId,
            'book_id' => $bookId,
            'borrow_date' => date('Y-m-d H:i:s'),
            'due_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'status' => 'borrowed'
        ];

        $this->db->transStart();
        try {
            // Simpan data peminjaman
            $this->borrowingModel->insert($borrowData);
            
            // Update stok buku
            $this->bookModel->updateStock($bookId, -1);
            
            $this->db->transCommit();
            return redirect()->back()->with('success', 'Buku berhasil dipinjam');
        } catch (\Exception $e) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses peminjaman');
        }
    }

    public function extend($borrowId = null)
    {
        // Check if this is a POST request
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('user/borrowings');
        }

        if (!$borrowId) {
            set_error_notification('ID Peminjaman tidak valid', [
                'title' => 'Parameter Tidak Valid',
                'icon' => 'fas fa-exclamation-circle'
            ]);
            return redirect()->to('user/borrowings');
        }

        $userId = $this->session->get('user_id');
        $borrowing = $this->borrowingModel->find($borrowId);

        if (!$borrowing || $borrowing['user_id'] != $userId) {
            return redirect()->to('user/borrowings')->with('error', 'Data peminjaman tidak ditemukan');
        }

        if ($borrowing['status'] !== 'borrowed') {
            return redirect()->to('user/borrowings')->with('error', 'Status peminjaman tidak valid untuk perpanjangan');
        }

        if ($borrowing['extended']) {
            return redirect()->to('user/borrowings')->with('error', 'Peminjaman sudah pernah diperpanjang');
        }

        // Cek apakah sudah melewati tanggal pengembalian
        if (strtotime($borrowing['due_date']) < time()) {
            return redirect()->to('user/borrowings')->with('error', 'Tidak dapat memperpanjang karena sudah melewati tanggal pengembalian');
        }

        try {
            $this->borrowingModel->update($borrowId, [
                'due_date' => date('Y-m-d H:i:s', strtotime($borrowing['due_date'] . ' +7 days')),
                'extended' => true
            ]);

            set_success_notification('Peminjaman berhasil diperpanjang', [
                'title' => 'Perpanjangan Berhasil',
                'icon' => 'fas fa-calendar-plus'
            ]);
            return redirect()->to('user/borrowings');
        } catch (\Exception $e) {
            set_error_notification('Terjadi kesalahan saat memperpanjang peminjaman: ' . $e->getMessage(), [
                'title' => 'Perpanjangan Gagal',
                'icon' => 'fas fa-exclamation-circle'
            ]);
            return redirect()->to('user/borrowings');
        }
    }

    public function return($borrowId = null)
    {
        // Check if this is a POST request
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('user/borrowings');
        }

        if (!$borrowId) {
            set_error_notification('ID Peminjaman tidak valid', [
                'title' => 'Parameter Tidak Valid',
                'icon' => 'fas fa-exclamation-circle'
            ]);
            return redirect()->to('user/borrowings');
        }

        $userId = $this->session->get('user_id');
        $borrowing = $this->borrowingModel->find($borrowId);

        if (!$borrowing || $borrowing['user_id'] != $userId) {
            return redirect()->to('user/borrowings')->with('error', 'Data peminjaman tidak ditemukan');
        }

        if ($borrowing['status'] !== 'borrowed') {
            return redirect()->to('user/borrowings')->with('error', 'Status peminjaman tidak valid untuk pengembalian');
        }

        $this->db->transStart();
        try {
            // Hitung denda jika ada
            $fine = $this->borrowingModel->calculateFine($borrowId);
            
            // Update status peminjaman
            $this->borrowingModel->update($borrowId, [
                'return_date' => date('Y-m-d H:i:s'),
                'fine_amount' => $fine,
                'status' => 'returned'
            ]);
            
            // Update stok buku
            $this->bookModel->updateStock($borrowing['book_id'], 1);
            
            $this->db->transCommit();
            
            if ($fine > 0) {
                set_warning_notification('Buku berhasil dikembalikan. Anda memiliki denda sebesar Rp ' . number_format($fine, 0, ',', '.'), [
                    'title' => 'Pengembalian dengan Denda',
                    'icon' => 'fas fa-exclamation-triangle'
                ]);
            } else {
                set_success_notification('Buku berhasil dikembalikan', [
                    'title' => 'Pengembalian Berhasil',
                    'icon' => 'fas fa-undo'
                ]);
            }

            return redirect()->to('user/borrowings');
        } catch (\Exception $e) {
            $this->db->transRollback();
            set_error_notification('Terjadi kesalahan saat memproses pengembalian: ' . $e->getMessage(), [
                'title' => 'Pengembalian Gagal',
                'icon' => 'fas fa-exclamation-circle'
            ]);
            return redirect()->to('user/borrowings');
        }
    }

    public function payFine($borrowId = null)
    {
        if (!$borrowId) {
            return redirect()->back()->with('error', 'ID Peminjaman tidak valid');
        }

        $userId = $this->session->get('user_id');
        $borrowing = $this->borrowingModel->find($borrowId);

        if (!$borrowing || $borrowing['user_id'] != $userId) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        if ($borrowing['fine_amount'] <= 0 || $borrowing['fine_paid']) {
            return redirect()->back()->with('error', 'Tidak ada denda yang perlu dibayar');
        }

        try {
            $this->borrowingModel->update($borrowId, [
                'fine_paid' => true,
                'fine_paid_date' => date('Y-m-d H:i:s')
            ]);
            
            return redirect()->back()->with('success', 'Denda berhasil dibayar');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran denda');
        }
    }
} 