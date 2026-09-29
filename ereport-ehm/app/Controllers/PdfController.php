<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use Dompdf\Dompdf;
use Dompdf\Options;
class PdfController extends Controller
{
    // public function index() 
	// {
    //     return view('pdf_view');
    // }

    // function htmlToPDF(){
       
    //     $dompdf = new \Dompdf\Dompdf(); 
       
    //     $dompdf->loadHtml(view('pdf_view'));
    //     $dompdf->setPaper('A4', 'landscape');
    //     $dompdf->render();
    //     $dompdf->stream();
    // }
    // public function index()
    // {
    //     // Load view 'AtRest/laporan_pdf'
    //     return view('AtRest/laporan_pdf');
    // }
    public function GetPDF($id)
    {
       // $dompdf = new Dompdf();
        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $AhuModel = New AhuModel;
        $data = [
            'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
            'Detail_AHU' => $AhuModel->where('id',$id)->first()
        ];
      
        $html = view('resume', $data);
      //  $html = view('AtRest/table', $data);
     

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('resume.pdf', [ 'Attachment' => false ]);
        //echo view('AtRest/table', $data);
    }
 
    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
 
    // public function generate() {
    //     // Load TCPDF library
    //     $tcpdf = new TCPDF();

    //     // Set judul dokumen
    //     $tcpdf->SetTitle('Data PDF');

    //    // Atur jenis kertas ke A4
    //    $tcpdf->setPaper('A4', 'landscape');


    //     // Tambahkan halaman baru
    //     $tcpdf->AddPage();

    //     // Panggil view untuk mendapatkan HTML
    //     $html = view('AtRest/laporan_pdf');

    //     // Tambahkan konten ke dokumen PDF
    //     $tcpdf->writeHTML($html);

    //     // Kelola output PDF
    //     $tcpdf->Output('output.pdf', 'D');
    // }
}

// use Dompdf\Dompdf;

// class PdfController extends Controller
// {
//     public function index()
//     {
//         return view('AtRest/laporan_pdf');
//     }

//     public function generate()
//     {
       
//         date_default_timezone_set('Asia/Jakarta');
//         $filename = date('y-m-d/H:i:s'). '/E-Report';

//         // instantiate and use the dompdf class
//         $dompdf = new Dompdf();

//         // load HTML content
//         $dompdf->loadHtml(view('AtRest/laporan_pdf'));

//         // (optional) setup the paper size and orientation
//         $dompdf->setPaper('A4', 'landscape');

//         // render html as PDF
//         $dompdf->render();

//         // output the generated pdf
//         $dompdf->stream($filename);
//     }
// } 

