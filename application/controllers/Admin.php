<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
 		if($this->session->userdata('status') != "login" || $this->session->userdata('user_jenis') != "admin"){
			redirect(base_url("login"));
		}
	}

	function index(){
		$data = array(
			'page'				=> "index",
			'header'			=> "Dashboard Admin",
			'link'				=> base_url()
		);
		$this->load->view("admin/admin/layout.php",$data);
  }

	function add_berita(){
		$data = array(
			'page'				=> "add_berita",
			'header'			=> "Tambah Berita",
			'link'				=> base_url()
		);
		$this->load->view("admin/admin/layout.php",$data);
  }

	// star dashboard
    function add_das(){
        $create['judul'] 				= $this->input->post('judul');
        $create['konten']    			= $this->input->post('konten');

        $config['upload_path'] 		    = './assets/upload/berita/';
        $config['file_name'] 					= strtolower($create['judul']);
        $config['allowed_types'] 	    = 'jpg|png|doc|pdf|docx|xls|xlsx';
        $config['max_size']     	    = 10000;
        $config['overwrite']					= true;
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file_nama')){
            $updata = $this->upload->data();
            $create['file_nama'] = 'assets/upload/berita/'.$updata['file_name'];
            $create['file_nama'] = strtolower($create['file_nama']);
        }
				if ($this->upload->do_upload('nama_file')){
            $data = $this->upload->data();
            $create['nama_file'] = 'assets/upload/berita/'.$data['file_name'];
            $create['nama_file'] = strtolower($create['nama_file']);
        }
        if($this->db->insert('dashboard',$create)){
            $this->session->set_flashdata('sukses',"Data Berita Berhasil Di Tambah");
            redirect('Admin');
        }
        redirect('Admin');

    }

	function das_detail(){
		$id_das = $this->input->post('id_das');
		$where = array("id_das" => $id_das);
		$data = $this->DATA->GetdataWhere('dashboard',$where)->result_array();
		echo json_encode($data);
	}

    function edit_das(){
        // $data = $this->input->post();
        // $this->db->where('id_das', $this->input->post('id_das'));
        // $this->db->update('dashboard',$data);
        // $this->session->set_flashdata('sukses',"Data Berita Berhasil Di Edit");
        // redirect('Admin');
        $create['judul'] 				= $this->input->post('judul');
        $id = $this->input->post('id_das');
        $where = array("id_das" => $id);
        $data = $this->DATA->GetdataWhere('dashboard',$where)->row();
        $path                           = './'.$data->file_nama;
        $config['upload_path'] 		    = './assets/upload/berita/';
        $config['file_name'] 			= strtolower($create['judul']);
        $config['allowed_types'] 	    = 'jpg|png';
        $config['max_size']     	    = 10000;
        $config['overwrite']			= true;
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file_nama')){
            $updata = $this->upload->data();
            $where = array("id_das" => $id);
            $create['file_nama'] = 'assets/upload/berita/'.$updata['file_name'];
            $create['file_nama'] = strtolower($create['file_nama']);
            unlink($path.$updata);
            $this->DATA->updated('dashboard',$where,$create);
            $this->session->set_flashdata('sukses',"Data Berita Berhasil Di Edit");
            redirect('Admin');
        }
    }

    function hapus_das($id){
        if($id==""){
            $this->session->set_flashdata('error',"Berita Gagal Di Hapus");
            redirect('Admin');
        }else{
            $where = array("id_das" => $id);
            $data = $this->DATA->GetdataWhere('dashboard',$where)->row();
            unlink('./'.$data->file_nama);
            unlink('./'.$data->nama_file);
            $this->db->where('id_das', $id);
            $this->db->delete('dashboard');
            $this->session->set_flashdata('sukses',"Berita Berhasil Dihapus");
            redirect('Admin');
        }
	}

	function readmore(){
		$id = $this->uri->segment(3);
		$data = array(
			'page'				=> "readmore",
			'header'			=> "ReadMore Berita",
			'data'				=> $this->DATA->readmore($id),
			'link'				=> base_url()
		);
		$this->load->view("admin/admin/layout.php",$data);
  }
	// end dashboard

	// star data umat
	function data($wilayah_id = NULL,$lingkungan_id = NULL){
		if(!$this->input->post('statusumat')){
			$status = NULL;
			$navstatus = "aktif";
		}else{
			$navstatus = $this->input->post('statusumat');
			if($this->input->post('statusumat') == "aktif"){
					$status = NULL;
			}else if($this->input->post('statusumat') == "meninggal"){
					$status = "Meninggal";
			}else if($this->input->post('statusumat') == "pindah"){
					$status = "Pindah";
			}
		}
        if($wilayah_id == NULL && $lingkungan_id == NULL){
            $data_umat =  $this->DATA->join_lima('data_umat','kk_detail','user','lingkungan','wilayah','kk_id','user_id','lingkungan_id','wilayah_id',array('data_umat.status'=>$status),'data_umat.umat_id');
            $nama_header = "Data Seluruh Umat";
            $link = base_url('admin/data/'.$wilayah_id.'/'.$lingkungan_id);
        }else if($wilayah_id != NULL && $lingkungan_id == NULL){
            $data_umat =  $this->DATA->join_lima_where('data_umat','kk_detail','user','lingkungan','wilayah','kk_id','user_id','lingkungan_id','wilayah_id',array('user.wilayah_id' => $wilayah_id, 'data_umat.status'=>$status),'data_umat.umat_id');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_header = "Semua Data Umat Di Wilayah ".$nama_wilayah[0]->wilayah_nama." ";
            $link = base_url('admin/data/'.$wilayah_id.'/'.$lingkungan_id);
        }else{
            $data_umat =  $this->DATA->join_lima_where('data_umat','kk_detail','user','lingkungan','wilayah','kk_id','user_id','lingkungan_id','wilayah_id',array('user.lingkungan_id' => $lingkungan_id, 'data_umat.status'=>$status),'data_umat.umat_id');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_lingkungan = $this->db->query('select lingkungan_nama from lingkungan where lingkungan_id = '.$lingkungan_id.'')->result();
            $nama_header = "Data Umat di ".$nama_wilayah[0]->wilayah_nama." - ".$nama_lingkungan[0]->lingkungan_nama."";
            $link = base_url('admin/data/'.$wilayah_id.'/'.$lingkungan_id);
        }
				$data = array(
					'umat' 			 	=> $data_umat->result(),
					'jml_plamongan'   	=> $this->DATA->Umat('data_umat', '2','Plamongan Indah')->num_rows(),
					'jml_pucanggading' 	=> $this->DATA->Umat('data_umat', '3','Pucang Gading')->num_rows(),
					'jml_mranggen' 		=> $this->DATA->Umat('data_umat', '4','Mranggen')->num_rows(),
		      'page'				=> "data",
					'navstatus'			=> $navstatus,
		      'lingkungan_id'     => $lingkungan_id,
		      'wilayah_id'        => $wilayah_id,
					'header'			=> $nama_header,
					'link'				=> $link
				);
				$this->load->view("admin/admin/layout.php",$data);
	}

	function data_detail(){
		$umat_id = $this->input->post('umat_id');
		$where = array("umat_id" => $umat_id);
		$data = $this->DATA->GetdataWhere('data_umat',$where)->result_array();
		echo json_encode($data);
	}

	function cek_nik(){
        if($this->DATA->cek_nik($_POST["nik"]) > 0){
			echo 'Ada';
        }else{
            echo '<label class="text-success"><img src="../assets/dauphin/images/tick.png"></label>';
        }
	}

	function add_datumat(){
        $this->form_validation->set_rules('no_nik', 'no_nik', 'required');
        $this->form_validation->set_rules('kk_id', 'kk_id', 'required');
        $this->form_validation->set_rules('umat_nama', 'umat_nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('hub_keluarga', 'hub_keluarga', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'required');
        $this->form_validation->set_rules('goldar', 'goldar', 'required');
        $this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'pendidikan_akhir', 'required');
				$cek 	= $this->DATA->GetWhere('data_umat', array('no_nik' => $this->input->post('no_nik')));
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Umat Gagal Di Tambahkan!!");
            redirect('Admin/Data');
        }else{
          $data=array(
						'no_nik'				=> $this->input->post('no_nik'),
						'kk_id'					=> $this->input->post('kk_id'),
						'umat_nama'				=> $this->input->post('umat_nama'),
						'jenis_kelamin'			=> $this->input->post('jenis_kelamin'),
						'hub_keluarga'			=> $this->input->post('hub_keluarga'),
						'domisili'				=> $this->input->post('domisili'),
						'tgl_lahir'				=> $this->input->post('tgl_lahir'),
						'goldar'				=> $this->input->post('goldar'),
						'pekerjaan'				=> $this->input->post('pekerjaan'),
						'pendidikan_akhir'		=> $this->input->post('pendidikan_akhir'),
						'keahlian'				=> $this->input->post('keahlian'),
						'keterangan'			=> $this->input->post('keterangan'),
            );
            $this->db->insert('data_umat',$data);
            $this->session->set_flashdata('sukses',"Data Umat Berhasil Disimpan");
            redirect('Admin/Data');
        }
    }

    function edit_umat(){
        $this->form_validation->set_rules('no_nik', 'no_nik', 'required');
        $this->form_validation->set_rules('kk_id', 'kk_id', 'required');
        $this->form_validation->set_rules('umat_nama', 'umat_nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('hub_keluarga', 'hub_keluarga', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'required');
        $this->form_validation->set_rules('goldar', 'goldar', 'required');
        $this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'pendidikan_akhir', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Umat Gagal Di Edit");
            redirect('Admin/Data');
        }else{
        	$data=array(
						'no_nik'				=> $this->input->post('no_nik'),
						'kk_id'					=> $this->input->post('kk_id'),
						'umat_nama'				=> $this->input->post('umat_nama'),
						'jenis_kelamin'			=> $this->input->post('jenis_kelamin'),
						'hub_keluarga'			=> $this->input->post('hub_keluarga'),
						'domisili'				=> $this->input->post('domisili'),
						'tgl_lahir'				=> $this->input->post('tgl_lahir'),
						'goldar'				=> $this->input->post('goldar'),
						'pekerjaan'				=> $this->input->post('pekerjaan'),
						'pendidikan_akhir'		=> $this->input->post('pendidikan_akhir'),
						'keahlian'				=> $this->input->post('keahlian'),
						'keterangan'			=> $this->input->post('keterangan'),
            );
            $this->db->where('umat_id', $this->input->post('umat_id'));
            $this->db->update('data_umat',$data);
						$data_riwayat=array(
									'umat_id'       => $this->input->post('umat_id'),
									'kk_id'					=> NULL,
									'status'        => 'Edit Umat',
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);
            $this->session->set_flashdata('sukses',"Data Umat Berhasil Diedit");
            redirect('Admin/Data');
        }
    }

    function hapus_umat(){
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('status_keterangan', 'status_keterangan', 'required');
        $this->form_validation->set_rules('tgl_status', 'tgl_status', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Umat Gagal Di Hapus");
            redirect('Admin/Data');
        }else{
            $data=array(
							'status'				=> $this->input->post('status'),
							'status_keterangan'		=> $this->input->post('status_keterangan'),
							'tgl_status'			=> $this->input->post('tgl_status'),
            );
            $this->db->where('umat_id', $this->input->post('umat_id'));
            $this->db->update('data_umat',$data);

						$data_riwayat=array(
									'umat_id'       => $this->input->post('umat_id'),
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => $this->input->post('status'),
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);

            $this->session->set_flashdata('sukses',"Data Umat Berhasil DiHapus");
            redirect('Admin/Data');
        }
			}

	    function restore_umat(){
	        $this->form_validation->set_rules('umat_id', 'umat_id', 'required');
	        if($this->form_validation->run()==FALSE){
	            $this->session->set_flashdata('error',"Data Umat Gagal Di Restore");
	            redirect('Admin/Data');
	        }else{
	            $data=array(
								'status'				=> NULL,
								'status_keterangan'		=> NULL,
								'tgl_status'			=> NULL,
	            );
	            $this->db->where('umat_id', $this->input->post('umat_id'));
	            $this->db->update('data_umat',$data);

							$data_riwayat=array(
										'umat_id'       => $this->input->post('umat_id'),
										'kk_id'					=> NULL,
										'status'        => "Aktif Kembali",
										'tgl_status'	=> date("Y-m-d"),
								);
							$this->db->insert('riwayat',$data_riwayat);

	            $this->session->set_flashdata('sukses',"Data Umat Berhasil Di Restore");
	            redirect('Admin/Data');
	        }
				}

    // end data umat

	// star status umat
	function status_detail(){
		$umat_id = $this->input->post('umat_id');
		$where = array("umat_id" => $umat_id);
		$data = $this->DATA->GetdataWhere('data_umat',$where)->result_array();
		echo json_encode($data);
	}

	function add_statumat(){
		$umat_id = $this->input->post('umat_id');
    $status = $this->input->post('status');
		$cek 	= $this->DATA->GetWhere('status_umat', array('umat_id' => $umat_id, 'status' => $status));
		if ($cek) {
			$this->session->set_flashdata('error',"Data Status Umat Sudah Ada");
			redirect('Admin/Data');
		}else{
          $data=array(
                'umat_id'       => $umat_id,
                'status'        => $status,
                'tgl_status'	=> $this->input->post('tgl'),
            );
				  $this->db->insert('status_umat',$data);
					$data_riwayat=array(
								'umat_id'       => $umat_id,
								'kk_id'					=> NULL,
								'status'        => $status,
								'tgl_status'	=> $this->input->post('tgl'),
						);
					$this->db->insert('riwayat',$data_riwayat);
				  $this->session->set_flashdata('sukses',"Data Status Umat Berhasil Disimpan");
				  redirect('Admin/Data');
		}
  }
	function datastatus(){
		$umat_id = $_POST['umat_id'];
		$data = $this->db->get_where('status_umat',array('umat_id'=>$umat_id))->result_array();
		echo json_encode($data);
	}
	// end status umat

	// start data kk
	function detail_kk($wilayah_id = NULL,$lingkungan_id = NULL){
		if(!$this->input->post('statuskk')){
			$status = NULL;
			$navstatus = "aktif";
		}else{
			$navstatus = $this->input->post('statuskk');
			if($this->input->post('statuskk') == "aktif"){
					$status = NULL;
			}else if($this->input->post('statuskk') == "pindah"){
					$status = "Pindah_kk";
			}
		}
        if($wilayah_id == NULL && $lingkungan_id == NULL){
            $data_kk =  $this->DATA->join_empat('kk_detail','user','lingkungan','wilayah','user_id','lingkungan_id','wilayah_id',array('kk_detail.status'=>$status),'kk_id');
            $nama_header = "Data Seluruh Detail Umat";
						$link				= base_url('admin/detail_kk/'.$wilayah_id.'/'.$lingkungan_id);
        }else if($wilayah_id != NULL && $lingkungan_id == NULL){
            $data_kk =  $this->DATA->join_empat_where('kk_detail','user','lingkungan','wilayah','user_id','lingkungan_id','wilayah_id',array('user.wilayah_id' => $wilayah_id, 'kk_detail.status'=>$status),'kk_detail.kk_id');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_header = "Semua Data KK Di Wilayah ".$nama_wilayah[0]->wilayah_nama." ";
						$link				= base_url('admin/detail_kk/'.$wilayah_id.'/'.$lingkungan_id);
        }else{
            $data_kk =  $this->DATA->join_empat_where('kk_detail','user','lingkungan','wilayah','user_id','lingkungan_id','wilayah_id',array('user.lingkungan_id' => $lingkungan_id, 'kk_detail.status'=>$status),'kk_detail.kk_id');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_lingkungan = $this->db->query('select lingkungan_nama from lingkungan where lingkungan_id = '.$lingkungan_id.'')->result();
            $nama_header = "Data KK di ".$nama_wilayah[0]->wilayah_nama." - ".$nama_lingkungan[0]->lingkungan_nama."";
						$link				= base_url('admin/detail_kk/'.$wilayah_id.'/'.$lingkungan_id);
        }
		$data = array(
			'kk' 			 	=> $data_kk->result(),
      'page'				=> "detailkk",
			'navstatus'			=> $navstatus,
      'lingkungan_id'     => $lingkungan_id,
      'wilayah_id'        => $wilayah_id,
			'header'			=> $nama_header,
			'link'				=> $link
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function detail_kk_list(){
		$kk_id = $this->input->post('kk_id');
		$where = array("kk_id" => $kk_id);
		$data = $this->DATA->GetdataWhere('kk_detail',$where)->result_array();
		echo json_encode($data);
	}

	function add_detail_kk(){
        $this->form_validation->set_rules('no_kk', 'no_kk', 'required');
        $this->form_validation->set_rules('kk_nama_kepkel', 'kk_nama_kepkel', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('kk_alamat', 'kk_alamat', 'required');
        $this->form_validation->set_rules('kk_kota', 'kk_kota', 'required');
        $this->form_validation->set_rules('kk_kode_pos', 'kk_kode_pos', 'required');
        $this->form_validation->set_rules('kk_status_nikah', 'kk_status_nikah', 'required');
        $this->form_validation->set_rules('kk_tempat_nikah', 'kk_tempat_nikah', 'required');
        $this->form_validation->set_rules('kk_tgl_nikah', 'kk_tgl_nikah', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data KK Gagal Di Tambahkan!!");
            redirect('Admin/detail_kk');
        }else{
            $data=array(
						'no_kk'				=> $this->input->post('no_kk'),
						'kk_nama_kepkel'	=> $this->input->post('kk_nama_kepkel'),
						'user_id'			=> $this->input->post('user_id'),
						'kk_alamat'			=> $this->input->post('kk_alamat'),
						'kk_rt'				=> $this->input->post('kk_rt'),
						'kk_rw'				=> $this->input->post('kk_rw'),
						'kk_kota'			=> $this->input->post('kk_kota'),
						'kk_kode_pos'		=> $this->input->post('kk_kode_pos'),
						'kk_telp'			=> $this->input->post('kk_telp'),
						'kk_status_nikah'	=> $this->input->post('kk_status_nikah'),
						'kk_tempat_nikah'	=> $this->input->post('kk_tempat_nikah'),
						'kk_tgl_nikah'		=> $this->input->post('kk_tgl_nikah'),
            );
            $this->db->insert('kk_detail',$data);
            $this->session->set_flashdata('sukses',"Data KK Berhasil Di Tambahkan");
            redirect('Admin/detail_kk');
        }
    }

    function edit_detail_kk(){
        $this->form_validation->set_rules('no_kk', 'no_kk', 'required');
        $this->form_validation->set_rules('kk_nama_kepkel', 'kk_nama_kepkel', 'required');
        $this->form_validation->set_rules('user_id', 'user_id', 'required');
        $this->form_validation->set_rules('kk_alamat', 'kk_alamat', 'required');
        $this->form_validation->set_rules('kk_kota', 'kk_kota', 'required');
        $this->form_validation->set_rules('kk_kode_pos', 'kk_kode_pos', 'required');
        $this->form_validation->set_rules('kk_status_nikah', 'kk_status_nikah', 'required');
        $this->form_validation->set_rules('kk_tempat_nikah', 'kk_tempat_nikah', 'required');
        $this->form_validation->set_rules('kk_tgl_nikah', 'kk_tgl_nikah', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data KK Gagal Di Edit!!");
            redirect('Admin/detail_kk');
        }else{
            $data=array(
							'no_kk'				=> $this->input->post('no_kk'),
							'kk_nama_kepkel'	=> $this->input->post('kk_nama_kepkel'),
							'user_id'			=> $this->input->post('user_id'),
							'kk_alamat'			=> $this->input->post('kk_alamat'),
							'kk_rt'				=> $this->input->post('kk_rt'),
							'kk_rw'				=> $this->input->post('kk_rw'),
							'kk_kota'			=> $this->input->post('kk_kota'),
							'kk_kode_pos'		=> $this->input->post('kk_kode_pos'),
							'kk_telp'			=> $this->input->post('kk_telp'),
							'kk_status_nikah'	=> $this->input->post('kk_status_nikah'),
							'kk_tempat_nikah'	=> $this->input->post('kk_tempat_nikah'),
							'kk_tgl_nikah'		=> $this->input->post('kk_tgl_nikah'),
            );
            $this->db->where('kk_id', $this->input->post('kk_id'));
            $this->db->update('kk_detail',$data);
						$data_riwayat=array(
									'umat_id'       => NULL,
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => 'Edit DATA KK',
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);
            $this->session->set_flashdata('sukses',"Data KK Berhasil Di Edit");
            redirect('Admin/detail_kk');
        }
    }

    function hapus_detail_kk(){
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('status_keterangan', 'status_keterangan', 'required');
        $this->form_validation->set_rules('tgl_status', 'tgl_status', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data KK dan UMAT Gagal Di Hapus");
            redirect('Admin/detail_keluarga_kk');
        }else{
            $where = array("kk_id" => $this->input->post('kk_id'));
            $info = $this->DATA->GetdataWhere('data_umat',$where)->result_array();
            if($info[0]['kk_id']== $this->input->post('kk_id')){
                $data_umat=array(
                    'status'				=> 'Pindah_umat',
                    'status_keterangan'		=> $this->input->post('status_keterangan'),
                    'tgl_status'			=> $this->input->post('tgl_status'),
                );
                $this->db->where('kk_id', $this->input->post('kk_id'));
                $this->db->update('data_umat',$data_umat);
            }
            $data=array(
							'status'				=> $this->input->post('status'),
							'status_keterangan'		=> $this->input->post('status_keterangan'),
							'tgl_status'			=> $this->input->post('tgl_status'),
            );
            $this->db->where('kk_id', $this->input->post('kk_id'));
            $this->db->update('kk_detail',$data);
						$data_riwayat=array(
									'umat_id'       => NULL,
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => 'DATA KK di Pindah',
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);
            $this->session->set_flashdata('sukses',"Data KK dan UMAT Berhasil DiHapus");
            redirect('Admin/detail_kk');
        }
	}

		function restore_detail_kk(){
				$this->form_validation->set_rules('kk_id', 'kk_id', 'required');
				if($this->form_validation->run()==FALSE){
						$this->session->set_flashdata('error',"Data KK dan UMAT Gagal Di Restore");
						redirect('Admin/detail_keluarga_kk');
				}else{
						$where = array("kk_id" => $this->input->post('kk_id'));
						$info = $this->DATA->GetdataWhere('data_umat',$where)->result_array();
						if($info[0]['kk_id']== $this->input->post('kk_id')){
								$data_umat=array(
										'status'				=> NULL,
										'status_keterangan'		=> NULL,
										'tgl_status'			=> NULL,
								);
								$this->db->where('kk_id', $this->input->post('kk_id'));
								$this->db->update('data_umat',$data_umat);
						}
						$data=array(
							'status'				=> NULL,
							'status_keterangan'		=> NULL,
							'tgl_status'			=> NULL,
						);
						$this->db->where('kk_id', $this->input->post('kk_id'));
						$this->db->update('kk_detail',$data);
						$data_riwayat=array(
									'umat_id'       => NULL,
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => 'KK Aktif Kembali',
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);

						$this->session->set_flashdata('sukses',"Data KK dan UMAT Berhasil DiHapus");
						redirect('Admin/detail_kk');
				}
	}
	// end data kk

	// star data keluarga kk
	function detail_keluarga_kk($id){
		$data = array(
			'umat' 			 	=> $this->DATA->join_lima_where('data_umat','kk_detail','user','lingkungan','wilayah','kk_id','user_id','lingkungan_id','wilayah_id',array('data_umat.kk_id' => $id, 'data_umat.status'=>NULL),'data_umat.umat_id')->result(),
			'page'				=> "data_keluarga_kk",
			'header'			=> "Detail Data Keluarga KK",
			'link'				=> base_url('admin/detail_keluarga_kk/'.$id),
			'detail_kk'			=> $this->DATA->join_empat_where('kk_detail','user','lingkungan','wilayah','user_id','lingkungan_id','wilayah_id',array('kk_id' => $id, 'kk_detail.status'=>NULL),'kk_id')->result(),
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function detail_keluarga_kk_detail(){
		$umat_id = $this->input->post('umat_id');
		$where = array("umat_id" => $umat_id);
		$data = $this->DATA->GetdataWhere('data_umat',$where)->result_array();
		echo json_encode($data);
	}

	function add_detail_keluarga_kk(){
        $this->form_validation->set_rules('no_nik', 'no_nik', 'required');
        $this->form_validation->set_rules('kk_id', 'kk_id', 'required');
        $this->form_validation->set_rules('umat_nama', 'umat_nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('hub_keluarga', 'hub_keluarga', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'required');
        $this->form_validation->set_rules('goldar', 'goldar', 'required');
        $this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'pendidikan_akhir', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Umat Gagal Di Tambahkan!!");
            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
        }else{
            $data=array(
						'no_nik'				=> $this->input->post('no_nik'),
						'kk_id'					=> $this->input->post('kk_id'),
						'umat_nama'				=> $this->input->post('umat_nama'),
						'jenis_kelamin'			=> $this->input->post('jenis_kelamin'),
						'hub_keluarga'			=> $this->input->post('hub_keluarga'),
						'domisili'				=> $this->input->post('domisili'),
						'tgl_lahir'				=> $this->input->post('tgl_lahir'),
						'goldar'				=> $this->input->post('goldar'),
						'pekerjaan'				=> $this->input->post('pekerjaan'),
						'pendidikan_akhir'		=> $this->input->post('pendidikan_akhir'),
						'keahlian'				=> $this->input->post('keahlian'),
						'keterangan'			=> $this->input->post('keterangan'),
            );
            $this->db->insert('data_umat',$data);
            $this->session->set_flashdata('sukses',"Data Umat Berhasil Disimpan");
            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
        }
    }

    function edit_detail_keluarga_kk(){
        $this->form_validation->set_rules('no_nik', 'no_nik', 'required');
        $this->form_validation->set_rules('kk_id', 'kk_id', 'required');
        $this->form_validation->set_rules('umat_nama', 'umat_nama', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('hub_keluarga', 'hub_keluarga', 'required');
        $this->form_validation->set_rules('domisili', 'domisili', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'tgl_lahir', 'required');
        $this->form_validation->set_rules('goldar', 'goldar', 'required');
        $this->form_validation->set_rules('pekerjaan', 'pekerjaan', 'required');
        $this->form_validation->set_rules('pendidikan_akhir', 'pendidikan_akhir', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Umat Gagal Di Edit");
            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
        }else{
        	$data=array(
						'no_nik'				=> $this->input->post('no_nik'),
						'kk_id'					=> $this->input->post('kk_id'),
						'umat_nama'				=> $this->input->post('umat_nama'),
						'jenis_kelamin'			=> $this->input->post('jenis_kelamin'),
						'hub_keluarga'			=> $this->input->post('hub_keluarga'),
						'domisili'				=> $this->input->post('domisili'),
						'tgl_lahir'				=> $this->input->post('tgl_lahir'),
						'goldar'				=> $this->input->post('goldar'),
						'pekerjaan'				=> $this->input->post('pekerjaan'),
						'pendidikan_akhir'		=> $this->input->post('pendidikan_akhir'),
						'keahlian'				=> $this->input->post('keahlian'),
						'keterangan'			=> $this->input->post('keterangan'),
            );
            $this->db->where('umat_id', $this->input->post('umat_id'));
            $this->db->update('data_umat',$data);
						$data_riwayat=array(
									'umat_id'       => $this->input->post('umat_id'),
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => 'Edit Umat',
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);
            $this->session->set_flashdata('sukses',"Data Umat Berhasil Diedit");
            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
        }
    }

    function hapus_detail_keluarga_kk(){
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('status_keterangan', 'status_keterangan', 'required');
        $this->form_validation->set_rules('tgl_status', 'tgl_status', 'required');
	       if($this->form_validation->run()==FALSE){
	            $this->session->set_flashdata('error',"Data Umat Gagal Di Hapus");
	            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
	        }else{
	          $data=array(
							'status'				=> $this->input->post('status'),
							'status_keterangan'		=> $this->input->post('status_keterangan'),
							'tgl_status'			=> $this->input->post('tgl_status'),
	         	);
            $this->db->where('umat_id', $this->input->post('umat_id'));
            $this->db->update('data_umat',$data);
						$data_riwayat=array(
									'umat_id'       => $this->input->post('umat_id'),
									'kk_id'					=> $this->input->post('kk_id'),
									'status'        => $this->input->post('status'),
									'tgl_status'	=> date("Y-m-d"),
							);
						$this->db->insert('riwayat',$data_riwayat);
            $this->session->set_flashdata('sukses',"Data Umat Berhasil DiHapus");
            redirect('Admin/detail_keluarga_kk/'.$this->input->post('kk_id'));
        }
	}
	// end data keluarga kk

	//star graph
	    function graph($wilayah_id = NULL, $lingkungan_id = NULL){
					$status_umat = $this->DATA->grap_status_umat_model($wilayah_id,$lingkungan_id);
					$umat = $this->DATA->grap_umat_model($wilayah_id,$lingkungan_id);
					$data_kk = $this->DATA->grap_kk($wilayah_id,$lingkungan_id);
	        if($wilayah_id == NULL && $lingkungan_id == NULL){

     					$nama_header = "Graph Seluruh Umat";
	            $lingkungan = $this->db->get('lingkungan');
	            $link = base_url('admin/data/'.$wilayah_id.'/'.$lingkungan_id);

	        }else if($wilayah_id != NULL && $lingkungan_id == NULL){

   						$nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
	            $nama_header = "Semua Graph Di Wilayah ".$nama_wilayah[0]->wilayah_nama." ";
	            $lingkungan = $this->db->get_where('lingkungan',array('wilayah_id' => $wilayah_id));
	            $link = base_url('admin/graph/'.$wilayah_id.'/'.$lingkungan_id);
	        }else{

 							$nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
	            $nama_lingkungan = $this->db->query('select lingkungan_nama from lingkungan where lingkungan_id = '.$lingkungan_id.'')->result();
	            $nama_header = "Graph di ".$nama_wilayah[0]->wilayah_nama." - ".$nama_lingkungan[0]->lingkungan_nama."";
	            $link = base_url('admin/graph/'.$wilayah_id.'/'.$lingkungan_id);
	            $lingkungan = $this->db->get_where('lingkungan',array('lingkungan_id' => $lingkungan_id));
	        }
							$data = array(
	            'page'				=> "graph",
							'umat'							=> $umat,
							'status_umat'							=> $status_umat,
							'data_kk'					=> $data_kk,
	            'lingkungan_id'     => $lingkungan_id,
	            'wilayah_id'        => $wilayah_id,
	            'lingkungan'       => $lingkungan,
	            'header'			=> $nama_header,
	            'link'				=> $link
			);
			$this->load->view("admin/admin/layout.php",$data);

	    }
	//end graph


	// star data user

	function user(){
		$data = array(
			'user' 			 	=> $this->DATA->gets('user'),
			'jml_admin'  	 	=> $this->DATA->User('user', 'admin')->num_rows(),
			'jml_lingkungan' 	=> $this->DATA->User('user', 'lingkungan')->num_rows(),
			'jml_wilayah' 		=> $this->DATA->User('user', 'wilayah')->num_rows(),
			'page'				=> "user",
			'header'			=> "Data User",
			'link'				=> base_url('admin/user')
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function user_detail(){
		$user_id = $this->input->post('user_id');
		$where = array("user_id" => $user_id);
		$data = $this->DATA->GetdataWhere('user',$where)->result_array();
		echo json_encode($data);
	}

	function add_user(){
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('user_jenis', 'user_jenis', 'required');
        $this->form_validation->set_rules('lingkungan', 'lingkungan', 'required');
        $this->form_validation->set_rules('wilayah', 'wilayah', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"User Gagal Di Tambahkan");
            redirect('Admin/User');
        }else{
        	$kat = $this->input->post('user_jenis');
					if($kat == 'admin' ){
						$user_jenis= 'admin';
					}
					else if($kat == 'lingkungan' ){
						$user_jenis= 'lingkungan';
					}
					else{
						$user_jenis= 'wilayah';
					}
		            $data=array(
									'username'		=> $this->input->post('username'),
									'password'		=> md5($this->input->post('password')),
									'user_jenis'	=> $this->input->post('user_jenis'),
									'nama'			=> $this->input->post('nama'),
									'wilayah_id'	=> $this->input->post('wilayah'),
									'lingkungan_id'	=> $this->input->post('lingkungan'),
		            );
		            $this->db->insert('user',$data);
		            $this->session->set_flashdata('sukses',"User Berhasil Disimpan");
		            redirect('Admin/User');
		        }
    }

    function edit_user(){
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('user_jenis', 'user_jenis', 'required');
        $this->form_validation->set_rules('lingkungan_id', 'lingkungan_id', 'required');
        $this->form_validation->set_rules('wilayah_id', 'wilayah_id', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"User Gagal Di Edit");
            redirect('Admin/User');
        }else{
        	$kat = $this->input->post('user_jenis');
			if($kat == 'admin' ){
				$user_jenis= 'admin';
			}
			else if($kat == 'lingkungan' ){
				$user_jenis= 'lingkungan';
			}
			else{
				$user_jenis= 'wilayah';
			}
            $data=array(
							'username'		=> $this->input->post('username'),
							'password'		=> md5($this->input->post('password')),
							'user_jenis'	=> $user_jenis,
							'nama'			=> $this->input->post('nama'),
							'wilayah_id'	=> $this->input->post('wilayah_id'),
							'lingkungan_id'	=> $this->input->post('lingkungan_id'),
            );
            $this->db->where('user_id', $this->input->post('user_id'));
            $this->db->update('user',$data);
            $this->session->set_flashdata('sukses',"User Berhasil Diedit");
            redirect('Admin/User');
        }
    }

    function hapus_user($id){
        if($id==""){
            $this->session->set_flashdata('error',"User Gagal Di Hapus");
            redirect('Admin/User');
        }else{
            $this->db->where('user_id', $id);
            $this->db->delete('user');
            $this->session->set_flashdata('sukses',"User Berhasil Dihapus");
            redirect('Admin/User');
        }
	}

	function pastor(){
		$data = array(
			'pastor' 			 	=> $this->DATA->GetRes('pastor'),
			'page'				=> "pastor",
			'header'			=> "Data Pastor",
			'link'				=> base_url('admin/pastor')
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function pastor_detail(){
		$pastor_id = $this->input->post('pastor_id');
		$where = array("pastor_id" => $pastor_id);
		$data = $this->DATA->GetdataWhere('pastor',$where)->result_array();
		echo json_encode($data);
	}

	function edit_pastor(){
			$this->form_validation->set_rules('pastor_nama', 'pastor_nama', 'required');
			if($this->form_validation->run()==FALSE){
					$this->session->set_flashdata('error',"Pastor Gagal Di Edit");
					redirect('Admin/Pastor');
			}else{

					$data=array(
						'pastor_nama'		=> $this->input->post('pastor_nama'),
					);
					$this->db->where('pastor_id', $this->input->post('pastor_id'));
					$this->db->update('pastor',$data);
					$this->session->set_flashdata('sukses',"Pastor Berhasil Diedit");
					redirect('Admin/Pastor');
			}
	}

	// end data user

	function wilayah(){
		$data = array(
			'wilayah' 			=> $this->DATA->get_wilayah1(),
			'page'				=> "wilayah",
			'header'			=> "Data Wilayah",
			'link'				=> base_url('admin/wilayah')
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function wilayah_detail(){
		$wilayah_id = $this->input->post('wilayah_id');
		$where = array("wilayah_id" => $wilayah_id);
		$data = $this->DATA->GetdataWhere('wilayah',$where)->result_array();
		echo json_encode($data);
	}

	function add_wilayah(){
        $this->form_validation->set_rules('wilayah_nama', 'wilayah_nama', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Wilayah Gagal Di Tambahkan");
            redirect('Admin/Wilayah');
        }else{
            $data=array(
				'wilayah_nama'	=> $this->input->post('wilayah_nama'),
            );
            $this->db->insert('wilayah',$data);
            $this->session->set_flashdata('sukses',"Data Wilayah Berhasil Disimpan");
            redirect('Admin/Wilayah');
        }
    }

    function edit_wilayah(){
        $this->form_validation->set_rules('wilayah_nama', 'wilayah_nama', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Wilayah Gagal Di Edit");
            redirect('Admin/Wilayah');
        }else{
            $data=array(
				'wilayah_nama'	=> $this->input->post('wilayah_nama'),
            );
            $this->db->where('wilayah_id', $this->input->post('wilayah_id'));
            $this->db->update('wilayah',$data);
            $this->session->set_flashdata('sukses',"Data Wilayah Berhasil Diedit");
            redirect('Admin/Wilayah');
        }
    }

    function hapus_wilayah($id){
        if($id==""){
            $this->session->set_flashdata('error',"Data Wilayah Gagal Di Hapus");
            redirect('Admin/Wilayah');
        }else{
            $this->db->where('wilayah_id', $id);
            $this->db->delete('wilayah');
            $this->session->set_flashdata('sukses',"Data Wilayah Berhasil Dihapus");
            redirect('Admin/Wilayah');
        }
    }

	function lingkungan($wilayah_id = NULL){
        if($wilayah_id == NULL){
            $data_lingkungan =  $this->DATA->get_lingkungan1();
            $nama_header = "Data Seluruh Lingkungan";
			$link	= base_url('admin/lingkungan/'.$wilayah_id);
        }else{
            $data_lingkungan =  $this->DATA->get_lingkungan1_where(array('b.wilayah_id' => $wilayah_id));
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_header = "Data Lingkungan di ".$nama_wilayah[0]->wilayah_nama."";
			$link	= base_url('admin/lingkungan/'.$wilayah_id);
        }
		$data = array(
			'lingkungan'		=> $data_lingkungan->result_array(),
			'jml_plamongan'   	=> $this->DATA->Lingkungan('wilayah', '2','Plamongan Indah')->num_rows(),
			'jml_pucanggading' 	=> $this->DATA->Lingkungan('wilayah', '3','Pucang Gading')->num_rows(),
            'jml_mranggen' 		=> $this->DATA->Lingkungan('wilayah', '4','Mranggen')->num_rows(),
            'wilayah_id'        => $wilayah_id,
			'page'				=> "lingkungan",
			'header'			=> $nama_header,
			'link'				=> $link
		);
		$this->load->view("admin/admin/layout.php",$data);
	}

	function lingkungan_detail(){
		$lingkungan_id = $this->input->post('lingkungan_id');
		$where = array("lingkungan_id" => $lingkungan_id);
		$data = $this->DATA->GetdataWhere('lingkungan',$where)->result_array();
		echo json_encode($data);
	}

	function add_lingkungan(){
        $this->form_validation->set_rules('lingkungan_nama', 'lingkungan_nama', 'required');
        $this->form_validation->set_rules('wilayah_id', 'wilayah_id', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Lingkungan Gagal Di Tambahkan");
            redirect('Admin/Lingkungan');
        }else{
            $data=array(
				'lingkungan_nama'	=> $this->input->post('lingkungan_nama'),
				'wilayah_id'		=> $this->input->post('wilayah_id'),
            );
            $this->db->insert('lingkungan',$data);
            $this->session->set_flashdata('sukses',"Data Lingkungan Berhasil Disimpan");
            redirect('Admin/Lingkungan');
        }
    }

    function edit_lingkungan(){
        $this->form_validation->set_rules('lingkungan_nama', 'lingkungan_nama', 'required');
        $this->form_validation->set_rules('wilayah_id', 'wilayah_id', 'required');
        if($this->form_validation->run()==FALSE){
            $this->session->set_flashdata('error',"Data Lingkungan Gagal Di Edit");
            redirect('Admin/Lingkungan');
        }else{
            $data=array(
				'lingkungan_nama'	=> $this->input->post('lingkungan_nama'),
				'wilayah_id'		=> $this->input->post('wilayah_id'),
            );
            $this->db->where('lingkungan_id', $this->input->post('lingkungan_id'));
            $this->db->update('lingkungan',$data);
            $this->session->set_flashdata('sukses',"Data Lingkungan Berhasil Diedit");
            redirect('Admin/Lingkungan');
        }
    }

    function hapus_lingkungan($id){
        if($id==""){
            $this->session->set_flashdata('error',"Data Lingkungan Gagal Di Hapus");
            redirect('Admin/Lingkungan');
        }else{
            $this->db->where('lingkungan_id', $id);
            $this->db->delete('lingkungan');
            $this->session->set_flashdata('sukses',"Data Lingkungan Berhasil Dihapus");
            redirect('Admin/Lingkungan');
        }
    }

    function riwayat($wilayah_id = NULL, $lingkungan_id = NULL){
        if($wilayah_id == NULL && $lingkungan_id == NULL){
            $data_umat_status =  $this->DATA->join_riwayat('data_umat','kk_detail','user','lingkungan','wilayah','riwayat','kk_id','user_id','lingkungan_id','wilayah_id','umat_id','riwayat.id_riwayat');
            $nama_header = "Riwayat Seluruh Umat";
            $link = base_url('admin/riwayat/');

        }else if($wilayah_id != NULL && $lingkungan_id == NULL){
            $data_umat_status =  $this->DATA->join_riwayat_where('data_umat','kk_detail','user','lingkungan','wilayah','riwayat','kk_id','user_id','lingkungan_id','wilayah_id','umat_id',array('user.wilayah_id' => $wilayah_id),'riwayat.id_riwayat');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_header = "Riwayat Di Wilayah ".$nama_wilayah[0]->wilayah_nama." ";
            $link = base_url('admin/riwayat/'.$wilayah_id.'/'.$lingkungan_id);
        }else{
            $data_umat_status =  $this->DATA->join_riwayat_where('data_umat','kk_detail','user','lingkungan','wilayah','riwayat','kk_id','user_id','lingkungan_id','wilayah_id','umat_id',array('user.lingkungan_id' => $lingkungan_id),'riwayat.id_riwayat');
            $nama_wilayah = $this->db->query('select wilayah_nama from wilayah where wilayah_id = '.$wilayah_id.'')->result();
            $nama_lingkungan = $this->db->query('select lingkungan_nama from lingkungan where lingkungan_id = '.$lingkungan_id.'')->result();
            $nama_header = "Riwayat di ".$nama_wilayah[0]->wilayah_nama." - ".$nama_lingkungan[0]->lingkungan_nama."";
            $link = base_url('admin/riwayat/'.$wilayah_id.'/'.$lingkungan_id);
        }
        $data = array(
            'umat_status'       => $data_umat_status,
            'page'				=> "riwayat",
            'lingkungan_id'     => $lingkungan_id,
            'wilayah_id'        => $wilayah_id,
            'header'			=> $nama_header,
            'link'				=> $link
		);
		$this->load->view("admin/admin/layout.php",$data);

    }

	function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
}
