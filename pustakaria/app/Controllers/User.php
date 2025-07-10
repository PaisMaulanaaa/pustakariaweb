<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\BorrowingModel;

class User extends BaseController
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
        $userId = session()->get('user_id');
        $activeBorrowings = $this->borrowingModel->getUserActiveBorrowings($userId);
        $borrowingHistory = $this->borrowingModel->getUserBorrowingHistory($userId);

        // Get book recommendations based on user's borrowing history
        $recommendations = [];
        if (!empty($borrowingHistory)) {
            $categories = [];
            foreach ($borrowingHistory as $borrowing) {
                $book = $this->bookModel->find($borrowing['book_id']);
                if ($book && !isset($categories[$book['category']])) {
                    $categories[$book['category']] = true;
                    // Get 2 books from each category
                    $categoryBooks = $this->bookModel->where('category', $book['category'])
                                                   ->where('stock >', 0)
                                                   ->where('id !=', $borrowing['book_id'])
                                                   ->orderBy('created_at', 'DESC')
                                                   ->findAll(2);
                    $recommendations = array_merge($recommendations, $categoryBooks);
                }
            }
        }

        // If no recommendations based on history, get newest books
        if (empty($recommendations)) {
            $recommendations = $this->bookModel->where('stock >', 0)
                                            ->orderBy('created_at', 'DESC')
                                            ->findAll(6);
        }

        // Get latest books
        $latestBooks = $this->bookModel->where('stock >', 0)
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll(5);

        $data = [
            'title' => 'Dashboard',
            'active_borrowings' => $activeBorrowings,
            'borrowing_history' => $borrowingHistory,
            'total_borrowed' => count($borrowingHistory),
            'current_borrowed' => count($activeBorrowings),
            'recommendations' => $recommendations,
            'latest_books' => $latestBooks
        ];

        return view('user/dashboard', $data);
    }

    public function books()
    {
        $data = [
            'title' => 'Daftar Buku',
            'books' => $this->bookModel->findAll()
        ];

        return view('user/books', $data);
    }

    public function borrowings()
    {
        $borrowings = $this->borrowingModel
            ->select('borrowings.*, books.title as book_title')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('borrowings.user_id', session()->get('user_id'))
            ->orderBy('borrow_date', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Riwayat Peminjaman',
            'borrowings' => $borrowings
        ];

        return view('user/borrowings', $data);
    }

    public function bookDetail($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('user/books'));
        }

        $book = $this->bookModel->find($id);
        if (!$book) {
            session()->setFlashdata('error', 'Buku tidak ditemukan.');
            return redirect()->to(base_url('user/books'));
        }

        // Cek apakah user memiliki peminjaman aktif untuk buku ini
        $userId = session()->get('user_id');
        $hasActiveBorrowing = $this->borrowingModel
            ->where('book_id', $id)
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->countAllResults() > 0;

        $data = [
            'title' => 'Detail Buku',
            'book' => $book,
            'has_active_borrowing' => $hasActiveBorrowing
        ];

        return view('user/book_detail', $data);
    }
} 