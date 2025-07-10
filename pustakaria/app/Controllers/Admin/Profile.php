<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/auth/logout');
        }

        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/auth/logout');
        }

        $rules = [
            'fullname' => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,$userId]",
            'phone' => 'permit_empty|min_length[10]|max_length[15]',
            'address' => 'permit_empty|min_length[10]',
            'current_password' => 'permit_empty|min_length[6]',
            'new_password' => 'permit_empty|min_length[6]',
            'confirm_password' => 'permit_empty|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address')
        ];

        // Jika ada password baru
        if ($this->request->getPost('current_password')) {
            // Verifikasi password lama
            if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Password saat ini tidak sesuai');
            }

            $updateData['password'] = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        }

        if (!$this->userModel->update($userId, $updateData)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate profil');
        }

        // Update session data
        session()->set([
            'fullname' => $updateData['fullname'],
            'email' => $updateData['email']
        ]);

        return redirect()->to('/admin/profile')
            ->with('success', 'Profil berhasil diupdate');
    }
} 