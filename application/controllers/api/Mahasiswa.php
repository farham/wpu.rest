<?php 
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
/**
 * 
 */
class Mahasiswa extends REST_Controller
{
	
	public function __construct()
	{
		# code...
		parent::__construct();

		$this->load->model('Mahasiswa_model', 'mhs');
	}

	// Get
	public function index_get(){

		$nim = $this->get('nim');
		if($nim == null){
			$mahasiswa = $this->mhs->getMahasiswa();
		}else{
			$mahasiswa = $this->mhs->getMahasiswa($nim);
		}
		
		if($mahasiswa){
			$this->set_response([
                'status' => TRUE,
                'data' => $mahasiswa
            ], REST_Controller::HTTP_OK); 
		}else{
			$this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
		}

	}

	// POst
	public function index_post(){
		$data = array(
			'nim' => $this->post('nim'),
			'nama' => $this->post('nama'),
			'id_jurusan' => '1',
			'alamat' => 'Jalan - Jalan',
		);

		if($this->mhs->createMahasiswa($data) > 0){
			$this->set_response([
	                'status' => TRUE,
	                'message' => 'Mahasiswa Has been Created'
	        ], REST_Controller::HTTP_CREATED); 
		}else{
			$this->set_response([
                'status' => FALSE,
                'message' => 'Data Salah'
            ], REST_Controller::HTTP_BAD_REQUEST); 
		}
	}

	// Put
	public function index_put(){
		$nim = $this->put('nim');
		$data = array(
			'nim' => $this->put('nim'),
			'nama' => $this->put('nama'),
			'id_jurusan' => '1',
			'alamat' => 'Jalan - Jalan',
		);

		if($this->mhs->updateMahasiswa($data, $nim) > 0){
			$this->set_response([
	                'status' => TRUE,
	                'message' => 'Mahasiswa Has been Updated'
	        ], REST_Controller::HTTP_NO_CONTENT); 
		}else{
			$this->set_response([
                'status' => FALSE,
                'message' => 'Data Gagal'
            ], REST_Controller::HTTP_BAD_REQUEST); 
		}
	}


	// delete
	public function index_delete(){

		$nim = $this->delete('nim');

		if($nim == null){
			$this->set_response([
                'status' => FALSE,
                'message' => 'Profide nim'
            ], REST_Controller::HTTP_BAD_REQUEST); 
		}else{
			if($this->mhs->deleteMahasiswa($nim) > 0 ){
				//Hapus
				$this->set_response([
	                'status' => TRUE,
	                'nim' => $nim,
	                'message' => 'Deleted'
	            ], REST_Controller::HTTP_NO_CONTENT); 
			}else{
				// id Notfound
				$this->set_response([
                'status' => FALSE,
                'message' => 'Nim could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
			}
		}
	}
}