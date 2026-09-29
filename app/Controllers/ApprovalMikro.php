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
use App\Models\CaparModel;
use App\Models\MasModel;

class ApprovalMikro extends BaseController
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
           'List_Approval' => $AllModel->RequestEditMikro()

        ];
       // dd($data);
        echo view('AtRest/ApprovalMikro', $data);
       
    }
  
    public function Update()
    {
        $session = session();
        $CaparModel = New CaparModel;
        $MasModel = New MasModel;
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
        $type = $getpost['type'];
        session()->setFlashdata('Toast', 'Aprroved');
        if($type =='Capar'){
        $CaparModel->update($id, [
            
                'editable' => 1,
                'approve_edit' =>1
        ]);
        }
        
        if($type =='Volumetrik'){
        $MasModel->update($id, [
                'editable' => 1,
                'approve_edit' =>1
        ]);
        }
        
      
      return redirect()->back()->withInput();
    }

}
