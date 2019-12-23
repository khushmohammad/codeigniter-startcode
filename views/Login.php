<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
          <div class="alertMessage"></div>
        <form   method="post" action="<?php echo base_url(); ?>Welcome/Login">
          <div class="form-group">
           
            <label for="">Username</label> 
              <input type="text" id="U_USERNAME" name="U_USERNAME" class="form-control" placeholder="Username" required="required">
          </div>
          <div class="form-group">
           
            <label for="">Password</label>  
              <input type="password" id="U_PASSWORD" name="U_PASSWORD" class="form-control" placeholder="Password" required="required">
          </div>
        <?php echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>'; ?>     
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <input type="submit" value="Login" class="btn btn-primary btn-block" id="submit" />

        </form>
        <div class="text-center">
          
          <a class="d-block small" href="<?php echo site_url("Welcome/ForgetPass") ?>">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"> 
//  
//  // Ajax post  
//  $(document).ready(function(){  
//  $("#submit").click(function(){  
//  var U_USERNAME = $("#U_USERNAME").val();  
//  var U_PASSWORD = $("#U_PASSWORD").val();  
//  // Returns error message when submitted without req fields.  
//  if(U_USERNAME==''||U_PASSWORD=='')  
//  {  
//       
//        $('.alertMessage').append('<div class="alert alert-warning" role="alert">Please Enter Username And Password </div>');
//        setTimeout(function(){ 
//          $('.alertMessage').empty();
//         }, 2000);
//  }  
//  else  
//  {  
//  // AJAX Code To Submit Form.  
//  $.ajax({  
//  type: "POST",  
//  url:  "<?php ///echo base_url(); ?>" + "Welcome/login",  
//  data: {U_USERNAME: U_USERNAME, U_PASSWORD: U_PASSWORD},  
//  cache: false,  
//  success: function(result){  
//      if(result!=0){  
//          // On success redirect.  
//      window.location.replace(result);   
//      }  
//      else  {
//          $('.alertMessage').append('<div class="alert alert-danger" role="alert">Wrong Username And Password </div>');
//        setTimeout(function(){ 
//          $('.alertMessage').empty();
//         }, 2000);
//  } 
//  
//  }  
//  });  
//  return false;  
//  }  
//  });
//  });
//   
  </script>   