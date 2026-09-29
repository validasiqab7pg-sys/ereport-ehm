<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\DpModel;
use App\Models\FlowModel;
use App\Models\LuxModel;
use App\Models\RhModel;
use App\Models\FileModel;
use CodeIgniter\Files\File;

class Approval extends BaseController
{
    
    public function index()
    {
        $PpojModel = new PpojModel();
        $SuhuModel = New SuhuModel;
        $AhuModel = New AhuModel;
        $AllModel = new AllModel();
        $FlowModel = new FlowModel();
        $data = [
            
           'List_PPOJ' => $PpojModel->findAll(),
           'List_AHU' => $PpojModel->List_SUHU(),
           'List_Suhu' => $SuhuModel->findAll(),
           'List_Ruangan' => $AllModel->List_Ruangan(),
           'List_Approval' => $AllModel->RequestEdit()

        ];
       // dd($data);
        echo view('AtRest/Approval', $data);
       
    }
  
    public function Update()
    {
        $session = session();
        $SuhuModel = New SuhuModel;
        $RhModel = New RhModel;
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
        $type = $getpost['type'];
        session()->setFlashdata('Toast', 'Aprroved');
        if($type =='Suhu'){
        $SuhuModel->update($id, [
            
                'editable' => 1,
                'approve_edit' =>1
        ]);
        }
        
        if($type =='Rh'){
        $RhModel->update($id, [
                'editable' => 1,
                'approve_edit' =>1
        ]);
        }
        
      
      return redirect()->back()->withInput();
    }

}
