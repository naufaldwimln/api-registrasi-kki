<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
	
	use ResponseTrait;
 
	public function __construct() {
		
	}
	
    public function index(): ResponseInterface
    {
        return $this->failForbidden('Forbidden Access');
    }
	
	//--------------------------------------------------------------------

}
