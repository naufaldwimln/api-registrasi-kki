<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ApprovalModel extends Model
{
	protected $db;

	function __construct() {
		parent::__construct();
		$this->db = db_connect();
	}

	public function ordenerApprovalDokter() {
		$sql = "SELECT outner FROM master_dokter a,trx_registrasi b WHERE a.berkas=b.berkas AND b.status_posisi =5 AND a.kelompok IN ('1','3') AND b.approval_ses IS NOT NULL and b.approval_dokter IS null GROUP BY outner";
		$data = $this->db->query($sql);
    	$data = (object) $data->getResultArray();
    	return $data;
	}
}
