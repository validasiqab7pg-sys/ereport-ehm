<?php
namespace App\Controllers;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    public function index() {
        if (session('jabatan') !== 'administrator') {
            return redirect()->to('/');
        }

        $users = (new UserModel())->findAll();
        return view('AtRest/user_management', ['users' => $users]);
    }

    public function approve($id) {
        (new UserModel())->update($id, ['status' => 'approved']);
        return redirect()->to('/UserManagement');
    }

    public function reject($id) {
        (new UserModel())->update($id, ['status' => 'rejected']);
        return redirect()->to('/UserManagement');
    }
    public function delete($id) {
    // Cek apakah user saat ini administrator
    if (session('jabatan') !== 'administrator') {
        return redirect()->to('/'); // atau tampilkan pesan error
    }

    // Hapus user berdasarkan ID
    (new UserModel())->delete($id);

    // Set pesan sukses
    session()->setFlashdata('Toast', [
        'message' => 'User berhasil dihapus',
        'type'    => 'success'
    ]);

    return redirect()->to('/UserManagement');
}
}
