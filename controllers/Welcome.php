<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()  
		{  
			parent::__construct();    
			$this->load->model('LoginModel');  
            $this->load->library('form_validation');            
			initialize('message');
		} 

	function switchLang($language = "") {        
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);        
        redirect($_SERVER['HTTP_REFERER']);        
    }	
	

	private function logged_in()
	{
		if( ! $this->session->userdata('U_USERNAME')){
			redirect('Welcome');
		}
	} 	
	public function index()
	{
		if($this->session->userdata('U_USERNAME')){
            redirect('Dashboard');
        }
        $data['title'] = 'Login Vilayat';
		$this->load->view('nonavheader',$data);				
        $this->load->view('Login');       
		
	}
	function Login(){
		   
		if($this->session->userdata('U_USERNAME')){
            redirect('Dashboard');
        }
	
		$data['U_USERNAME']=$this->input->post('U_USERNAME');// 
		$data['U_PASSWORD']=$this->input->post('U_PASSWORD');//  
		if($data['U_USERNAME'] ==''){
			 redirect('Welcome');
		}
		$res=$this->LoginModel->Login($data);  
		if(!empty($res)){
			$userdata = array(
                    'U_ID' => $res->U_ID,
                    'U_NAME' => $res->U_NAME,
                    'U_USERNAME' => $res->U_USERNAME,
                    'U_USER_TYPE' => $res->U_USER_TYPE,
                    'U_PASSWORD' => $res->U_PASSWORD,
                    'U_ACCESS_UPDATE' => $res->U_ACCESS_UPDATE,
                    'U_ACCESS_INSERT' => $res->U_ACCESS_INSERT,
                    'U_ACCESS_DELETE' => $res->U_ACCESS_DELETE,                    
                    'authenticated' => TRUE
                );			
		$this->session->set_userdata($userdata);   
		 // echo base_url()."Dashboard/"; 	
            redirect(base_url() . 'Dashboard');
		}
        else  
                {  
                     $this->session->set_flashdata('error', 'Invalid Username and Password');  
                     redirect(base_url() . 'Welcome');  
                }  
	}
	public function logout(){
		$userdata= 	array("U_NAME", "U_ID", "U_USERNAME","U_USER_TYPE", "U_PASSWORD", "U_ACCESS_UPDATE", "U_ACCESS_INSERT", "U_ACCESS_DELETE","site_lang");		
		$this->session->unset_userdata($userdata);  
		header('location:'.base_url()."Welcome/".$this->index());
	}

	public function ForgetPass()
	{	
		$this->load->view('nonavheader');				
        $this->load->view('pages/Forget_password');
	}
	public function Forget_password(){
		header('Content-Type: application/json');
		$email = $this->input->post('U_EMAIL');
		if(!empty($email)){
			$que=$this->db->query("select U_PASSWORD,U_USERNAME,U_EMAIL from dash_users where U_EMAIL='".$email."'");
				$row =$que->row_array();
				
				$user_email=$row['U_EMAIL'];			
			if((!strcmp($email, $user_email))){
				$pass=$row['U_PASSWORD'];
				$this->email->from('khushbhaijaan007@gmail.com', 'khush mohammad');
				$this->email->to($user_email);
				$this->email->subject('Password');
				$this->email->message("Your password is '".$pass ."'");
				if($this->email->send()){
					echo base_url()."Welcome/"; 

				}else{
					echo "0";
				}
			}
		}
	}





}


