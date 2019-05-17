<?php 

/**
 * 
 */
class Mahasiswa_model extends CI_Model
{
	
	function __construct()
	{
		# code...
	}

	public function getMahasiswa($nim = null){

		if($nim == null){
			return $this->db->get('mahasiswa')->result_array();
		}else{
			return $this->db->get_where('mahasiswa', ['nim' => $nim])->result_array();
		}
		
	}

	public function deleteMahasiswa($nim){
		$this->db->delete('mahasiswa', ['nim' => $nim]);

		return $this->db->affected_rows();
	}

	public function createMahasiswa($data){
		$this->db->insert('mahasiswa', $data);

		return $this->db->affected_rows();
	}

	public function updateMahasiswa($data, $nim){
		$this->db->update('mahasiswa', $data,  ['nim' => $nim]);

		return $this->db->affected_rows();

	}

}