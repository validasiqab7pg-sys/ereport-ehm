<?php

namespace App\Controllers;
use App\Models\AllModel;
use App\Models\UserModel;
class Home extends BaseController
{
    public function index()//: string
    {
         return view('index');
       
    }
    public function Swab()
    {
        return view('index2'); // memuat app/Views/index2.php
    }
    public function Setting()
    {
        $modeluser = new UserModel();
        $session = session();
        $username = $session->get('username');
        $data = [
           
            'getdata' => $modeluser->where('username', $username)->first(),
            'judul' => 'Setting'

        ];

        //dd($data);
        echo view('Home/profile', $data);
    }
    public function UpdatePassword()
{
    $modeluser = new UserModel();
    $getpost = $this->request->getPost();
    $id = $getpost['id'];
    $password = $getpost['password'];
    $newpassword = $getpost['newpassword'];
    $repassword = $getpost['repassword'];

    // Cari data user
    $user = $modeluser->where('id', $id)->first();

    // Cek password lama menggunakan password_verify
    if (! password_verify($password, $user['password'])) {
        session()->setFlashdata('Toast', [
            'message' => 'Password salah',
            'type'    => 'error'
        ]);
        return redirect()->to('/Home/Setting');
    }

    // Cek apakah password baru sama
    if ($newpassword !== $repassword) {
        session()->setFlashdata('repassword', 'Password baru dan konfirmasi password tidak cocok');
        return redirect()->to('/Home/Setting');
    }

    // Jika benar semua, hash password baru
    $hashed = password_hash($newpassword, PASSWORD_BCRYPT);

    $modeluser->update($id, ['password' => $hashed]);

    session()->setFlashdata('Toast', [
    'message' => 'Password berhasil diubah',
    'type'    => 'success'
    ]);
    return redirect()->to('/Home/Setting'); // tetap di halaman setting agar bisa lihat pesan
}

}
