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
// comman function

function getBlockAjax(){
	    $prhCode=$this->input->post("prh_Code");
		$searchData=$this->input->post("searchdata");
	    $sql="SELECT * FROM REAL_M_PROPERTY_BLOCK
				WHERE RPB_COMP_CODE = '".$this->companyCode."' AND RPB_PRH_SYS_ID = '".$prhCode."' AND RPB_ACTIVE_YN='Y'
				AND(lower(RPB_BLOCK_DESC) LIKE lower('%".$searchData."%')) ORDER BY RPB_BLOCK_DESC ASC";
	    $getResult = $this->db->query($sql, $return_object = TRUE)->result_array();
		$option = '<option value="">Select Block</option>';
	    if(!empty($getResult)){
			foreach($getResult as $row){
				$option .= '<option value="'.$row['RPB_SYS_ID'].'">'.$row['RPB_BLOCK_DESC'].'</option>';
			}
		}
		echo $option;
	}
//comman function


	public function AdminUser()
	{
		$this->load->view('header');				
        $this->load->view('pages/DashUser_View');        
		$this->load->view('footer');
	}
	
	function DashUserView_Ajax()	
	{			
		$this->datatables->select("U_ID, U_USERNAME,U_GENDER ,U_PASSWORD, U_EMAIL, U_CONTACT, U_ADDRESS, U_COUNTRY, U_STATE, U_CITY ,U_PINCODE,U_ACTIVE ")
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
	function GetDashUserData_Ajax(){
		$sysId = 	$this->input->post('sysId');
		$sql = 'SELECT * FROM dash_users WHERE U_ID = "'.$sysId.'"';
		$result = $this->db->query($sql)->result_array();
		echo json_encode($result);
	}
	function DashUser_UpdateAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_UpdateAjax();
	}
	
}
