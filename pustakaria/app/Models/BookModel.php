<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title', 
        'author', 
        'publisher', 
        'year', 
        'isbn', 
        'category',
        'stock',
        'description',
        'cover_image',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'author' => 'required|min_length[3]|max_length[255]',
        'publisher' => 'required|min_length[3]|max_length[255]',
        'year' => 'required|numeric|exact_length[4]',
        'isbn' => 'required|min_length[10]|max_length[13]|is_unique[books.isbn,id,{id}]',
        'category' => 'required',
        'stock' => 'required|numeric|greater_than_equal_to[0]',
        'description' => 'required|min_length[10]',
        'cover_image' => 'permit_empty'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul buku harus diisi',
            'min_length' => 'Judul buku minimal 3 karakter',
            'max_length' => 'Judul buku maksimal 255 karakter'
        ],
        'author' => [
            'required' => 'Penulis harus diisi',
            'min_length' => 'Nama penulis minimal 3 karakter',
            'max_length' => 'Nama penulis maksimal 255 karakter'
        ],
        'publisher' => [
            'required' => 'Penerbit harus diisi',
            'min_length' => 'Nama penerbit minimal 3 karakter',
            'max_length' => 'Nama penerbit maksimal 255 karakter'
        ],
        'year' => [
            'required' => 'Tahun terbit harus diisi',
            'numeric' => 'Tahun terbit harus berupa angka',
            'exact_length' => 'Tahun terbit harus 4 digit'
        ],
        'isbn' => [
            'required' => 'ISBN harus diisi',
            'min_length' => 'ISBN minimal 10 karakter',
            'max_length' => 'ISBN maksimal 13 karakter',
            'is_unique' => 'ISBN sudah terdaftar'
        ],
        'category' => [
            'required' => 'Kategori harus diisi'
        ],
        'stock' => [
            'required' => 'Stok harus diisi',
            'numeric' => 'Stok harus berupa angka',
            'greater_than_equal_to' => 'Stok tidak boleh negatif'
        ],
        'description' => [
            'required' => 'Deskripsi harus diisi',
            'min_length' => 'Deskripsi minimal 10 karakter'
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

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['processImage'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['processImage'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = []; // Disabled deleteImage callback to prevent conflicts
    protected $afterDelete = [];

    /**
     * Process cover image before insert/update
     */
    protected function processImage(array $data)
    {
        // Skip if no cover_image data
        if (!isset($data['data']['cover_image'])) {
            return $data;
        }

        // If cover_image is already a filename (string), just return the data
        if (is_string($data['data']['cover_image'])) {
            return $data;
        }

        return $data;
    }

    /**
     * Delete cover image before deleting book
     */
    protected function deleteImage(array $data)
    {
        if (isset($data['id'])) {
            try {
                $book = $this->select('id, cover_image')->find($data['id']);
                if ($book && array_key_exists('cover_image', $book)) {
                    $coverImage = $book['cover_image'];
                    if (!empty($coverImage) && $coverImage !== 'default.jpg') {
                        $imagePath = FCPATH . 'uploads/covers/' . $coverImage;
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                            log_message('info', 'Model callback: Cover image deleted: ' . $coverImage);
                        }
                    }
                }
            } catch (\Exception $e) {
                log_message('warning', 'Model callback: Failed to delete cover image: ' . $e->getMessage());
                // Don't throw exception, just log and continue
            }
        }
        return $data;
    }

    /**
     * Get popular books based on borrowing count
     */
    public function getPopularBooks(int $limit = 5): array
    {
        $builder = $this->db->table('books b');
        $builder->select('b.*, COUNT(br.id) as borrow_count');
        $builder->join('borrowings br', 'br.book_id = b.id', 'left');
        $builder->where('b.deleted_at IS NULL');
        $builder->where('b.stock >', 0);
        $builder->groupBy('b.id');
        $builder->orderBy('borrow_count', 'DESC');
        $builder->limit($limit);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get books by category
     */
    public function getBooksByCategory(string $category, int $limit = 5): array
    {
        return $this->where('category', $category)
                   ->where('stock >', 0)
                   ->where('deleted_at IS NULL')
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    /**
     * Search books by keyword
     */
    public function searchBooks(string $keyword = '', ?string $category = null): array
    {
        $builder = $this->builder();
        
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('title', $keyword)
                    ->orLike('author', $keyword)
                    ->orLike('publisher', $keyword)
                    ->orLike('isbn', $keyword)
                    ->groupEnd();
        }

        if ($category) {
            $builder->where('category', $category);
        }

        return $builder->where('deleted_at IS NULL')
                      ->orderBy('title', 'ASC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get all available categories
     */
    public function getCategories(): array
    {
        return $this->select('category')
                   ->distinct()
                   ->where('deleted_at IS NULL')
                   ->orderBy('category', 'ASC')
                   ->findAll();
    }

    /**
     * Get similar books based on category
     */
    public function getSimilarBooks(int $bookId, int $limit = 3): array
    {
        $book = $this->find($bookId);
        if (!$book) {
            return [];
        }

        return $this->where('category', $book['category'])
                   ->where('id !=', $bookId)
                   ->where('stock >', 0)
                   ->where('deleted_at IS NULL')
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    /**
     * Get book statistics
     */
    public function getBookStats(): array
    {
        $builder = $this->builder();
        
        $totalBooks = $builder->where('deleted_at IS NULL')->countAllResults();
        $totalCategories = $this->select('category')
                               ->distinct()
                               ->where('deleted_at IS NULL')
                               ->countAllResults();
        $outOfStock = $builder->where('stock', 0)
                             ->where('deleted_at IS NULL')
                             ->countAllResults();
        $totalStock = $builder->selectSum('stock')
                             ->where('deleted_at IS NULL')
                             ->get()
                             ->getRow()
                             ->stock ?? 0;
        
        return [
            'total_books' => $totalBooks,
            'total_categories' => $totalCategories,
            'out_of_stock' => $outOfStock,
            'total_stock' => $totalStock
        ];
    }

    /**
     * Update book stock
     */
    public function updateStock(int $bookId, int $quantity): bool
    {
        $book = $this->find($bookId);
        if (!$book) {
            return false;
        }

        $newStock = $book['stock'] + $quantity;
        if ($newStock < 0) {
            return false;
        }

        return $this->update($bookId, ['stock' => $newStock]);
    }

    /**
     * Check if book is available for borrowing
     */
    public function isAvailable(int $bookId): bool
    {
        $book = $this->find($bookId);
        return $book && $book['stock'] > 0;
    }

    /**
     * Get latest books
     */
    public function getLatestBooks(int $limit = 5): array
    {
        return $this->where('deleted_at IS NULL')
                   ->where('stock >', 0)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    /**
     * Get low stock books (stock <= 5)
     */
    public function getLowStockBooks(int $threshold = 5): array
    {
        return $this->where('stock <=', $threshold)
                   ->where('stock >', 0)
                   ->where('deleted_at IS NULL')
                   ->orderBy('stock', 'ASC')
                   ->find();
    }

    /**
     * Decrease book stock by 1
     */
    public function decreaseStock(int $bookId): bool
    {
        $book = $this->find($bookId);
        if (!$book || $book['stock'] <= 0) {
            return false;
        }

        return $this->update($bookId, [
            'stock' => $book['stock'] - 1
        ]);
    }

    /**
     * Increase book stock by 1
     */
    public function increaseStock(int $bookId): bool
    {
        $book = $this->find($bookId);
        if (!$book) {
            return false;
        }

        return $this->update($bookId, [
            'stock' => $book['stock'] + 1
        ]);
    }
} 