<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BorrowingModel;
use App\Models\BookModel;
use App\Models\UserModel;

class Borrowings extends BaseController
{
    protected $borrowingModel;
    protected $bookModel;
    protected $userModel;

    public function __construct()
    {
        $this->borrowingModel = new BorrowingModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Peminjaman',
            'borrowings' => $this->borrowingModel->getAllBorrowings()
        ];

        return view('admin/borrowings/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Peminjaman',
            'users' => $this->userModel->where('role', 'user')->findAll(),
            'books' => $this->bookModel->getAvailableBooks()
        ];

        return view('admin/borrowings/create', $data);
    }

    public function store()
    {
        $rules = [
            'user_id' => 'required|numeric',
            'book_id' => 'required|numeric',
            'borrow_date' => 'required|valid_date',
            'due_date' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $bookId = $this->request->getPost('book_id');

        // Check if user already has active borrowing for this book
        if ($this->borrowingModel->hasActiveBorrowing($userId, $bookId)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pengguna masih memiliki peminjaman aktif untuk buku ini');
        }

        // Check if book is available
        $book = $this->bookModel->find($bookId);
        if (!$book || $book['stock'] <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        $borrowData = [
            'user_id' => $userId,
            'book_id' => $bookId,
            'borrow_date' => $this->request->getPost('borrow_date'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => 'borrowed',
            'notes' => $this->request->getPost('notes')
        ];

        if (!$this->borrowingModel->insert($borrowData)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan peminjaman');
        }

        // Decrease book stock
        $this->bookModel->decreaseStock($bookId);

        return redirect()->to('/admin/borrowings')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show($id = null)
    {
        $borrowing = $this->borrowingModel->getBorrowingDetails($id);

        if (!$borrowing) {
            return redirect()->to('/admin/borrowings')
                ->with('error', 'Data peminjaman tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Peminjaman',
            'borrowing' => $borrowing
        ];

        return view('admin/borrowings/show', $data);
    }

    public function return($id = null)
    {
        $borrowing = $this->borrowingModel->find($id);

        if (!$borrowing) {
            return redirect()->to('/admin/borrowings')
                ->with('error', 'Data peminjaman tidak ditemukan');
        }

        if ($borrowing['status'] === 'returned') {
            return redirect()->to('/admin/borrowings')
                ->with('error', 'Buku sudah dikembalikan');
        }

        $updateData = [
            'status' => 'returned',
            'return_date' => date('Y-m-d'),
            'notes' => ($borrowing['notes'] ?? '') . "\nDikembalikan pada: " . date('d/m/Y')
        ];

        if (!$this->borrowingModel->update($id, $updateData)) {
            return redirect()->to('/admin/borrowings')
                ->with('error', 'Gagal memproses pengembalian buku');
        }

        // Increase book stock
        $this->bookModel->increaseStock($borrowing['book_id']);

        return redirect()->to('/admin/borrowings')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    public function overdue()
    {
        $data = [
            'title' => 'Peminjaman Terlambat',
            'borrowings' => $this->borrowingModel->getOverdueBorrowings()
        ];

        return view('admin/borrowings/overdue', $data);
    }

    public function updateOverdue()
    {
        $this->borrowingModel->updateOverdueStatus();
        
        return redirect()->to('/admin/borrowings/overdue')
            ->with('success', 'Status peminjaman terlambat berhasil diperbarui');
    }

    public function report()
    {
        $data = [
            'title' => 'Laporan Peminjaman',
            'stats' => $this->borrowingModel->getBorrowingStats()
        ];

        return view('admin/borrowings/report', $data);
    }
}
