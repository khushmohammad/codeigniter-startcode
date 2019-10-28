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
		$data['U_USERNAME']=$this->input->post('U_USERNAME');//htmlspecialchars($_POST['U_USERNAME']);  
		$data['U_PASSWORD']=$this->input->post('U_PASSWORD');//htmlspecialchars($_POST['U_PASSWORD']);  
		$res=$this->LoginModel->Login($data);  
		if($res){     
			$this->session->set_userdata('U_USERNAME',$data['U_USERNAME']);   
		  echo base_url()."Dashboard/"; 		 
		}  
		

	}
	public function logout(){  
		$this->session->sess_destroy();  
		header('location:'.base_url()."Welcome/".$this->index());  
		  
	}

}


