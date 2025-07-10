<?php

namespace App\Controllers\User;

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
        $userId = session()->get('user_id'); // Mengubah 'id' menjadi 'user_id'
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('user/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id'); // Mengubah 'id' menjadi 'user_id'
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/user/profile')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'fullname' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
        ];

        // Hanya tambahkan aturan password jika ada input password baru
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
            $rules['current_password'] = 'required|min_length[6]';
            $rules['new_password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[new_password]';
        }

        if ($this->request->getPost('email') !== $user['email']) {
            $rules['email'] .= '|is_unique[users.email,id,' . $userId . ']';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email')
        ];

        // Update password jika diisi
        if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
            if (!password_verify($currentPassword, $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Password saat ini tidak sesuai.');
            }
            $dataToUpdate['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $dataToUpdate);

        // Update session data
        $sessionData = [
            'fullname' => $dataToUpdate['fullname'],
            'email' => $dataToUpdate['email']
        ];
        session()->set($sessionData);

        return redirect()->to('/user/profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
