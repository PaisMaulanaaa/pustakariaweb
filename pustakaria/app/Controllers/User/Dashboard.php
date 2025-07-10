<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\BorrowingModel;

class Dashboard extends BaseController
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
        try {
            $userId = session()->get('user_id');

            // Get basic data with error handling
            $activeBorrowings = [];
            $userBorrowings = [];
            $latestBooks = [];
            $popularBooks = [];
            $recommendations = [];

            try {
                $activeBorrowings = $this->borrowingModel->getActiveUserBorrowings($userId);
            } catch (\Exception $e) {
                log_message('error', 'Error getting active borrowings: ' . $e->getMessage());
            }

            try {
                $userBorrowings = $this->borrowingModel->getUserBorrowings($userId);
            } catch (\Exception $e) {
                log_message('error', 'Error getting user borrowings: ' . $e->getMessage());
            }

            // Optimized favorite categories - use JOIN instead of loop
            $topCategories = [];
            try {
                $categoryQuery = $this->borrowingModel
                    ->select('books.category, COUNT(*) as count')
                    ->join('books', 'books.id = borrowings.book_id', 'left')
                    ->where('borrowings.user_id', $userId)
                    ->groupBy('books.category')
                    ->orderBy('count', 'DESC')
                    ->limit(3)
                    ->find();

                $topCategories = array_column($categoryQuery, 'category');
            } catch (\Exception $e) {
                log_message('error', 'Error getting favorite categories: ' . $e->getMessage());
            }

            // Get recommendations based on top categories
            try {
                if (!empty($topCategories)) {
                    $recommendations = $this->bookModel
                        ->whereIn('category', $topCategories)
                        ->where('stock >', 0)
                        ->orderBy('created_at', 'DESC')
                        ->limit(3)
                        ->find();
                }
            } catch (\Exception $e) {
                log_message('error', 'Error getting recommendations: ' . $e->getMessage());
            }

            // Get latest books
            try {
                $latestBooks = $this->bookModel
                    ->where('stock >', 0)
                    ->orderBy('created_at', 'DESC')
                    ->limit(3)
                    ->find();
            } catch (\Exception $e) {
                log_message('error', 'Error getting latest books: ' . $e->getMessage());
            }

            // Get popular books
            try {
                $popularBooks = $this->bookModel->getPopularBooks(3);
            } catch (\Exception $e) {
                log_message('error', 'Error getting popular books: ' . $e->getMessage());
            }

            $data = [
                'title' => 'Dashboard',
                'active_borrowings' => $activeBorrowings ?? [],
                'total_borrowed' => count($userBorrowings ?? []),
                'current_borrowed' => count($activeBorrowings ?? []),
                'recommendations' => $recommendations ?? [],
                'latest_books' => $latestBooks ?? [],
                'popular_books' => $popularBooks ?? []
            ];

            return view('user/dashboard', $data);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());

            // Return minimal dashboard if there's an error
            $data = [
                'title' => 'Dashboard',
                'active_borrowings' => [],
                'total_borrowed' => 0,
                'current_borrowed' => 0,
                'recommendations' => [],
                'latest_books' => [],
                'popular_books' => []
            ];

            return view('user/dashboard', $data);
        }
    }
} 