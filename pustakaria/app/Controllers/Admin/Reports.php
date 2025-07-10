<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\BorrowingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends BaseController
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
        $data = [
            'title' => 'Laporan'
        ];

        return view('admin/reports/index', $data);
    }

    public function borrowings()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        $status = $this->request->getGet('status');

        $query = $this->borrowingModel
            ->select('borrowings.*, books.title as book_title, users.fullname as user_name')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->where('borrowings.created_at >=', $startDate . ' 00:00:00')
            ->where('borrowings.created_at <=', $endDate . ' 23:59:59');

        if ($status) {
            $query->where('borrowings.status', $status);
        }

        $borrowings = $query->findAll();

        // Calculate statistics
        $totalBorrowings = count($borrowings);
        $totalReturned = array_filter($borrowings, fn($b) => $b['status'] === 'returned');
        $totalOverdue = array_filter($borrowings, function($b) {
            return $b['status'] === 'borrowed' && strtotime($b['due_date']) < strtotime('today');
        });

        $data = [
            'title' => 'Laporan Peminjaman',
            'borrowings' => $borrowings,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'statistics' => [
                'total' => $totalBorrowings,
                'returned' => count($totalReturned),
                'overdue' => count($totalOverdue)
            ]
        ];

        return view('admin/reports/borrowings', $data);
    }

    public function books()
    {
        $category = $this->request->getGet('category');
        $stock = $this->request->getGet('stock');

        $query = $this->bookModel->select('books.*, COUNT(borrowings.id) as borrow_count')
            ->join('borrowings', 'books.id = borrowings.book_id', 'left')
            ->groupBy('books.id');

        if ($category) {
            $query->where('books.category', $category);
        }

        if ($stock === 'low') {
            $query->where('books.stock <', 5);
        } elseif ($stock === 'out') {
            $query->where('books.stock', 0);
        }

        $books = $query->findAll();

        // Calculate statistics
        $totalBooks = count($books);
        $totalCategories = count(array_unique(array_column($books, 'category')));
        $lowStock = count(array_filter($books, fn($b) => $b['stock'] < 5));
        $outOfStock = count(array_filter($books, fn($b) => $b['stock'] === '0'));

        $data = [
            'title' => 'Laporan Buku',
            'books' => $books,
            'category' => $category,
            'stock' => $stock,
            'statistics' => [
                'total' => $totalBooks,
                'categories' => $totalCategories,
                'lowStock' => $lowStock,
                'outOfStock' => $outOfStock
            ]
        ];

        return view('admin/reports/books', $data);
    }

    public function exportBorrowings()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
        $status = $this->request->getGet('status');

        $borrowings = $this->borrowingModel
            ->select('borrowings.*, books.title as book_title, users.fullname as user_name')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->where('borrowings.created_at >=', $startDate . ' 00:00:00')
            ->where('borrowings.created_at <=', $endDate . ' 23:59:59');

        if ($status) {
            $borrowings->where('borrowings.status', $status);
        }

        $borrowings = $borrowings->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Peminjam');
        $sheet->setCellValue('C1', 'Buku');
        $sheet->setCellValue('D1', 'Tanggal Pinjam');
        $sheet->setCellValue('E1', 'Tanggal Kembali');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Keterlambatan (Hari)');

        // Style the header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('795548');
        $sheet->getStyle('A1:G1')->getFont()->getColor()->setRGB('FFFFFF');

        // Add data
        $row = 2;
        foreach ($borrowings as $index => $borrowing) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $borrowing['user_name']);
            $sheet->setCellValue('C' . $row, $borrowing['book_title']);
            $sheet->setCellValue('D' . $row, date('d/m/Y', strtotime($borrowing['borrow_date'])));
            $sheet->setCellValue('E' . $row, date('d/m/Y', strtotime($borrowing['due_date'])));
            $sheet->setCellValue('F' . $row, $borrowing['status'] === 'borrowed' ? 'Dipinjam' : 'Dikembalikan');
            
            // Calculate overdue days
            $overdueDays = 0;
            if ($borrowing['status'] === 'borrowed' && strtotime($borrowing['due_date']) < strtotime('today')) {
                $overdueDays = ceil((strtotime('today') - strtotime($borrowing['due_date'])) / (60 * 60 * 24));
            }
            $sheet->setCellValue('G' . $row, $overdueDays);

            $row++;
        }

        // Auto size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_peminjaman_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function exportBooks()
    {
        $category = $this->request->getGet('category');
        $stock = $this->request->getGet('stock');

        $books = $this->bookModel->select('books.*, COUNT(borrowings.id) as borrow_count')
            ->join('borrowings', 'books.id = borrowings.book_id', 'left')
            ->groupBy('books.id');

        if ($category) {
            $books->where('books.category', $category);
        }

        if ($stock === 'low') {
            $books->where('books.stock <', 5);
        } elseif ($stock === 'out') {
            $books->where('books.stock', 0);
        }

        $books = $books->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Penulis');
        $sheet->setCellValue('D1', 'Penerbit');
        $sheet->setCellValue('E1', 'ISBN');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->setCellValue('G1', 'Stok');
        $sheet->setCellValue('H1', 'Total Dipinjam');

        // Style the header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('795548');
        $sheet->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');

        // Add data
        $row = 2;
        foreach ($books as $index => $book) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $book['title']);
            $sheet->setCellValue('C' . $row, $book['author']);
            $sheet->setCellValue('D' . $row, $book['publisher']);
            $sheet->setCellValue('E' . $row, $book['isbn']);
            $sheet->setCellValue('F' . $row, $book['category']);
            $sheet->setCellValue('G' . $row, $book['stock']);
            $sheet->setCellValue('H' . $row, $book['borrow_count']);

            // Style low stock
            if ($book['stock'] < 5) {
                $sheet->getStyle('G' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFEBEE');
                $sheet->getStyle('G' . $row)->getFont()->getColor()->setRGB('D32F2F');
            }

            $row++;
        }

        // Auto size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_buku_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
} 