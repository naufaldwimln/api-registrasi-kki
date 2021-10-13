<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\ApprovalModel;

final class Api extends Controller
{
    use ResponseTrait;
    protected $login, $approval;
 
	public function __construct() {
		helper('utility');
		$this->login = new UserModel();
		$this->approval = new ApprovalModel();
	}
	
    public function index(): ResponseInterface
    {
        $data = generateData('Forbidden Access',403); 
		
		return $this->respond($data,403);
    }

    public function login(): ResponseInterface
    {
		$u = $this->request->getPost('username');
		$p = $this->request->getPost('password');
        $d = $this->login->cekLogin($u, $p);
		
		$data = generateData($d['isi'], $d['code']); 
				
		return $this->respond($data, $d['code']);
    }

    public function ordenerApprovalDokter(): ResponseInterface
	{
		$result = $this->approval->ordenerApprovalDokter();
		return $this->respond($result, 200);
	}
	
	// // public function login(): ResponseInterface
 //    {
	// 	$u = $this->request->getPost('username');
	// 	$p = $this->request->getPost('password');
	// 	$t = $this->request->getPost('type');
 //        $d = $this->LoginModel->cekLogin($u,$p,$t);		
		
	// 	$this->LoginModel->simpanLog('login',json_encode($this->request->getPost()),json_encode($d));
		
	// 	$data = generateData($d['isi'],$d['code']); 
				
	// 	return $this->respond($data,$d['code']);
 //    }
	
	// public function rubahpassword(): ResponseInterface
 //    {		
	// 	$u = $this->request->getPost('username');
	// 	$p = $this->request->getPost('password');
	// 	$t = $this->request->getHeaderLine('token');
 //        $d = $this->LoginModel->resetPassword($u,$t,$p);		
		
	// 	$data = generateData($d['isi'],$d['code']); 
		
	// 	if($d['code']==200) {
	// 		$isiEmail = 'Password anda berhasil di rubah.';
	// 		$this->KirimEmail->kirim($u,'Rubah Password',$isiEmail);
	// 	}
		
	// 	return $this->respond($data,$d['code']);
 //    }
	
	// public function lupapassword(): ResponseInterface
 //    {		
	// 	$u = $this->request->getPost('email');
 //        $d = $this->LoginModel->kirimResetCode($u);				
		
	// 	$data = generateData($d['isi'],$d['code']); 
		
	// 	if($d['code']==200) {
	// 		$isiEmail = 'Berikut Kode Verifikasi Anda : '.$d['reset_code'];
	// 		$this->KirimEmail->kirim($u,'Kode Verifikasi',$isiEmail);
	// 	}
		
	// 	return $this->respond($data,$d['code']);
 //    }
	
	// public function cekkodeverifikasi(): ResponseInterface
	// {
	// 	$u = $this->request->getPost('email');
	// 	$k = $this->request->getPost('kode_verifikasi');
		
	// 	$d = $this->LoginModel->cekVerifCode($u,$k);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,$d['code']);
	// }
	
	// public function home(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$d = $this->LoginModel->home($t);
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);		
	// }
	
	// public function profile(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$d = $this->LoginModel->getProfile($t);
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function listitem(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$d = $this->LoginModel->getListItem($t);
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function pesanitem(): ResponseInterface
	// {		
	// 	$pesan = $this->request->getJSON();
	// 	$d = $this->LoginModel->simpanPesanan($pesan->userID,$pesan->total_harga,$pesan->items);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function riwayatpemesanan(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$d = $this->LoginModel->getRiwayatPemesanan($t);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function detailpemesanan(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$id = $this->request->getPost('id_pemesanan');
	// 	$d = $this->LoginModel->getDetailPemesanan($t,$id);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function penjualan(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$p = $this->LoginModel->getProfile($t);
	// 	$pesan = $this->request->getJSON();
	// 	$d = $this->LoginModel->simpanPenjualan($pesan->userID,$pesan->total_harga,$pesan->catatan,$pesan->items);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function riwayatpenjualan(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$d = $this->LoginModel->getRiwayatPenjualan($t);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
	
	// public function detailpenjualan(): ResponseInterface
	// {
	// 	$t = $this->request->getHeaderLine('token');
	// 	$id = $this->request->getPost('id_penjualan');
	// 	$d = $this->LoginModel->getDetailPenjualan($t,$id);
		
	// 	$data = generateData($d['isi'],$d['code']); 
	// 	return $this->respond($data,200);	
	// }
}
