<?php

namespace App\Controllers;

use App\Models\PpojModel;
use App\Models\CaparModel;
use App\Models\AllModel;
use App\Models\AhuModel;

class Capar extends BaseController
{
    public function index()
    {
        $PpojModel = new PpojModel();
        $CaparModel = new CaparModel;
        $AhuModel = new AhuModel;
        $AllModel = new AllModel();
        $data = [

            'List_PPOJ' => $PpojModel->findAll(),
            'List_AHU' => $PpojModel->List_CAPAR(),
            'List_Capar' => $CaparModel->findAll()

        ];
        return view('AtRest/capar', $data);
    }

    public function Ambil_Ruangan()
    {
        $AllModel = new AllModel();
        $no_ppoj = $this->request->getPost("no_ppoj");
        $GetRuangan = $AllModel->Pilih_Ruangan($no_ppoj);
        //selectData("master_data", array("nama_ahu" => $NamaAhu));

        echo json_encode($GetRuangan); // kirim data ke ajax yang ada di datappoj
    }
    public function Insert()
    {
        $session = session();
        $PpojModel = new PpojModel;
        $CaparModel = new CaparModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        $getpost = $this->request->getPost();

        $tpc = $getpost['tpc'];
        $kk = $getpost['kk'];
        $batch_data = [];
        foreach ($tpc as $no => $row) {

            $batch_data[] =
                [
                    'no_ppoj' => $getpost['ppoj'],
                    'nama_ruangan' => $getpost['ruangan'],
                    'id_ppoj' => $getpost['id_ppoj'],
                    'id_ahu'  => $getpost['id_ahu'],
                    'keterangan' => $getpost['keterangan'],
                    'kelas' => $getpost['kelas'],
                    'hasil_tpc' => $getpost['tpc'][$no],
                    'hasil_kk' => $getpost['kk'][$no],
                    'analis' => $session->get('username'),
                    'tanggal_dilakukan' => date('Y-m-d H:i:'),
                    'editable' => 1,
                    'approve_edit' =>1
                    //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
                ];
        }
        $CaparModel->insertBatch($batch_data);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->back()->withInput();
    }

    public function Update()
    {
        $session = session();
        $PpojModel = new PpojModel;
        $CaparModel = new CaparModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
        $id = $getpost['id'];


        $CaparModel->update($id, [

            'keterangan' => $getpost['keterangan'],
            'hasil_tpc' => $getpost['tpc'],
            'hasil_kk' => $getpost['kk'],
            'editable' => 0,
            'approve_edit' =>0
        ]);
        session()->setFlashdata('Toast', 'Data Berhasil diupdate');
        return redirect()->back()->withInput();
    }
    
    public function UpdateStatus()
    {
        $CaparModel = New CaparModel;
         $session = session();
        $AhuModel = New AhuModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $CaparModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
         
        $AhuModel->update($id_ahu, [
            
                'statusCapar' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
    
    public function ViewDetail($id)
    {
        $PpojModel = new PpojModel;
        $AllModel = new AllModel();
        $PpojModel = new PpojModel();
        $AhuModel = new AhuModel;
        $Detail_AHU = $PpojModel->where('id', $id)->first();
        $data = [
            // 'judul' => 'Daftar Antrian'
            'id_ahu' =>$id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Capar($id),
             'id'     => $id,
            'Detail_AHU' => $AhuModel->where('id', $id)->first()

        ];


     
         return view('AtRest/capar_detail', $data);
        // dd( $PpojModel->first($id));
        //dd($PpojModel->List_PPOJ_ID($Detail_AHU['ahu'],$Detail_AHU['tanggaldilakukan']));
      //  echo view('AtRest/datappoj_detail', $data);
        //dd($Detail_AHU);

    }

    public function AddCapar($id)
    {
        $PpojModel = new PpojModel;
        $AllModel = new AllModel();
        $PpojModel = new PpojModel();
        $AhuModel = new AhuModel;
        $CaparModel = new CaparModel();
        $Detail_AHU = $PpojModel->where('id', $id)->first();
        $titik_capar = $AllModel->DataCapar($Detail_AHU['nama_ruangan'])->titik_capar;
        $data = [
            // 'judul' => 'Daftar Antrian'
            'id' => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_CAPAR' => $CaparModel->where('id_ppoj', $id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id', $id)->first(),
            'titik_capar' => $titik_capar =='NA' ? 0 : $titik_capar,
            'total_capar' => $CaparModel->where('id_ppoj',$id)->countAllResults() ?? 0,
            'Syarat' => $AllModel->MasterData($Detail_AHU['nama_ruangan'])

        ];
      
       // dd($data);
        return view('AtRest/capar_add', $data);
    }
    
    public function RequestEdit()
    {
        $session = session();
        $CaparModel = new CaparModel();
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
      
        $CaparModel->update($id, [
            
                'editable' => 1
        ]);
       
      session()->setFlashdata('Toast', 'Request Edit Berhasil');
      return redirect()->back()->withInput();
    }
    public function Delete($id)
    {
        $CaparModel = new CaparModel;
        $CaparModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
