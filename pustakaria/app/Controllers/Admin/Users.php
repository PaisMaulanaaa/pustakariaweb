<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAllUsers()
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru'
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'fullname' => 'required|min_length[3]',
            'role' => 'required|in_list[admin,user]',
            'is_active' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'fullname' => $this->request->getPost('fullname'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active')
        ];

        if (!$this->userModel->insert($userData)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan user baru');
        }

        return redirect()->to('/admin/users')
            ->with('success', 'User baru berhasil ditambahkan');
    }

    public function edit($id = null)
    {
        $user = $this->userModel->findUserById($id);

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id = null)
    {
        $user = $this->userModel->findUserById($id);

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'User tidak ditemukan');
        }

        $rules = [
            'username' => "required|min_length[4]|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'fullname' => 'required|min_length[3]',
            'role' => 'required|in_list[admin,user]',
            'is_active' => 'required|in_list[0,1]'
        ];

        // Add password validation only if password is being updated
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'fullname' => $this->request->getPost('fullname'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active')
        ];

        // Only update password if it's provided
        if ($this->request->getPost('password')) {
            $userData['password'] = $this->request->getPost('password');
        }

        if (!$this->userModel->update($id, $userData)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate user');
        }

        return redirect()->to('/admin/users')
            ->with('success', 'User berhasil diupdate');
    }

    public function delete($id = null)
    {
        $user = $this->userModel->findUserById($id);

        if (!$user) {
            return redirect()->to('/admin/users')
                ->with('error', 'User tidak ditemukan');
        }

        // Prevent deleting own account
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/admin/users')
                ->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        if (!$this->userModel->delete($id)) {
            return redirect()->to('/admin/users')
                ->with('error', 'Gagal menghapus user');
        }

        return redirect()->to('/admin/users')
            ->with('success', 'User berhasil dihapus');
    }

    public function activate($id = null)
    {
        if (!$this->userModel->activateUser($id)) {
            return redirect()->to('/admin/users')
                ->with('error', 'Gagal mengaktifkan user');
        }

        return redirect()->to('/admin/users')
            ->with('success', 'User berhasil diaktifkan');
    }

    public function deactivate($id = null)
    {
        $user = $this->userModel->findUserById($id);

        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/admin/users')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri');
        }

        if (!$this->userModel->deactivateUser($id)) {
            return redirect()->to('/admin/users')
                ->with('error', 'Gagal menonaktifkan user');
        }

        return redirect()->to('/admin/users')
            ->with('success', 'User berhasil dinonaktifkan');
    }
} 