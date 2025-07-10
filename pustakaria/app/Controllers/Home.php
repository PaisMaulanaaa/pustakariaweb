<?php

namespace App\Controllers;

use App\Models\BookModel;

class Home extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        // Redirect ke dashboard jika sudah login
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('user/dashboard'));
            }
        }

        return redirect()->to('auth/login');
    }

    public function books()
    {
        $keyword = $this->request->getGet('keyword');
        $category = $this->request->getGet('category');

        $query = $this->bookModel;

        if ($keyword) {
            $query = $query->like('title', $keyword)
                          ->orLike('author', $keyword)
                          ->orLike('publisher', $keyword);
        }

        if ($category) {
            $query = $query->where('category', $category);
        }

        $data = [
            'title' => 'Katalog Buku',
            'books' => $query->paginate(12, 'books'),
            'pager' => $query->pager,
            'categories' => $this->bookModel->distinct()->select('category')->findAll(),
            'keyword' => $keyword,
            'category' => $category
        ];

        return view('books', $data);
    }

    public function book($id)
    {
        $book = $this->bookModel->find($id);

        if (!$book) {
            return redirect()->to('/books')->with('error', 'Buku tidak ditemukan');
        }

        $data = [
            'title' => $book['title'],
            'book' => $book,
            'related_books' => $this->bookModel->where('category', $book['category'])
                                              ->where('id !=', $id)
                                              ->limit(4)
                                              ->find()
        ];

        return view('book_detail', $data);
    }

    public function catalog()
    {
        $keyword = $this->request->getGet('keyword');
        $category = $this->request->getGet('category');

        $query = $this->bookModel;

        if ($keyword) {
            $query = $query->like('title', $keyword)
                          ->orLike('author', $keyword)
                          ->orLike('publisher', $keyword);
        }

        if ($category) {
            $query = $query->where('category', $category);
        }

        $data = [
            'title' => 'Katalog Buku',
            'books' => $query->paginate(12, 'books'),
            'pager' => $this->bookModel->pager,
            'keyword' => $keyword,
            'category' => $category,
            'categories' => $this->bookModel->distinct()->select('category')->findAll()
        ];

        return view('landing/catalog', $data);
    }
}
