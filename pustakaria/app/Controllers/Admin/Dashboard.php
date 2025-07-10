<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\BorrowingModel;

class Dashboard extends BaseController
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
        try {
            // Basic statistics with error handling
            $totalBooks = 0;
            $totalUsers = 0;
            $totalBorrowings = 0;
            $activeBorrowings = 0;

            try {
                $totalBooks = $this->bookModel->countAllResults();
            } catch (\Exception $e) {
                log_message('error', 'Error counting books: ' . $e->getMessage());
            }

            try {
                $totalUsers = $this->userModel->where('role', 'user')->countAllResults();
            } catch (\Exception $e) {
                log_message('error', 'Error counting users: ' . $e->getMessage());
            }

            try {
                $totalBorrowings = $this->borrowingModel->countAllResults();
            } catch (\Exception $e) {
                log_message('error', 'Error counting borrowings: ' . $e->getMessage());
            }

            try {
                $activeBorrowings = $this->borrowingModel->where('status', 'borrowed')->countAllResults();
            } catch (\Exception $e) {
                log_message('error', 'Error counting active borrowings: ' . $e->getMessage());
            }

            // Get latest borrowings with error handling
            $latestBorrowings = [];
            try {
                $latestBorrowings = $this->borrowingModel
                    ->select('borrowings.*, books.title as book_title, books.cover_image, users.fullname as user_name')
                    ->join('books', 'books.id = borrowings.book_id', 'left')
                    ->join('users', 'users.id = borrowings.user_id', 'left')
                    ->orderBy('borrowings.created_at', 'DESC')
                    ->limit(5)
                    ->find();
            } catch (\Exception $e) {
                log_message('error', 'Error getting latest borrowings: ' . $e->getMessage());
            }

            // Get most borrowed books with error handling
            $mostBorrowedBooks = [];
            try {
                $mostBorrowedBooks = $this->borrowingModel
                    ->select('books.title, books.author, COUNT(*) as borrow_count')
                    ->join('books', 'books.id = borrowings.book_id', 'left')
                    ->groupBy('books.id')
                    ->orderBy('borrow_count', 'DESC')
                    ->limit(5)
                    ->find();
            } catch (\Exception $e) {
                log_message('error', 'Error getting most borrowed books: ' . $e->getMessage());
            }

            // Get overdue borrowings with error handling
            $overdueBorrowings = [];
            try {
                $overdueBorrowings = $this->borrowingModel
                    ->select('borrowings.*, books.title as book_title, users.fullname as user_name')
                    ->join('books', 'books.id = borrowings.book_id', 'left')
                    ->join('users', 'users.id = borrowings.user_id', 'left')
                    ->where('borrowings.status', 'borrowed')
                    ->where('borrowings.due_date <', date('Y-m-d'))
                    ->find();
            } catch (\Exception $e) {
                log_message('error', 'Error getting overdue borrowings: ' . $e->getMessage());
            }

            // Get books with low stock with error handling
            $lowStockBooks = [];
            try {
                $lowStockBooks = $this->bookModel
                    ->where('stock <', 5)
                    ->findAll();
            } catch (\Exception $e) {
                log_message('error', 'Error getting low stock books: ' . $e->getMessage());
            }

            // Monthly borrowing statistics with error handling
            $monthlyStats = [];
            try {
                $monthlyStats = $this->borrowingModel
                    ->select('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                    ->groupBy('month')
                    ->orderBy('month', 'DESC')
                    ->limit(6)
                    ->find();
            } catch (\Exception $e) {
                log_message('error', 'Error getting monthly stats: ' . $e->getMessage());
            }

            $data = [
                'title' => 'Dashboard Administrator',
                'totalBooks' => $totalBooks,
                'totalUsers' => $totalUsers,
                'totalBorrowings' => $totalBorrowings,
                'activeBorrowings' => $activeBorrowings,
                'latestBorrowings' => $latestBorrowings ?? [],
                'mostBorrowedBooks' => $mostBorrowedBooks ?? [],
                'overdueBorrowings' => $overdueBorrowings ?? [],
                'lowStockBooks' => $lowStockBooks ?? [],
                'monthlyStats' => array_reverse($monthlyStats ?? [])
            ];

            return view('admin/dashboard', $data);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());

            // Return minimal dashboard if there's an error
            $data = [
                'title' => 'Dashboard Administrator',
                'totalBooks' => 0,
                'totalUsers' => 0,
                'totalBorrowings' => 0,
                'activeBorrowings' => 0,
                'latestBorrowings' => [],
                'mostBorrowedBooks' => [],
                'overdueBorrowings' => [],
                'lowStockBooks' => [],
                'monthlyStats' => []
            ];

            return view('admin/dashboard', $data);
        }
    }
} 