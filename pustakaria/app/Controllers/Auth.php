<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        return redirect()->to('/auth/login');
    }

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to($this->_getRedirectUrl());
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to($this->_getRedirectUrl());
        }

        return view('auth/register', ['title' => 'Register']);
    }

    public function authenticate()
    {
        log_message('debug', '=== START AUTHENTICATION PROCESS ===');
        
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        log_message('debug', 'Attempting to authenticate email: ' . $email);
        log_message('debug', 'Input password length: ' . strlen($password));

        // Gunakan verifyCredentials dari UserModel
        $user = $this->userModel->verifyCredentials($email, $password);
        log_message('debug', 'Verification result: ' . ($user ? 'Success' : 'Failed'));

        if (!$user) {
            log_message('debug', 'Authentication failed for email: ' . $email);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah');
        }

        // Set session data
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'fullname' => $user['fullname'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true
        ];

        session()->set($sessionData);
        log_message('debug', 'Session data set successfully');

        // Redirect ke halaman yang sesuai
        $redirectUrl = $this->_getRedirectUrl();
        log_message('debug', 'Redirecting to: ' . $redirectUrl);

        return redirect()->to($redirectUrl);
    }

    public function doRegister()
    {
        log_message('debug', '=== START REGISTRATION PROCESS ===');
        
        $rules = [
            'fullname' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'terms' => 'required'
        ];

        if (!$this->validate($rules)) {
            log_message('debug', 'Registration validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Mohon periksa kembali form registrasi Anda.');
        }

        $password = $this->request->getPost('password');
        
        // Log password length untuk debugging
        log_message('debug', 'Original password length: ' . strlen($password));

        $userData = [
            'username' => $this->request->getPost('email'),
            'email' => $this->request->getPost('email'),
            'password' => $password, // Password akan di-hash oleh model callback
            'fullname' => $this->request->getPost('fullname'),
            'phone' => $this->request->getPost('phone'),
            'role' => 'user',
            'is_active' => 1
        ];

        try {
            log_message('debug', 'Attempting to insert user data');
            
            $inserted = $this->userModel->insert($userData);
            log_message('debug', 'User insertion result: ' . ($inserted ? 'Success' : 'Failed'));
            
            if ($inserted) {
                // Verify the inserted data
                $newUser = $this->userModel->where('email', $userData['email'])->first();
                log_message('debug', 'Verification of inserted user: ' . ($newUser ? 'Found' : 'Not Found'));
                if ($newUser) {
                    // Log hashed password length untuk verifikasi
                    log_message('debug', 'Stored hashed password length: ' . strlen($newUser['password']));
                }
            }
            
            return redirect()->to('/auth/login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        } catch (\Exception $e) {
            log_message('error', 'Error saat registrasi: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')
            ->with('success', 'Anda telah berhasil logout');
    }

    public function resetPassword($email = null)
    {
        // Debug log
        log_message('debug', 'Reset password method called');
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        
        // Jika ada email parameter, langsung reset
        if ($email) {
            log_message('debug', 'Email parameter provided: ' . $email);
            $user = $this->userModel->where('email', $email)->first();
            if (!$user) {
                return redirect()->to('/auth/reset-password')
                    ->with('error', 'Email tidak ditemukan');
            }

            // Reset password ke "123456"
            $newPassword = "123456";
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            try {
                $this->userModel->update($user['id'], ['password' => $hashedPassword]);
                return redirect()->to('/auth/login')
                    ->with('success', 'Password berhasil direset ke "123456". Silakan login dan ganti password Anda.');
            } catch (\Exception $e) {
                log_message('error', 'Error updating password: ' . $e->getMessage());
                return redirect()->to('/auth/reset-password')
                    ->with('error', 'Gagal mereset password. Silakan coba lagi.');
            }
        }

        // Jika tidak ada email parameter, tampilkan form
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'POST request received');
            
            // Log POST data
            $postData = $this->request->getPost();
            log_message('debug', 'POST data received: ' . json_encode($postData));
            
            $rules = [
                'email' => 'required|valid_email'
            ];

            if (!$this->validate($rules)) {
                log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors())
                    ->with('error', 'Email tidak valid');
            }

            $email = $this->request->getPost('email');
            log_message('debug', 'Processing email: ' . $email);
            
            try {
                // Check if user exists
                $user = $this->userModel->where('email', $email)->first();
                log_message('debug', 'User found: ' . ($user ? 'Yes' : 'No'));

                if (!$user) {
                    log_message('debug', 'Email not found in database');
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Email tidak ditemukan');
                }

                // Reset password ke "123456"
                $newPassword = "123456";
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update password
                log_message('debug', 'Attempting to update password for user ID: ' . $user['id']);
                $result = $this->userModel->update($user['id'], ['password' => $hashedPassword]);
                log_message('debug', 'Password update result: ' . ($result ? 'Success' : 'Failed'));

                if ($result) {
                    log_message('debug', 'Password reset successful');
                    return redirect()->to('/auth/login')
                        ->with('success', 'Password berhasil direset ke "123456". Silakan login dan ganti password Anda.');
                } else {
                    throw new \Exception('Failed to update password in database');
                }
            } catch (\Exception $e) {
                log_message('error', 'Error in reset password process: ' . $e->getMessage());
                log_message('error', 'Stack trace: ' . $e->getTraceAsString());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mereset password. Silakan coba lagi.');
            }
        }

        return view('auth/reset_password', ['title' => 'Reset Password']);
    }

    private function _getRedirectUrl()
    {
        $role = session()->get('role');
        return $role === 'admin' ? '/admin/dashboard' : '/user/dashboard';
    }
} 