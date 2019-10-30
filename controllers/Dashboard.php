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
		$this->datatables->select("*")
		->from('dash_users');
		echo $this->datatables->generate();	   
	}

	function DashUser_SaveAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_SaveAjax($this->userId);
	}
	function DashUserDelete_Ajax(){
	$sysId =	$this->input->post('sysId');	
	$delete = $this->db->delete('dash_users',"U_ID = '".$sysId."'");
	 if($delete){
	 	echo json_encode('delete seccessfully');
	 }
	}
	function GetDashUserData_Ajax(){
		$sysId = 	$this->input->post('sysId');
		$sql = 'SELECT * FROM dash_users WHERE U_ID = "'.$sysId.'"';
		$result = $this->db->query($sql)->result_array();
		echo json_encode($result);
	}
	function DashUser_UpdateAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_UpdateAjax($this->userId);
	}
	
}
