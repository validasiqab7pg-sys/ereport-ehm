<?php

namespace App\Controllers;
use App\Models\UserModel;
class Ruangan extends BaseController
{
    public function index(): string
    {
       // return view('AtRest/dp'); OLD
       $users= new UserModel();
        $data = [
            'judul' => 'List Pasien',
            'data_user' => $users -> findAll()
           

        ];
        dd($data);
        //echo view('ListUser/index', $data);
        //  return view('AtRest/rh');  NEW
    }

    
}
