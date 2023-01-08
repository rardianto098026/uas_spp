<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Petugas;
use App\Models\Modelbayar;
use App\Models\Modelsiswa;
use App\Models\Modelspp;

class Dashboardpetugas extends BaseController
{
	public function index()
	{
		return view('Dashboard');
	}

	public function initChart() {
		// cek sudah logn atau belum
		if(!session()->get('sudahkahLogin')){
			return redirect()->to('/petugas');
			exit;
		}

        $db = \Config\Database::connect();
        $this->siswa->join('kelas','kelas.id_kelas=siswa.id_kelas');
		$this->siswa->join('spp','spp.id_spp=siswa.id_spp');
        $recordsiswa=$this->siswa->select("COUNT(`siswa`.id_kelas) as count, nama_kelas")->groupby("nama_kelas")->findAll();

        $this->bayar->join('spp','spp.id_spp=pembayaran.id_spp');
        $recordpembayaran=$this->bayar->select("COUNT(`pembayaran`.id_spp) as count, nominal")->groupby("nominal")->findAll();

        $bayar = [];
        $siswa = [];
        foreach($recordsiswa as $row) {
            // print($row["nama_kelas"]);
            $siswa[] = array(
                'count'     => $row["count"],
                'nama_kelas'   => $row["nama_kelas"]
            );
        }

        foreach($recordpembayaran as $row) {
            // print($row["nama_kelas"]);
            $bayar[] = array(
                'count'     => $row["count"],
                'nominal'   => $row["nominal"]
            );
        }
        
        $data['siswa'] = ($siswa);    
        $data['bayar'] = ($bayar);   
        return view('chart', $data);                
    }
}
