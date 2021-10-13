<?php namespace App\Libraries;

class KirimEmail
{
    public function __construct()
    {
		$this->email = \Config\Services::email();
    }
	
	function kirim($emailTo,$subjek,$isiEmail) {
		
		$hostemail = 'mail.bit.co.id';
		$sender = 'develop@bit.co.id';
		$pass = '393745np';
		$smtpcryp = 'ssl';
		$smtpport = '465';
		
		$config['protocol'] = 'smtp';
		$config['SMTPHost'] = $hostemail;
		$config['SMTPCrypto'] = $smtpcryp;
		$config['SMTPPort'] = $smtpport;
		$config['SMTPTimeout'] = '10';
		$config['SMTPUser'] = $sender; 
		$config['SMTPPass'] = $pass; 
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['validate'] = TRUE; // bool whether to validate email or not
		$config['mailtype'] = 'html'; 
		
		$this->email->initialize($config);
	
		$this->email->setFrom($sender, 'Aplikasi Telur');
		$this->email->setTo($emailTo);

		$this->email->setSubject($subjek);
		$this->email->setMessage($isiEmail);

		$this->email->send();
		
	//	echo $this->email->printDebugger();
	}
 }

?>