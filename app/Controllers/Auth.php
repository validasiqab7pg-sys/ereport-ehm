<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function Login()
    {
        return view('Login/login');
    }

    public function Register()
    {
        return view('Login/register');
    }

    public function Process_Login()
{
    $session = session();
    $getpost = $this->request->getPost();

    $user = (new UserModel())->where('username', $getpost['username'])->first();

    if ($user) {
        // cek password hash
        if (password_verify($getpost['password'], $user['password'])) {
            // cek status user
            if ($user['status'] !== 'approved') {
                $session->setFlashdata('Toast', [
                    'message' => 'Akun Anda belum disetujui admin.',
                    'type'    => 'error'
                ]);
                return redirect()->to('/Auth/Login');
            }

            // set session login
            $session->set([
                'isLogin'  => true,
                'username' => $user['username'],
                'jabatan'  => $user['jabatan'],
            ]);

            return redirect()->to('/Home');
        } else {
            $session->setFlashdata('Toast', [
                'message' => 'Password salah.',
                'type'    => 'error'
            ]);
            return redirect()->to('/Auth/Login');
        }
    } else {
        $session->setFlashdata('Toast', [
            'message' => 'Username tidak ditemukan.',
            'type'    => 'error'
        ]);
        return redirect()->to('/Auth/Login');
    }
}


    public function Process_Register()
    {
        $session = session();
        $getpost = $this->request->getPost();

        // hash password
        $hashedPassword = password_hash($getpost['password'], PASSWORD_BCRYPT);

        (new UserModel())->insert([ 
            'username'   => $getpost['username'],
            'password'   => $hashedPassword,
            'email'      => $getpost['email'],
            'department' => $getpost['department'],
            'jabatan'    => $getpost['jabatan'],
            'status'     => 'pending' // tambahkan kolom status di tabel user
        ]);

       $session->setFlashdata('Toast', [
        'message' => 'Registrasi berhasil, menunggu persetujuan admin.',
        'type'    => 'success'
        ]);

        return redirect()->to('/Auth/Login');
    }

    public function Logout()
    {
        session()->destroy();
        return redirect()->to('/Auth/Login');
    }
}
