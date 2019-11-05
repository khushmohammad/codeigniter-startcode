<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()  
		{  
			parent::__construct();    
			$this->load->model('LoginModel');    
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
		$this->load->view('nonavheader');				
        $this->load->view('Login');       
		
	}
	function login(){
		if($this->session->userdata('U_USERNAME')){
            redirect('Dashboard');
        }
		$data['U_USERNAME']=$this->input->post('U_USERNAME');// 
		$data['U_PASSWORD']=$this->input->post('U_PASSWORD');//  
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
		  echo base_url()."Dashboard/"; 		 
		}
	}
	public function logout(){
		$userdata= 	array("U_NAME", "U_ID", "U_USERNAME","U_USER_TYPE", "U_PASSWORD", "U_ACCESS_UPDATE", "U_ACCESS_INSERT", "U_ACCESS_DELETE");		
		$this->session->unset_userdata($userdata);  
		header('location:'.base_url()."Welcome/".$this->index());
	}

}


