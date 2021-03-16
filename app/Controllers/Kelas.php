<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkelas;

class Kelas extends BaseController
{

	public function index()
	{

				
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/dashboard');
			exit;		
		}
	

		$dataKelas=NEW Modelkelas;
		$data['listKelas']=$dataKelas->findAll();
		return view('/Kelas/tampil',$data);
	}


	public function simpanKelas(){
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/dashboard');
			exit;		
		}
		// 1 membuat instance dari objek Modelkelas
		$dataKelas=NEW Modelkelas;
		// 2 menampung data dari form
		$data=[
			'nama_kelas'=>$this->request->getPost('txtNamaKelas'),
			'kompetensi_keahlian'=>$this->request->getPost('txtInputKompetensi')	
		];
		// 3 menyimpan kedalam tbl
		$dataKelas->save($data);
		// 4 arahkan kembali ke tampil kelas
		return redirect()->to('/kelas');
	}


	public function editKelas($idKelas){
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/dashboard');
			exit;		
		}
		// 1 membuat instance dari objek Modelkelas
		$dataKelas=NEW Modelkelas;
		// 2 ambil data kelas berdasarkan yg di klik
		$data['detailKelas']=$dataKelas->where('id_kelas',$idKelas)->find();
		return view('/Kelas/edit',$data);
	}

	public function updateKelas(){
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/dashboard');
			exit;		
		}
		
		// 1 membuat instance dari objek Modelkelas
		$dataKelas=NEW Modelkelas;
		// 2 menampung data dari form
		$data=[
			'nama_kelas'=>$this->request->getPost('txtNamaKelas'),
			'kompetensi_keahlian'=>$this->request->getPost('txtInputKompetensi')	
		];
		// 3 menjalanka proses update
		$dataKelas->update($this->request->getPost('txtIdKelas'),$data);
		// 4 arahkan ke halaman tampil kelas
		return redirect()->to('/kelas');	
	}


	public function hapusKelas($idKelas){
		if(session()->get('level')!='admin'){
			return redirect()->to('/petugas/dashboard');
			exit;		
		}
		// 1 membuat instance dari objek Modelkelas
		$dataKelas=NEW Modelkelas;
		// 2 menjalankan perintah hapus 
		$dataKelas->where('id_kelas',$idKelas)->delete();
		// 3 jika berhasil arahkan kembali ke tampil kelas
		return redirect()->to('/kelas');
	}


}