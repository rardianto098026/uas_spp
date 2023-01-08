<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Petugas;

//memanggil package excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//memanggil package pdf
use Dompdf\Dompdf;

class PetugasController extends BaseController
{	
	// form login
	public function index()
	{
		return view('v_login');
	}

	// proses login
	public function login()
	{
		helper(['form']);
		$aturan=[
		'txtUsername'=>'required',
		'txtPassword'=>'required'	
		];

		if($this->validate($aturan)){
		$Datapetugas = New Petugas;
		//$_POST['txtUsername'];
		$syarat = [ 
			'username'=> $this->request->getPost('txtUsername'),
		     'password'=> md5($this->request->getPost('txtPassword'))
		];	

		// select * from petugas where username'' and pass=''	
		$Userpetugas = $Datapetugas->where($syarat)->find();
		
		if(count($Userpetugas)==1){
			// menyiapkan var sesion
			$session_data=[
				'id_petugas' 	=> $Userpetugas[0]['id_petugas'],
				'username' 	=> $Userpetugas[0]['username'],
				'level'	=> $Userpetugas[0]['level'],
				'sudahkahLogin' => TRUE
			];
			// membuat session
			session()->set($session_data);
			if(session()->get('level')=='admin'){
				return redirect()->to('/petugas/charts');
				exit;		
			}else{
				return redirect()->to('/petugas/dashboard');
			}

		}else{
			return redirect()->to('/petugas');
		}

	}
}

	public function logout(){
		session()->destroy();
		return redirect()->to('/petugas');
	}

	public function tampilPetugas(){
		// cek sudah logn atau belum
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}
		
		$Datapetugas = New Petugas;
		$data['ListPetugas'] = $Datapetugas->findAll();		
		return view('Petugas/tampil-petugas',$data);
	}

	public function tambahPetugas(){
		// untuk cek logim
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}

		return view('Petugas/tambah-petugas');
	}

	public function simpanPetugas(){
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}

		helper(['form']);
		$Datapetugas = New Petugas;
		$datanya=[
			'nama_petugas'=>$this->request->getPost('txtInputNama'),
			'username'=>$this->request->getPost('txtInputUser'),
			'password'=>md5($this->request->getPost('txtInputPassword')),
			'level'=>$this->request->getPost('selectLevel')
		];
		$Datapetugas->insert($datanya);
		return redirect()->to('/petugas/tampil');
	}

	public function hapusPetugas($idPetugas){
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}
		
		
		if(petugasInPembayaran($idPetugas)==0){
			$Datapetugas = New Petugas;
			$Datapetugas->where('id_petugas',$idPetugas)->delete();
			return redirect()->to('/petugas/tampil');
		} else {
			return redirect()->to('/petugas/tampil')->with('pesan-error','<div class="alert alert-danger">Gagal Hapus ! User tersebut telah melakukan proses input data pembayaran</div>');
		}
		
	}

	public function editPetugas($idPetugas){
		// cek apakah sudah login ?
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}

		$Datapetugas = New Petugas;
		$data['detailPetugas']=$Datapetugas->where('id_petugas',$idPetugas)->findAll();
		return view('Petugas/edit-petugas',$data);
	}

	public function updatePetugas(){
		// cek apakah sudah login
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

		// cek apakah yang login bukan admin ?
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/charts');
			exit;		
		}

		$Datapetugas = New Petugas;
		// jika kotak password tidak dikosongkan	
		if($this->request->getPost('txtInputPassword')){
			$data=[
				'nama_petugas'=>$this->request->getPost('txtInputNama'),
				'password'=>md5($this->request->getPost('txtInputPassword')),
				'level'=>$this->request->getPost('selectLevel')
				];
		} else {
		// jika kotak password  dikosongkan	
		$data=[
				'nama_petugas'=>$this->request->getPost('txtInputNama'),
				'level'=>$this->request->getPost('selectLevel')
			];
		}
		// UPDATE petugas SET nama_petugas='', level='' WHERE username='' 
		// 
		$Datapetugas->update($this->request->getPost('txtInputUser'),$data);
		return redirect()->to('/petugas/tampil');
	}

	function export_xls()
    {
		$Datapetugas = New Petugas;
		$data['ListPetugas'] = $Datapetugas->findAll();		

        //select data from table petugas
        $list = $data['ListPetugas'];

        //filename
        $fileName = 'ListPetugas.xlsx';

        //start package excel
        $spreadsheet = new Spreadsheet();

        //header
        $sheet = $spreadsheet->getActiveSheet();
        //(A1 : lokasi line & column excel, No : display data)
        $sheet->setCellValue('A1', 'No')->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('B1', 'Nama Petugas')->getColumnDimension('B')->setAutoSize(true);
        $sheet->setCellValue('C1', 'Username')->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('D1', 'Level User')->getColumnDimension('D')->setAutoSize(true);

        //body
        $line = 2;
        foreach ($list as $row) {
            $sheet->setCellValue('A'.$line, $line-1);
            $sheet->setCellValue('B'.$line, $row['nama_petugas']);
            $sheet->setCellValue('C'.$line, $row['username']);
            $sheet->setCellValue('D'.$line, $row['level']);
            $line++;
        }

        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    function export_pdf()
    {
		$Datapetugas = New Petugas;
		$data['ListPetugas'] = $Datapetugas->findAll();		

        //select data from table petugas
        $list = $data['ListPetugas'];

        //filename
        $fileName = 'petugas_export';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $output = [
            'list' => $list,
        ];
        $dompdf->loadHtml(view('Petugas/petugas_export_pdf', $output));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($fileName);
    }
}
