<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password',
        'fullname',
        'phone',
        'role',
        'is_active',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[4]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'fullname' => 'required|min_length[3]',
        'phone'    => 'required|min_length[10]|max_length[15]',
        'role'     => 'required|in_list[admin,user]',
        'is_active'=> 'required|in_list[0,1]'
    ];
    
    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 4 karakter',
            'is_unique' => 'Username sudah digunakan'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah terdaftar'
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter'
        ],
        'fullname' => [
            'required' => 'Nama lengkap harus diisi',
            'min_length' => 'Nama lengkap minimal 3 karakter'
        ],
        'phone' => [
            'required' => 'Nomor telepon harus diisi',
            'min_length' => 'Nomor telepon minimal 10 digit',
            'max_length' => 'Nomor telepon maksimal 15 digit'
        ],
        'role' => [
            'required' => 'Role harus diisi',
            'in_list' => 'Role tidak valid'
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi',
            'in_list' => 'Status aktif tidak valid'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function findAllUsers()
    {
        return $this->select('id, username, email, fullname, role, is_active, created_at')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function findUserById($id)
    {
        return $this->select('id, username, email, fullname, role, is_active')
            ->where('id', $id)
            ->first();
    }

    public function activateUser($id)
    {
        return $this->update($id, ['is_active' => 1]);
    }

    public function deactivateUser($id)
    {
        return $this->update($id, ['is_active' => 0]);
    }

    public function updatePassword($id, $newPassword)
    {
        return $this->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    public function getTotalUsers()
    {
        return $this->countAllResults();
    }

    public function getTotalActiveUsers()
    {
        return $this->where('is_active', 1)->countAllResults();
    }

    public function getLatestUsers($limit = 5)
    {
        return $this->select('id, username, fullname, role, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->find();
    }

    public function findByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Verify user credentials
     */
    public function verifyCredentials($username, $password)
    {
        $user = $this->where('username', $username)
            ->orWhere('email', $username)
            ->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        if (!$user['is_active']) {
            return false;
        }

        return $user;
    }

    /**
     * Get active users
     */
    public function getActiveUsers()
    {
        return $this->where('is_active', 1)
            ->findAll();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
            ->findAll();
    }

    /**
     * Search users
     */
    public function search($keyword)
    {
        return $this->like('username', $keyword)
            ->orLike('email', $keyword)
            ->orLike('fullname', $keyword)
            ->findAll();
    }

    /**
     * Get user statistics
     */
    public function getStatistics()
    {
        return [
            'total_users' => $this->countAll(),
            'active_users' => $this->where('is_active', 1)->countAllResults(),
            'admin_count' => $this->where('role', 'admin')->countAllResults(),
            'user_count' => $this->where('role', 'user')->countAllResults()
        ];
    }
} 