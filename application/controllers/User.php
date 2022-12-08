<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function signup()
	{
		$a=10;
		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('user_password', 'Password', 'required');


		if ($this->input->post('submit'))
		{
			$e = $this->input->post('user_email');
			$password = $this->input->post('user_password');

			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		    $pass = array(); //remember to declare $pass as an array
		    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		    for ($i = 0; $i < 8; $i++) {
		        $n = rand(0, $alphaLength);
		        $pass[] = $alphabet[$n];
		    }
		    $pass =  implode($pass);
		   

			$from = "dadashovfikret22@gmail.com";
			$mailPassword = "localhost1997";

			if (strlen($password)>7 && strlen($password)<100 )
			{
			$data = array(
       			'email' => $e,
       			'password' => $password
       		);
			$query=$this->db->get_where('users', array('email' => $e));
			
			if ($this->form_validation->run() == TRUE)
	        {
	            if ($query->num_rows()==0 )
				{
					// Initialize library class
					//SMTP & mail configuration
					$config = array(
					    'protocol'  => 'smtp',
					    'smtp_host' => 'ssl://smtp.googlemail.com',
					    'smtp_port' => 465,
					    'smtp_user' => 'dadashovfikret22@gmail.com',
					    'smtp_pass' => 'localhost1997',
					    'mailtype'  => 'html',
					    'charset'   => 'utf-8'
					);
					$this->email->initialize($config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");

					//Email content
					$htmlContent = '<h1>Welcome</h1>';
					$htmlContent .= '<p>Please enter the security key : </p>'.$pass;

					$this->email->to($e);
					$this->email->from('dadashovfikret22@gmail.com','BUDGET');
					$this->email->subject('Welcome');
					$this->email->message($htmlContent);

					if ($this->email->send())
					{
						$this->db->insert('users', $data);
						redirect('/user/login/');
					}
					else {
						$a=7;
					}
				}
             	
             	else 
             	{
             		$a = 1 ;
             	}

	        }
	        else
	        {
	            $a=0;  
	        }
			}
			else 
			{
				$a=2;
			}
	        $this->session->set_userdata("error", $a);    
        }
		$this->load->view('signup');
	}

	public function login()
	{
		$this->session->unset_userdata( 'error' );
		$this->session->set_userdata("time", date('y-m-d'));
		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('user_password', 'Password', 'required');
		if ($this->input->post('submit'))
		{
			$email = $this->input->post('user_email');
			$password = $this->input->post('user_password');
			if ($this->form_validation->run() == TRUE)
            {
            	$this->session->unset_userdata( 'error' );
                $query=$this->db->get_where('users', array('email' => $email, 'password' => $password));
                if ($query->num_rows()>0)
				{
					$query = $query->result_array()[0];
                	$this->session->set_userdata("id", $query['id']);                	
                 	$this->session->set_userdata("month", date('m') );
                 	$this->session->set_userdata("year", date('y') );          	
                	redirect('/user/mainpage/');
				}
             	else 
             	{
             		$a=1;
             	}            
           	}
            else
            {
                 $a=0;
            }
            	 $this->session->set_userdata("error", $a);
        }
		$this->load->view('login');
	}

	public function mainpage()
	{
		$data['email']=$this->db->select('email')->from('users')
        ->where('id', $this->session->id )->get()->result_array();		
		
		$query['category']=$this->db->select('*')->from('categories')
        ->join('subcategory', 'subcategory.cat_id = categories.id')
		->get()->result_array();		
		
		$i=0;
		$ids = array();
		$query['wallets'] = $this->db->get_where('wallets', array('user_id' => $this->session->id, 'active' => 0))->result_array();
		$query['categories'] = $this->db->select('*')->from('categories')->get()->result_array();
		$times = $this->db->select('*')->from('transactions')->get()->result_array();
		foreach ($times as $key => $value) {
			$day1 = date('m', strtotime( $value['time']));
			$year1 = date('y', strtotime( $value['time']));
			if ($day1==$this->session->month && $year1==$this->session->year )
			{
				$ids[$i]  = $value['id'];
				$i++;
			}
		}

		if (!empty($ids)) 
		{
 			$this->session->set_userdata("errorss", 0 );
			if (!isset($_SESSION['selected']))
			{
				$data['trans']=$this->db
		        ->select('*, transactions.id')
		        ->from('transactions')
		        ->order_by('time', 'DESC')
		        ->where('transactions.user_id = '.$this->session->id)
		        ->where_in('transactions.id', $ids)
		        ->join('wallets', 'wallets.id = transactions.wallet_id')
		        ->where('wallets.active = '. 0)
		        ->join('notes', 'notes.id = transactions.note_id')
		        ->join('subcategory', 'subcategory.id = transactions.subcategory_id')
		        ->join('categories', 'categories.id = subcategory.cat_id')
		        ->get()->result_array();
		       // print_r($data);
		        if (empty($data['trans'])) 
				{
					$this->session->set_userdata("errorss", 1 );
				}
			}
			else 
			{
				$data['trans']=$this->db
		        ->select('*, transactions.id')
		        ->from('transactions')
		        ->order_by('time', 'DESC')
		        ->where('transactions.user_id = '.$this->session->id)
		        ->where('transactions.wallet_id = '.$this->session->selected)
		        ->where_in('transactions.id', $ids)
		        ->join('wallets', 'wallets.id = transactions.wallet_id')
		        ->where('wallets.active = '. 0)
		        ->join('notes', 'notes.id = transactions.note_id')
		        ->join('subcategory', 'subcategory.id = transactions.subcategory_id')
		        ->join('categories', 'categories.id = subcategory.cat_id')
		        ->get()->result_array();
		        
		        if (empty($data['trans'])) 
				{
					$this->session->set_userdata("errorss", 1 );
				}
			}

/*$size_of_session_estimate = strlen( serialize( $_SESSION ) );
print_r($size_of_session_estimate);*/


//print_r($data);
        $this->load->view('header', $data );
		$this->load->view('index', $data);
		$this->load->view('footer', $query); 
		}

		else 
		{
			$this->session->set_userdata("errorss", 1);
			$this->load->view('header');
			$this->load->view('index');
			$this->load->view('footer', $query); 
		}

	}

	public function forgot()
	{
		$this->load->view('forgot');
	}

	public function sendemail()
	{
		$this->form_validation->set_rules('user_email', 'Email', 'required');
		if ($this->form_validation->run() == TRUE)
	        {
		$email = $this->input->post('user_email');
		//$password = $this->db->select('*')->from('users')->where('email = '.$email)->get()->result_array()[0];
		$query = $this->db->get_where('users', array('email' => $email))->result_array()[0];
		$a=$query['password'];
		
		$config = array(
					    'protocol'  => 'smtp',
					    'smtp_host' => 'ssl://smtp.googlemail.com',
					    'smtp_port' => 465,
					    'smtp_user' => 'dadashovfikret22@gmail.com',
					    'smtp_pass' => 'localhost1997',
					    'mailtype'  => 'html',
					    'charset'   => 'utf-8'
					);
					$this->email->initialize($config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");

					//Email content
					$htmlContent = '<h1>Your Password</h1>';
					$htmlContent .=  $a ;

					$this->email->to($email);
					$this->email->from('dadashovfikret22@gmail.com','BUDGET');
					$this->email->subject('Forgot your password?');
					$this->email->message($htmlContent);

					//Send email
					$this->email->send();
		$this->load->view('forgot');
	}
	else{
		redirect('/user/forgot/');
	}
}
	public function selectwallet()
	{
		$id = $this->uri->segment(3);
		 $this->session->set_userdata("selected", $id);
		 redirect('user/mainpage');
	}

	public function allwallets()
	{
		$this->session->unset_userdata('selected');
		redirect('user/mainpage');
	}

	public function addwallet()
	{
		if ($this->input->is_ajax_request()) {

			$name = $this->input->post('wallet');
			$value = $this->input->post('currency');
			$data = array(
		        'wallet' => $this->input->post('wallet'),
		        'type' => $this->input->post('currency'),
		      	'user_id' => $this->session->id	          
			);
			$this->db->insert('wallets',$data);
		}
	}

	public function deletewallet()
	{
		if ($this->input->is_ajax_request()) 
		{
			$data = $this->input->post('wallet-id');
			foreach ($data as $key => $value) 
			{
				$query=$this->db->set('active', '1')->where('id', $value)->update('wallets');
			} 
		}
	}

	public function addtrans()
	{
		if ($this->input->is_ajax_request()) 
		{
			$money =  $this->input->post('trans-wallet') ;
			$categ =  $this->input->post('trans-cat');
			$note = array('note' => $this->input->post('trans-note') );
			$price=$this->input->post('trans-amount');
		
			if ($categ>=32 && $categ<=37 )
			{
				$a=$price;
			}
			else  {
				$a= -1 * $price;
			}	
			$data=$this->db->select('money')->from('wallets')->where('id = '.$money)->get()->result_array()[0];
			$data['money']+=$a; $a=$data['money'];
			$this->db->set('money', $a);
			$this->db->where('id', $money);
			$this->db->update('wallets');
			$date=$this->input->post('trans-date');
			$a = date('Y-m-d h:m:s', strtotime($date));	
			$name=$this->input->post('trans-wallet');
			$this->db->insert('notes', $note);
			$last_note_id = $this->db->insert_id();
			//$this->db->insert('subcategories', $category);
			//$last_cat_id = $this->db->insert_id();
			$data = array(
       			 'user_id' => $this->session->id,
       			 'price' => $price,
       			 'time' => $a,
       			 'wallet_id' => $name,
       			 'subcategory_id' => $categ,
       			 'note_id' => $last_note_id
       				);

			$this->db->insert('transactions', $data);
		}
	}

	public function edittrans()
	{
		if ($this->input->is_ajax_request()) 
		{
			$transid = $this->input->post('id');
			$categ =  $this->input->post('trans-cat');
			$price=$this->input->post('trans-amount');
			$note = array('note' => $this->input->post('trans-note') );
			$date=$this->input->post('trans-date');
			$money =  $this->input->post('trans-wallet');
			$ds =  $this->input->post('data-wallet') ;

			$note_id=$this->db->select('note_id')->from('transactions')->where('id = '.$transid)
			->get()->result_array()[0];
		
			if ($categ>=32 && $categ<=37 )
			{
				$a=$price;
			}
			else  {
				$a= -1 * $price;
			}	
			$data=$this->db->select('money')->from('wallets')->where('id = '.$money)->get()->result_array()[0];
			$data['money']+=$a; $a=$data['money'];
			
			$q = date('Y-m-d h:m:s', strtotime($date));	
			$name=$this->input->post('trans-wallet');
			
			$this->db->set('money', $a);
			$this->db->where('id', $money);
			$this->db->update('wallets');

			$this->db->set('note', $note['note']);
			$this->db->where('id', $note_id['note_id']);
			$this->db->update('notes');


$data = array(
       			 'price' => $price,
       			 'time' => $q,
       			 'wallet_id' => $name,
       			 'subcategory_id' => $categ
       				);

				$this->db->where('id', $transid);
				$this->db->update('transactions', $data);
			
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('selected');
		redirect('/user/login/');
	}

	public function previous()
	{
		$this->session->month--;
		if ($this->session->month==0)
		{
			$this->session->month=12;
			$this->session->year--;	
		}
		redirect('user/mainpage');
	}

	public function next()
	{
		$this->session->month ++;
		if ($this->session->month==13)
		{
			$this->session->month=01;
			$this->session->year++;
		}
		redirect('user/mainpage');
	}

	public function this()
	{
		redirect('user/mainpage');
	}
		
	public function today()
	{
		$this->session->set_userdata("month", date('m') );
	    $this->session->set_userdata("year", date('y') );
		redirect('user/mainpage');
	}

}
