<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
            parent::__construct();                  
            $this->load->model('LoginModel'); 
            $this->logged_in();
            $this->userId = $this->session->userdata('U_USERNAME');
			$userId = $this->session->userdata('U_USERNAME');
				
          }
        // check log in  function  
        private function logged_in()
        {
            if( ! $this->session->userdata('U_USERNAME')){
                redirect('Welcome');			
            }
            
        }      

	public function index()
	{
		$this->load->view('header');				
        $this->load->view('pages/Dashboard_View');        
		$this->load->view('footer');
	}
	public function AdminUser()
	{
		$this->load->view('header');				
        $this->load->view('pages/DashUser_View');        
		$this->load->view('footer');
	}
	
	function DashUserView_Ajax()	
	{			
		$this->datatables->select("U_ID, U_USERNAME,U_PASSWORD, U_EMAIL, U_CONTACT, U_ADDRESS, U_COUNTRY, U_STATE, U_CITY ,U_PINCODE,U_ACTIVE ")
		->from('dash_users');
		echo $this->datatables->generate();	   
	}

	function DashUser_SaveAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_SaveAjax();



	}
	function DashUserDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	 $delete = $this->db->delete('dash_users',"U_ID = '".$sysId."'");
	 if($delete){
	 	echo json_encode('delete seccessfully');
	 }
	}
	
}
