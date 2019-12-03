<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends CI_Controller {

	function __construct(){
		parent::__construct();

	}

  public function index(){

		$data['konten'] = 'prediksi';
		$data['data'] = 'haha';
    $this->load->view('index.php',$data);
  }

	function simpan_aktual(){
		$data_post = $this->input->post();
		$this->db->where('bulan',$data_post['bulan']);
		$this->db->where('tahun',$data_post['tahun']);
		$cek = $this->db->get('t_stok')->num_rows();
		if($cek == 0){
				$this->db->insert('t_stok',$data_post);
		}
		redirect('utama/index');
	}

	function delete_aktual($id){
		$this->db->where('id',$id);
		$this->db->delete('t_stok');
		redirect('utama/index');
	}

	function updateprakiraan(){
		$data_post = $this->input->post();
		$this->db->where('id_prakiraan',1);
		$this->db->update('t_prakiraan',$data_post);
		redirect('utama/index');
	}

}
?>
