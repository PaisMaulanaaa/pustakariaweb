<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowingModel extends Model
{
    protected $table = 'borrowings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
        'fine_paid',
        'fine_paid_date',
        'extended',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Validation
    protected $validationRules = [
        'user_id' => 'required|numeric',
        'book_id' => 'required|numeric',
        'borrow_date' => 'required|valid_date',
        'due_date' => 'required|valid_date',
        'status' => 'required|in_list[borrowed,returned]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'ID User harus diisi',
            'numeric' => 'ID User harus berupa angka'
        ],
        'book_id' => [
            'required' => 'ID Buku harus diisi',
            'numeric' => 'ID Buku harus berupa angka'
        ],
        'borrow_date' => [
            'required' => 'Tanggal pinjam harus diisi',
            'valid_date' => 'Format tanggal pinjam tidak valid'
        ],
        'due_date' => [
            'required' => 'Tanggal jatuh tempo harus diisi',
            'valid_date' => 'Format tanggal jatuh tempo tidak valid'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /**
     * Get all borrowings for a user with book details
     */
    public function getUserBorrowings(int $userId): array
    {
        return $this->select('borrowings.*, books.title as book_title, books.cover_image, books.author')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('borrowings.user_id', $userId)
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.borrow_date', 'DESC')
                   ->findAll();
    }

    /**
     * Get active borrowings for a user
     */
    public function getActiveBorrowings(int $userId): array
    {
        $borrowings = $this->select('borrowings.*, books.title as book_title, books.cover_image, books.author')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('borrowings.user_id', $userId)
                   ->where('borrowings.status', 'borrowed')
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.due_date', 'ASC')
                   ->findAll();

        // Pastikan field extended selalu ada
        foreach ($borrowings as &$borrowing) {
            $borrowing['extended'] = $borrowing['extended'] ?? false;
        }

        return $borrowings;
    }

    /**
     * Get overdue borrowings for a specific user
     */
    public function getUserOverdueBorrowings(int $userId): array
    {
        $borrowings = $this->select('borrowings.*, books.title as book_title, books.cover_image, books.author')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('borrowings.user_id', $userId)
                   ->where('borrowings.status', 'borrowed')
                   ->where('borrowings.due_date <', date('Y-m-d H:i:s'))
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.due_date', 'ASC')
                   ->findAll();

        // Pastikan field extended selalu ada
        foreach ($borrowings as &$borrowing) {
            $borrowing['extended'] = $borrowing['extended'] ?? false;
        }

        return $borrowings;
    }

    /**
     * Get all overdue borrowings (for admin)
     */
    public function getOverdueBorrowings(): array
    {
        return $this->select('borrowings.*, books.title as book_title, users.fullname as user_name, users.email')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->join('users', 'users.id = borrowings.user_id')
                   ->where('borrowings.status', 'borrowed')
                   ->where('borrowings.due_date <', date('Y-m-d H:i:s'))
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.due_date', 'ASC')
                   ->findAll();
    }

    /**
     * Check if user has active borrowing for a book
     */
    public function hasActiveBorrowing(int $userId, int $bookId): bool
    {
        return $this->where('user_id', $userId)
                   ->where('book_id', $bookId)
                   ->where('status', 'borrowed')
                   ->where('deleted_at IS NULL')
                   ->countAllResults() > 0;
    }

    /**
     * Count active borrowings for a user
     */
    public function countActiveBorrowings(int $userId): int
    {
        return $this->where('user_id', $userId)
                   ->where('status', 'borrowed')
                   ->where('deleted_at IS NULL')
                   ->countAllResults();
    }

    /**
     * Check if user has any unpaid fines
     */
    public function hasUnpaidFines(int $userId): bool
    {
        return $this->where('user_id', $userId)
                   ->where('fine_amount >', 0)
                   ->where('fine_amount > fine_paid')
                   ->where('deleted_at IS NULL')
                   ->countAllResults() > 0;
    }

    /**
     * Calculate fine for a borrowing
     * Fine is Rp 1000 per day
     */
    public function calculateFine(int $borrowId): float
    {
        $borrowing = $this->find($borrowId);
        if (!$borrowing) {
            return 0;
        }

        // If already returned or has fine, return existing fine
        if ($borrowing['status'] === 'returned' || $borrowing['fine_amount'] > 0) {
            return (float) $borrowing['fine_amount'];
        }

        // Calculate days overdue
        $dueDate = strtotime($borrowing['due_date']);
        $today = time();
        
        if ($today <= $dueDate) {
            return 0;
        }

        $daysOverdue = ceil(($today - $dueDate) / (60 * 60 * 24));
        return $daysOverdue * 1000; // Rp 1000 per day
    }

    /**
     * Get borrowing statistics for a user
     */
    public function getUserStats(int $userId): array
    {
        $totalBorrowings = $this->where('user_id', $userId)
                               ->where('deleted_at IS NULL')
                               ->countAllResults();
                               
        $activeBorrowings = $this->where('user_id', $userId)
                                ->where('status', 'borrowed')
                                ->where('deleted_at IS NULL')
                                ->countAllResults();
                                
        $overdueBorrowings = $this->where('user_id', $userId)
                                 ->where('status', 'borrowed')
                                 ->where('due_date <', date('Y-m-d H:i:s'))
                                 ->where('deleted_at IS NULL')
                                 ->countAllResults();
                                 
        $totalFines = $this->selectSum('fine_amount')
                          ->where('user_id', $userId)
                          ->where('deleted_at IS NULL')
                          ->get()
                          ->getRow()
                          ->fine_amount ?? 0;
                          
        $unpaidFines = $this->selectSum('fine_amount - fine_paid', 'unpaid_amount')
                           ->where('user_id', $userId)
                           ->where('fine_amount > fine_paid')
                           ->where('deleted_at IS NULL')
                           ->get()
                           ->getRow()
                           ->unpaid_amount ?? 0;

        return [
            'total_borrowings' => $totalBorrowings,
            'active_borrowings' => $activeBorrowings,
            'overdue_borrowings' => $overdueBorrowings,
            'total_fines' => $totalFines,
            'unpaid_fines' => $unpaidFines
        ];
    }

    /**
     * Get popular books based on borrowing count
     */
    public function getPopularBooks(int $limit = 5): array
    {
        return $this->select('books.*, COUNT(borrowings.id) as borrow_count')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('books.deleted_at IS NULL')
                   ->where('borrowings.deleted_at IS NULL')
                   ->groupBy('books.id')
                   ->orderBy('borrow_count', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Alias for getActiveBorrowings for consistency
     */
    public function getActiveUserBorrowings(int $userId): array
    {
        return $this->getActiveBorrowings($userId);
    }

    /**
     * Update status peminjaman yang terlambat
     * Status akan diubah menjadi 'overdue' jika:
     * 1. Status masih 'borrowed'
     * 2. Tanggal jatuh tempo sudah lewat
     */
    public function updateOverdueStatus(): int
    {
        $builder = $this->builder();
        
        return $builder->set('status', 'overdue')
                      ->where('status', 'borrowed')
                      ->where('due_date <', date('Y-m-d H:i:s'))
                      ->where('deleted_at IS NULL')
                      ->update();
    }

    /**
     * Get borrowing history statistics
     */
    public function getBorrowingStats(): array
    {
        $totalBorrowings = $this->where('deleted_at IS NULL')->countAllResults();
        
        $activeBorrowings = $this->where('status', 'borrowed')
                                ->where('deleted_at IS NULL')
                                ->countAllResults();
                                
        $overdueBorrowings = $this->where('status', 'borrowed')
                                 ->where('due_date <', date('Y-m-d H:i:s'))
                                 ->where('deleted_at IS NULL')
                                 ->countAllResults();
                                 
        $totalFines = $this->selectSum('fine_amount')
                          ->where('deleted_at IS NULL')
                          ->get()
                          ->getRow()
                          ->fine_amount ?? 0;
                          
        $collectedFines = $this->selectSum('fine_paid')
                              ->where('fine_paid >', 0)
                              ->where('deleted_at IS NULL')
                              ->get()
                              ->getRow()
                              ->fine_paid ?? 0;

        return [
            'total_borrowings' => $totalBorrowings,
            'active_borrowings' => $activeBorrowings,
            'overdue_borrowings' => $overdueBorrowings,
            'total_fines' => $totalFines,
            'collected_fines' => $collectedFines
        ];
    }

    /**
     * Get all borrowings with book and user details
     */
    public function getAllBorrowings(): array
    {
        return $this->select('borrowings.*, books.title as book_title, users.fullname as user_name')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->join('users', 'users.id = borrowings.user_id')
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get active borrowings for a specific user with book details
     */
    public function getUserActiveBorrowings(int $userId): array
    {
        return $this->select('borrowings.*, books.title as book_title, books.cover_image')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('borrowings.user_id', $userId)
                   ->where('borrowings.status', 'borrowed')
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.due_date', 'ASC')
                   ->findAll();
    }

    /**
     * Get borrowing history for a specific user with book details
     */
    public function getUserBorrowingHistory(int $userId): array
    {
        return $this->select('borrowings.*, books.title as book_title, books.cover_image')
                   ->join('books', 'books.id = borrowings.book_id')
                   ->where('borrowings.user_id', $userId)
                   ->where('borrowings.status', 'returned')
                   ->where('borrowings.deleted_at IS NULL')
                   ->orderBy('borrowings.return_date', 'DESC')
                   ->findAll();
    }
} 