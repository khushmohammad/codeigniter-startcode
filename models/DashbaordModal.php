<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashbaordModal extends CI_Model {
	function totalPet(){
        $sqlQry = "SELECT *	FROM v_pets";
		return $this->db->query($sqlQry)->num_rows();
   }
   function totalMale(){
        $sqlQry = "SELECT *	FROM v_pets WHERE P_GENDER = 'MALE'";
       
		return $this->db->query($sqlQry)->num_rows();
   }
    function totalFemale(){
        $sqlQry = "SELECT *	FROM v_pets WHERE P_GENDER = 'FEMALE'";
		return $this->db->query($sqlQry)->num_rows();
   }
    function totalSold(){
        $sqlQry = "SELECT *	FROM v_pets WHERE P_STATUS = 'SOLD'";
		return $this->db->query($sqlQry)->num_rows();
   }
		 
	}
    