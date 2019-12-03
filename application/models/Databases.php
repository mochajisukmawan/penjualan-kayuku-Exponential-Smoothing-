<?php
	class Databases extends CI_Model{

        function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function Get($table){
            $res=$this->db->get($table); // Kode ini berfungsi untuk memilih tabel yang akan ditampilkan
            return $res->result_array(); // Kode ini digunakan untuk mengembalikan hasil operasi $res menjadi sebuah array
        }

        public function GetRes($table){
            $res=$this->db->get($table); // Kode ini berfungsi untuk memilih tabel yang akan ditampilkan
            return $res->result(); // Kode ini digunakan untuk mengembalikan hasil operasi $res menjadi sebuah array
        }

        /*ADMIN KAPEL GEREJA*/
        public function gets(){
            $this->db->select('a.user_id as user_id, a.username as username, a.nama as nama, a.user_jenis as user_jenis, b.lingkungan_nama as lingkungan, c.wilayah_nama as wilayah, a.lingkungan_id as lingkungan_id, a.wilayah_id as wilayah_id');
            $this->db->from("user as a");
            $this->db->join('lingkungan as b', 'a.lingkungan_id = b.lingkungan_id', 'inner');
            $this->db->join('wilayah as c', 'a.wilayah_id = c.wilayah_id', 'inner');
            $this->db->order_by('a.user_id', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }

				public function readmore($id){
					$this->db->where('id_das',$id);
					$query = $this->db->get('dashboard');
					return $query->result();
				}

        public function cek_nik($nik){
            $this->db->where('no_nik', $nik);
            $query = $this->db->get("data_umat")->num_rows();
            return $query;
        }

        public function join_empat($tabel1,$tabel2,$tabel3,$tabel4,$penghubung12,$penghubung23,$penghubung24,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel2.'.'.$penghubung24.' = '.$tabel4.'.'.$penghubung24.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_empat_where($tabel1,$tabel2,$tabel3,$tabel4,$penghubung12,$penghubung23,$penghubung24,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel2.'.'.$penghubung24.' = '.$tabel4.'.'.$penghubung24.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_lima_where($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_lima($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_enam_where($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$tabel6,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$penghubung16,$where,$orderby){
            $this->db->select(DISTINCT(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*,'.$tabel6.'.*'));
            $this->db->from($tabel1);
            $this->db->join($tabel6, ''.$tabel1.'.'.$penghubung16.' = '.$tabel6.'.'.$penghubung16.'', 'left');
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_enamm_where($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$tabel6,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$penghubung16,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*,'.$tabel6.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel6, ''.$tabel1.'.'.$penghubung16.' = '.$tabel6.'.'.$penghubung16.'', 'inner');
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }

				public function join_download($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$where,$orderby){
						$this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*');
						$this->db->from($tabel1);
						$this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
						$this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
						$this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
						$this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
						$this->db->where($where);
						$this->db->order_by($orderby,'asc');
						return $query = $this->db->get();
				}
        public function join_enam($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$tabel6,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$penghubung16,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel6, ''.$tabel1.'.'.$penghubung16.' = '.$tabel6.'.'.$penghubung16.'', 'inner');
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'inner');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'inner');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'inner');
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
				public function join_riwayat($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$tabel6,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$penghubung16,$orderby){
					$this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*,'.$tabel6.'.*');
					$this->db->from($tabel6);
					$this->db->join($tabel1, ''.$tabel6.'.'.$penghubung16.' = '.$tabel1.'.'.$penghubung16.'', 'left');
					$this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'left');
					$this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'left');
					$this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'left');
					$this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'left');
					$this->db->order_by($orderby,'DESC');
					return $query = $this->db->get();
				}
				public function join_riwayat_where($tabel1,$tabel2,$tabel3,$tabel4,$tabel5,$tabel6,$penghubung12,$penghubung23,$penghubung34,$penghubung35,$penghubung16,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*, '.$tabel4.'.*,'.$tabel5.'.*,'.$tabel6.'.*');
            $this->db->from($tabel6);
            $this->db->join($tabel1, ''.$tabel6.'.'.$penghubung16.' = '.$tabel1.'.'.$penghubung16.'', 'left');
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'left');
            $this->db->join($tabel3, ''.$tabel2.'.'.$penghubung23.' = '.$tabel3.'.'.$penghubung23.'', 'left');
            $this->db->join($tabel4, ''.$tabel3.'.'.$penghubung34.' = '.$tabel4.'.'.$penghubung34.'', 'left');
            $this->db->join($tabel5, ''.$tabel3.'.'.$penghubung35.' = '.$tabel5.'.'.$penghubung35.'', 'left');
            $this->db->where($where);
            $this->db->order_by($orderby,'DESC');
            return $query = $this->db->get();
        }
        public function join_tiga_where($tabel1,$tabel2,$tabel3,$penghubung12,$penghubung13,$where,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel1.'.'.$penghubung13.' = '.$tabel3.'.'.$penghubung13.'', 'inner');
            $this->db->where($where);
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }
        public function join_tiga($tabel1,$tabel2,$tabel3,$penghubung12,$penghubung13,$orderby){
            $this->db->select(''.$tabel1.'.* , '.$tabel2.'.*, '.$tabel3.'.*');
            $this->db->from($tabel1);
            $this->db->join($tabel2, ''.$tabel1.'.'.$penghubung12.' = '.$tabel2.'.'.$penghubung12.'', 'inner');
            $this->db->join($tabel3, ''.$tabel1.'.'.$penghubung13.' = '.$tabel3.'.'.$penghubung13.'', 'inner');
            $this->db->order_by($orderby,'asc');
            return $query = $this->db->get();
        }

        public function getdates(){
            $this->db->select('a.kk_id as kk_id, a.no_kk as nkk, a.kk_nama_kepkel as nkepala, a.kk_alamat as alamat, a.kk_kecamatan as kecamatan, a.kk_kota as kota, a.kk_kode_pos as kode_pos, a.kk_provinsi as provinsi');
            $this->db->from("kk_detail as a");
            $this->db->order_by('a.kk_id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function GetdataWhere($table, $where){
            return $this->db->get_where($table, $where);
        }

        public function get_wilayah(){
            $query = $this->db->query('SELECT * FROM wilayah order by wilayah_id');
            return $query->result_array();
        }public function get_wilayah1(){
            $this->db->from("wilayah as a");
            $this->db->where('a.wilayah_nama !=','Khusus Admin');
            $this->db->order_by('a.wilayah_id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function get_lingkungan(){
            $query = $this->db->query('SELECT * FROM lingkungan order by lingkungan_id');
            return $query->result_array();
        }public function get_lingkungan1(){
            $this->db->select('a.lingkungan_id as lingkungan_id, a.lingkungan_nama as lingkungan_nama, a.wilayah_id as wilayah_id, b.wilayah_nama as wilayah_nama');
            $this->db->from("lingkungan as a");
            $this->db->join('wilayah as b', 'a.wilayah_id = b.wilayah_id', 'inner');
            $this->db->where('a.lingkungan_nama !=','Admin / Wilayah');
            $this->db->where('b.wilayah_nama !=','Khusus Admin');
            $this->db->order_by('a.lingkungan_id', 'ASC');
            return $this->db->get();
        }public function get_lingkungan1_where($where){
            $this->db->select('a.lingkungan_id as lingkungan_id, a.lingkungan_nama as lingkungan_nama, a.wilayah_id as wilayah_id, b.wilayah_nama as wilayah_nama');
            $this->db->from("lingkungan as a");
            $this->db->join('wilayah as b', 'a.wilayah_id = b.wilayah_id', 'inner');
            $this->db->where($where);
            $this->db->order_by('a.lingkungan_id', 'ASC');
            return $this->db->get();
        }

        public function get_adminling(){
            $this->db->select('a.user_id as user_id, a.nama as nama_admin, b.lingkungan_nama as nama_lingkungan, c.wilayah_nama as nama_wilayah');
            $this->db->from("user as a");
            $this->db->join('lingkungan as b', 'a.lingkungan_id = b.lingkungan_id', 'inner');
            $this->db->join('wilayah as c', 'a.wilayah_id = c.wilayah_id', 'inner');
            $this->db->where('b.lingkungan_nama !=','Admin / Wilayah');
            $this->db->order_by('a.user_id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function get_nkk(){
            $this->db->select('a.no_kk as nkk, a.kk_nama_kepkel as nama_kepkel');
            $this->db->from("kk_detail as a");
            $this->db->order_by('a.kk_id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function Insert($table,$data){
            $res = $this->db->insert($table, $data); // Kode ini digunakan untuk memasukan record baru kedalam sebuah tabel
            return $res; // Kode ini digunakan untuk mengembalikan hasil $res
        }

        public function Update($table, $data, $where){
            $res = $this->db->update($table, $data, $where); // Kode ini digunakan untuk merubah record yang sudah ada dalam sebuah tabel
            return $res;
        }

        public function Delete($table, $where){
            $res = $this->db->delete($table, $where); // Kode ini digunakan untuk menghapus record yang sudah ada
            return $res;
        }

        public function GetWhere($table, $where){
            $res = $this->db->get_where($table, $where);
            return $res->result_array();
        }

        public function geddatawherepro($select,$table,$where,$orderby,$number = NULL,$page = NULL){
            return $this->db->select($select)->from($table)->where($where)->order_by($orderby)->get($number,$page);
        }

        public function updated($tabel,$kondisi,$data){
            $this->db->where($kondisi);
            $this->db->update($tabel, $data);
            return $this->db->affected_rows();
        }

        /*HITUNG DATA*/
        public function User($tabel, $user_jenis){
            $res = $this->db->get_where($tabel, array('user_jenis' => $user_jenis));
            return $res;
        }

        public function Umat($tabel, $user_id, $wilayah){
            $this->db->join('user as b',  $user_id.'= b.user_id', 'inner');
            $this->db->join('wilayah as c', 'b.wilayah_id = c.wilayah_id', 'inner');
            $res = $this->db->get_where($tabel, array('c.wilayah_nama' => $wilayah));
            return $res;
        }

        public function Lingkungan($tabel, $wilayah_id, $wilayah){
            $this->db->join('lingkungan as c', $wilayah_id.'= c.wilayah_id', 'inner');
            $this->db->where('c.lingkungan_nama !=','Admin / Wilayah');
            $res = $this->db->get_where($tabel, array('wilayah.wilayah_nama' => $wilayah));
            return $res;
        }

				public function grap_umat_model ($wilayah_id , $lingkungan_id){
									$select = array('wilayah.wilayah_nama',
																	'lingkungan.lingkungan_nama',
									                'sum(IF(jenis_kelamin = "L",1,0)) as jumlah_L',
									                'sum(IF(jenis_kelamin = "P",1,0 )) as jumlah_P',
									                'sum(IF(pendidikan_akhir = "SD",1,0 )) as jumlah_SD',
									                'sum(IF(pendidikan_akhir = "SMP",1,0 )) as jumlah_SMP',
									                'sum(IF(pendidikan_akhir = "SMk/SMA",1,0 )) as jumlah_SMA_SMK',
									                'sum(IF(pendidikan_akhir = "D1",1,0 )) as jumlah_d1',
									                'sum(IF(pendidikan_akhir = "D2",1,0 )) as jumlah_d2',
									                'sum(IF(pendidikan_akhir = "D3",1,0 )) as jumlah_d3',
									                'sum(IF(pendidikan_akhir = "D4",1,0 )) as jumlah_d4',
									                'sum(IF(pendidikan_akhir = "S1",1,0 )) as jumlah_S1',
									                'sum(IF(pendidikan_akhir = "S2",1,0 )) as jumlah_S2',
																	'sum(IF(pendidikan_akhir = "S3",1,0 )) as jumlah_S3',
																	'sum(IF(goldar = "A",1,0 )) as jumlah_goldar_A',
																	'sum(IF(goldar = "B",1,0 )) as jumlah_goldar_B',
																	'sum(IF(goldar = "AB",1,0 )) as jumlah_goldar_AB',
																	'sum(IF(goldar = "O",1,0 )) as jumlah_goldar_O',
																	'sum(IF(year(tgl_lahir) > '.date('Y').'-10,1,0 )) as anakanak',
																	'sum(IF(year(tgl_lahir) > '.date('Y').'-17 and year(tgl_lahir) < '.date('Y').'-10,1,0 )) as remaja',
																	'sum(IF(year(tgl_lahir) < '.date('Y').'-17,1,0 )) as dewasa',
									                'sum(IF(year(tgl_lahir) > '.date('Y').'-15  and year(tgl_lahir) < '.date('Y').'-10,1,0 )) as usia_10_15',
									              );

									$this->db->select($select);
									$this->db->from('data_umat');
									$this->db->join('kk_detail', 'kk_detail.kk_id = data_umat.kk_id', 'inner');
									$this->db->join('user', 'kk_detail.user_id = user.user_id', 'inner');
									$this->db->join('lingkungan', 'user.lingkungan_id = lingkungan.lingkungan_id', 'inner');
									$this->db->join('wilayah', 'user.wilayah_id = wilayah.wilayah_id', 'inner');
									$this->db->where('data_umat.status',NULL);

									if($wilayah_id == NULL && $lingkungan_id == NULL){
										$this->db->group_by('wilayah.wilayah_nama','asc');
										$umat = $this->db->get()->result();
									}else{
										$this->db->group_by('lingkungan.lingkungan_nama','asc');
										$umat = $this->db->get()->result();
									}
						return $umat;
				}

				public function grap_status_umat_model ($wilayah_id , $lingkungan_id){
									$select = array('wilayah.wilayah_nama',
																	'lingkungan.lingkungan_nama',
																	'sum(IF(status_umat.status = "baptis",1,0 )) as jumlah_baptis',
																	'sum(IF(status_umat.status = "komuni",1,0 )) as jumlah_komuni',
																	'sum(IF(status_umat.status = "krisma",1,0 )) as jumlah_krisma',
																	'sum(IF(year(tgl_lahir) > '.date('Y').'-10 and status_umat.status = "baptis",1,0 )) as anakanak_baptis',
																	'sum(IF(year(tgl_lahir) > '.date('Y').'-17 and year(tgl_lahir) <= '.date('Y').'-10 and status_umat.status = "baptis",1,0 )) as remaja_baptis',
																	'sum(IF(year(tgl_lahir) <= '.date('Y').'-17 and status_umat.status = "baptis",1,0 )) as dewasa_baptis',
																);

									$this->db->select($select);
									$this->db->from('data_umat');
									$this->db->join('status_umat','data_umat.umat_id = status_umat.umat_id' , 'inner');
									$this->db->join('kk_detail', 'kk_detail.kk_id = data_umat.kk_id', 'inner');
									$this->db->join('user', 'kk_detail.user_id = user.user_id', 'inner');
									$this->db->join('lingkungan', 'user.lingkungan_id = lingkungan.lingkungan_id', 'inner');
									$this->db->join('wilayah', 'user.wilayah_id = wilayah.wilayah_id', 'inner');
									$this->db->where('data_umat.status',NULL);


									if($wilayah_id == NULL && $lingkungan_id == NULL){
										$this->db->group_by('wilayah.wilayah_nama','asc');
										$umat = $this->db->get()->result();
									}else{
										$this->db->group_by('lingkungan.lingkungan_nama','asc');
										$umat = $this->db->get()->result();
									}
						return $umat;
				}

				public function grap_kk ($wilayah_id , $lingkungan_id){
									$select = array('wilayah.wilayah_nama',
																	'lingkungan.lingkungan_nama',
																	'COUNT(kk_id) AS total_kk_id',
									              );

									$this->db->select($select);
									$this->db->from('kk_detail');
									$this->db->join('user', 'kk_detail.user_id = user.user_id', 'inner');
									$this->db->join('lingkungan', 'user.lingkungan_id = lingkungan.lingkungan_id', 'inner');
									$this->db->join('wilayah', 'user.wilayah_id = wilayah.wilayah_id', 'inner');
									$this->db->where('kk_detail.status',NULL);

									if($wilayah_id == NULL && $lingkungan_id == NULL){
										$this->db->group_by('wilayah.wilayah_nama','asc');
										$umat = $this->db->get()->result();
									}else{
										$this->db->group_by('lingkungan.lingkungan_nama','asc');
										$umat = $this->db->get()->result();
									}
						return $umat;
				}

    }
?>
