<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table      = 'ki_users';
  protected $primaryKey = 'id';
  protected $allowedFields = ['id', 'role_id', 'email', 'username', 'password_hash', 'reset_hash', 'salt', 'last_login', 'last_ip', 'created_on', 'deleted', 'banned', 'ban_message', 'reset_by', 'display_name', 'display_name_changed', 'timezone', 'language', 'active', 'activate_hash', 'akses_approval', 'propinsi_id', 'kabupaten_id', 'kelompok', 'kompetensi', 'sign_img', 'sertifikat', 'password', 'token'];
  protected $column_order = array('id');
	protected $order = array('id' => 'asc');
	protected $db;
	protected $dt;

	function __construct() {
		parent::__construct();
		helper('utility');
		$this->db = db_connect('webinput');
		$this->dt = $this->db->table($this->table);
	}

	public function cekLogin($username, $password) {
		$token = generateToken($username, $password, date('d-m-Y h:i:s'));
		$pass = generatePassword($password);
		
		$dataUpdate = [
			'token' => $token,
			'last_login' => date('Y-m-d h:i:s'),
		];

		$this->where('username', $username);
		$this->update($this->get()->getFirstRow()->id, $dataUpdate);

		$n = $this->where(['username' => $username, 'password' => $pass])->countAllResults();
		
		if($n > 0) {
			$query = $this->getWhere(['username' => $username,'password' => $pass])->getRow();
			$data = array(
				'isi' => array(
					'message'    => 'Login berhasil',
					'user_id'    => $query->id,
					'nama'       => $query->display_name,
					'email'      => $query->email,
					'token'      => $token,
					'group_user' => $query->role_id
				),
				'code' => 200
			);				
		} else {
			$data = array(
				'isi' => 'Username / Password Salah',
				'code' => 401
			);
		}
		
		return $data;
	}
}
