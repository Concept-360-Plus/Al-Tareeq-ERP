<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password_reset extends CI_Controller
{
    public function index()
    {
        $passwords = [
            1 => '1234',
            2 => 'test@123',
            3 => '12345',
            4 => '12345',
            5 => '12345',
            6 => '1234',
            7 => '12345'
        ];

        foreach ($passwords as $user_id => $plain_password) {

            $hash = password_hash($plain_password, PASSWORD_DEFAULT);

            $this->db->where('user_id', $user_id);
            $this->db->update('users', [
                'user_password' => $hash
            ]);

            echo "User ID {$user_id} updated.<br>";
            echo "Hash: {$hash}<br><br>";
        }
    }
}
