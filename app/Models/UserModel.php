<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'nama'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Cari user berdasarkan username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Verifikasi login
     */
    public function verifyLogin($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}