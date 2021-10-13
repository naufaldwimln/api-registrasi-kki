<?php namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model
{
	public function cekLogin($username,$password,$type) {
		
		$token = generateToken($username,$password,date('d-m-Y h:i:s'));
		$pass = generatePassword($password);
				
		$grup  = $this->db->table('ref_user_group');
		
		$q_grup = $grup->getWhere(['nama_user_group' => $type])->getRow();
		
		$builder = $this->db->table('ref_users');
		
		$dataUpdate = [
			'token' => $token,
			'login_time'  => date('Y-m-d h:i:s'),
		];

		$builder->where('username', $username);
		$builder->update($dataUpdate);
						
		$n   = $builder->where(['username' => $username,'password' => $pass,'id_user_group' => $q_grup->id_user_group])->countAllResults();
		
		if($n>0) {
			$query   = $builder->getWhere(['username' => $username,'password' => $pass,'id_user_group' => $q_grup->id_user_group])->getRow();
			$data = array(
				'isi' => array(
					'message' => 'Login berhasil',
					'userID' => $query->id,
					'namaLengkap' => $query->nama_lengkap,
					'eMail' => $query->email,
					'noHP' => $query->hp,
					'token' => $query->token,
					'UserGroup' => $query->id_user_group
				),
				'code' => 200
			);				
		} else {
			$data = array(
				'isi' => 'Email / Password Salah',
				'code' => 401
			);
		}
		
		
		
		return $data;
	}
	
	public function resetPassword($username,$token,$password) {
		$pass = generatePassword($password);
		
		
		$builder = $this->db->table('ref_users');
		$n   = $builder->where(['username' => $username,'token' => $token])->countAllResults();
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dataUpdate = [
				'password' => $pass,
				'token'  => NULL,
			];

			$builder->where('username', $username);
			$builder->update($dataUpdate);
			
			$data = array(
				'isi' => array(
					'message' => 'Rubah Password berhasil'
				), 
				'code' => 200
			);
		}
				
		return $data;			
	}
	
	public function kirimResetCode($username) {
		$builder = $this->db->table('ref_users');
		$n   = $builder->where(['username' => $username])->countAllResults();
		if($n==0) {
			$data = array(
				'isi' => 'Email tidak ditemukan',
				'code' => 400
			);
		} else {
			$reset = substr(number_format(time() * rand(),0,'',''),0,6);
			
			$dataUpdate = [
				'reset_code' => $reset,
				'reset_expired'  => date('Y-m-d h:i:s', strtotime("+1 day")),
			];

			$builder->where('username', $username);
			$builder->update($dataUpdate);
			
			$data = array(
				'isi' => array(
					'message' => 'Kode Verifikasi dikirim ke Email'
				), 
				'code' => 200,
				'reset_code' => $reset
			);
		}
				
		return $data;
	}
	
	public function cekVerifCode($username,$verif_kode) {
		$builder = $this->db->table('ref_users');
		$n   = $builder->where(['username' => $username, 'reset_code' => $verif_kode])->countAllResults();
		if($n==0) {
			$data = array(
				'isi' => 'Kode Verifikasi tidak sesuai',
				'code' => 400
			);
		} else {
			$token = generateToken($username,$verif_kode,date('d-m-Y h:i:s'));
			$builder = $this->db->table('ref_users');
		
			$dataUpdate = [
				'token' => $token,
				'login_time'  => date('Y-m-d h:i:s'),
			];

			$builder->where('username', $username);
			$builder->update($dataUpdate);
				
			$data = array(
				'isi' => array(
					'message' => 'Verifikasi berhasil, silahkan masukan password baru anda',
					'token' => $token
				), 
				'code' => 200
			);
		}
				
		return $data;
	}
	
	public function cekToken($token) {
		$builder = $this->db->table('ref_users');
		$n   = $builder->where(['token' => $token])->countAllResults();
		if($n==0) {
			$data = array(
				'isi' => 'Token Tidak Sesuai',
				'code' => 400
			);
		} else {
			$data = array(
				'isi' => array(
					'message' => 'Token Berhasil',
				), 
				'code' => 200
			);
		}
		
		return $data;
	}
	
	public function getBarang() {
		$builder = $this->db->table('ref_barang');
		return $builder;
	}
	
	public function getProfile($token) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx   = $builder->getWhere(['token' => $token]);
			$profile   = $dx->getRow();

			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'profile' => $profile
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function home($token) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx   = $builder->getWhere(['token' => $token]);
			$profile   = $dx->getRow();
			$builder = $this->db->table('ref_banner');
			$builder->select('id,CONCAT("'.base_url('image/banner').'/",banner) as banner');
			$banner = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'profile' => $profile,
					'banner' => $banner
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function getListItem($token) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$builder = $this->db->table('ref_barang');
			$builder->select('id,nama,harga,satuan,CONCAT("'.base_url('image/item').'/",foto) as foto');
			$item = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'item' => $item
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function simpanPesanan($userId,$total,$pesanan) {
		$builder = $this->db->table('master_permohonan');
		$kode = date('dmyhis').str_pad($userId,4,STR_PAD_LEFT);
		$isi = array(
			'kode_pemesanan' => $kode,
			'id_user' => $userId,
			'tanggal_pesan' => date('Y-m-d h:i:s'),
			'total_bayar' => $total
		);
		$builder->insert($isi);
		
		$dx = $builder->getWhere(['kode_pemesanan' => $kode]);
		$m = $dx->getRow();
		
		$builder = $this->db->table('master_permohonan_detail');
		foreach($pesanan as $row) {
			$isi = array( 
				'id_permohonan' => $m->id,
				'id_barang' => $row->itemID,
				'jumlah' => $row->jumlah,
				'satuan' => $row->satuan,
				'harga_satuan' => $row->hargaSatuan,
				'total' => $row->total
			);
			$builder->insert($isi);
		}
		
		$data = array(
			'isi' => array(
				'message' => 'Pemesanan berhasil'
			), 
			'code' => 200
		);
	
		return $data;
	}
		
	public function simpanPenjualan($userId,$total,$catatan,$pesanan) {
		$builder = $this->db->table('master_penjualan');
		$kode = date('dmyhis').str_pad($userId,4,STR_PAD_LEFT);
		$isi = array(
			'kode_penjualan' => $kode,
			'keterangan' => $catatan,
			'id_user' => $userId,
			'tanggal' => date('Y-m-d h:i:s'),
			'total_harga' => $total
		);
		$builder->insert($isi);
		
		$dx = $builder->getWhere(['kode_penjualan' => $kode]);
		$m = $dx->getRow();
		
		$builder = $this->db->table('master_penjualan_detail');
		foreach($pesanan as $row) {
			$isi = array( 
				'id_penjualan' => $m->id,
				'id_barang' => $row->itemID,
				'jumlah' => $row->jumlah,
				'satuan' => $row->satuan,
				'harga_satuan' => $row->hargaSatuan,
				'total' => $row->total
			);
			$builder->insert($isi);
		}
		
		$data = array(
			'isi' => array(
				'message' => 'Simpan data berhasil'
			), 
			'code' => 200
		);
	
		return $data;
	}
	
	public function getRiwayatPemesanan($token) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx = $builder->getWhere(['token' => $token]);
			$profile = $dx->getRow();
			$builder = $this->db->table('master_permohonan');
			$builder->where('id_user', $profile->id);
			$item = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'pemesanan' => $item
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function getDetailPemesanan($token,$id) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx = $builder->getWhere(['token' => $token]);
			$profile = $dx->getRow();
			$builder = $this->db->table('master_permohonan_detail as a');
			$builder->select('a.id,CONCAT("'.base_url('image/item').'/",foto) as foto,b.nama,a.jumlah,a.satuan,a.harga_satuan,a.total');
			$builder->join('ref_barang as b', 'a.id_barang = b.id');
			$builder->where('a.id_permohonan', $id);
			$item = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'detail' => $item
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function getRiwayatPenjualan($token) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx = $builder->getWhere(['token' => $token]);
			$profile = $dx->getRow();
			$builder = $this->db->table('master_penjualan');
			$builder->where('id_user', $profile->id);
			$item = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'penjualan' => $item
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function getDetailPenjualan($token,$id) {
		$builder = $this->db->table('ref_users');
		$dx   = $builder->where(['token' => $token]);
		$n = $dx->countAllResults();
		
		if($n==0) {
			$data = array(
				'isi' => 'Anda tidak dapat mengakses halaman ini',
				'code' => 401
			);
		} else {
			$dx = $builder->getWhere(['token' => $token]);
			$profile = $dx->getRow();
			$builder = $this->db->table('master_penjualan_detail as a');
			$builder->select('a.id,CONCAT("'.base_url('image/item').'/",foto) as foto,b.nama,a.jumlah,a.satuan,a.harga_satuan,a.total');
			$builder->join('ref_barang as b', 'a.id_barang = b.id');
			$builder->where('a.id_penjualan', $id);
			$item = $builder->get()->getResultArray();
			$data = array(
				'isi' => array(
					'message' => 'Berhasil',
					'detail' => $item
				), 
				'code' => 200
			);
		}		
		return $data;
	}
	
	public function simpanLog($a,$b,$c)
	{
		$builder = $this->db->table('log_access');
		$isi = array(
			'api' => $a,
			'parameter' => $b,
			'response' => $c,
			'waktu' => date('Y-m-d h:i:s')
		);
		$builder->insert($isi);
	}
}