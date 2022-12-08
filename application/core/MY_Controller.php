<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');   
        $this->load->library('email');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('email');
		$this->load->library('encrypt');
		//$this->load->library('VerifyEmail');
		
        
        if ( $this->uri->segment(2) == 'signup' || $this->uri->segment(2) == 'forgot' || $this->uri->segment(2) == 'sendemail'   )
		{
			
		}
		else
		{ 
			if (!$this->session->has_userdata('id') && $this->uri->segment(2) !== 'login')
			{
				redirect('user/login');
			}
		}
	}
}






