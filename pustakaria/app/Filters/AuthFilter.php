<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        // Check role-based access
        $uri = $request->getUri()->getPath();
        $role = session()->get('role');

        // Remove leading slash if exists
        $uri = ltrim($uri, '/');

        if (strpos($uri, 'admin') === 0 && $role !== 'admin') {
            return redirect()->to('/user/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }

        if (strpos($uri, 'user') === 0 && $role !== 'user') {
            return redirect()->to('/admin/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 