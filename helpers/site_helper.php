<?php 


  function initialize($filename ='') {
        $ci =& get_instance();
        $ci->load->helper('language');
        $siteLang = $ci->session->userdata('site_lang');
        if ($siteLang) {
            $ci->lang->load($filename,$siteLang);
        } else {
            $ci->lang->load($filename,'english');
        }
    }

    