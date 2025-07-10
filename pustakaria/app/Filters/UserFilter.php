<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('role') !== 'user') {
            return redirect()->to('/auth/login')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (!session()->get('is_active')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 