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

        //comman function
        function Get_StateList_Ajax(){

        	$Country_Id = $this->input->post('id',TRUE);
			$data = $this->LoginModel->Get_StateList($Country_Id)->result();
			echo json_encode($data);

        }
        function Get_CityList_Ajax(){

        	$State_Id = $this->input->post('id',TRUE);
			$data = $this->LoginModel->Get_CityList($State_Id)->result();
			echo json_encode($data);

        }

        //common function
   
	public function index()
	{
		$this->load->view('header');				
        $this->load->view('pages/Dashboard_View');        
		$this->load->view('footer');
	}
	public function AdminUser()
	{
		$this->load->view('header');	
		$data['countries']	= $this->LoginModel->country_list();		
        $this->load->view('pages/DashUser_View',$data);                
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
		$result['data'] = $this->db->query($sql)->result_array();
		$result['stateOption'] = $this->getSelectedState($result['data'][0]['U_COUNTRY']);
		$result['cityOption'] = $this->getSelectedCity($result['data'][0]['U_STATE']);
		echo json_encode($result);
	}

	function getSelectedState($selectedCountryCode){
	    $sql="SELECT * FROM states WHERE country_id='".$selectedCountryCode."' ORDER BY name ASC";
	    $stateArray = $this->db->query($sql)->result_array();
	    $optionHtml = '';
	    $optionHtml .= '<option value="">Select State</option>';
	    if(!empty($stateArray)){
			foreach($stateArray as $row) {
				$optionHtml .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
        }
		return $optionHtml;
	}
	function getSelectedCity($selectedStateCode){
	    $sql="SELECT * FROM cities WHERE state_id='".$selectedStateCode."' ORDER BY name ASC";
	    $cityArray = $this->db->query($sql)->result_array();
	    $optionHtml = '';
	    $optionHtml .= '<option value="">Select city</option>';
	    if(!empty($cityArray)){
			foreach($cityArray as $row) {
				$optionHtml .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
        }
		return $optionHtml;
	}
	function DashUser_UpdateAjax(){
		header('Content-Type: application/json');
		$this->LoginModel->DashUser_UpdateAjax($this->userId);
	}
	
}
