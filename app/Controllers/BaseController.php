<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Modelkelas;
use App\Models\Modelspp;
use App\Models\Modelsiswa;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $db;
	protected $kelas;
	protected $spp; 
	//protected $buildersiswa;
	protected $siswa;

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();

		// membuat instance $this->kelas dari  Modelkelas
		$this->kelas = New Modelkelas;

		// membuat instance $this->spp dari  Modelspp
		$this->spp	= New Modelspp;

		// mengaktifkan query builder untuk tabel siswa
		//$this->db      	= \Config\Database::connect();
		//$this->buildersiswa	= $this->db->table('siswa');

		// membuat instance $this->spp dari  Modelsiswa
		$this->siswa	= New Modelsiswa;


	}
}
