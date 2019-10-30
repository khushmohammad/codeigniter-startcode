<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form  method="post">
          <div class="form-group">
           
            <label for="">Username</label> 
              <input type="text" id="U_USERNAME" class="form-control" placeholder="Username" required="required">
              
            
          </div>
          <div class="form-group">
           
            <label for="">Password</label>  
              <input type="password" id="U_PASSWORD" class="form-control" placeholder="Password" required="required">
            
            
          </div>
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
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"> 
  
  // Ajax post  
  $(document).ready(function(){  
  $("#submit").click(function(){  
  var U_USERNAME = $("#U_USERNAME").val();  
  var U_PASSWORD = $("#U_PASSWORD").val();  
  // Returns error message when submitted without req fields.  
  if(U_USERNAME==''||U_PASSWORD=='')  
  {  
        alert('wrong entry');
  }  
  else  
  {  
  // AJAX Code To Submit Form.  
  $.ajax({  
  type: "POST",  
  url:  "<?php echo base_url(); ?>" + "Welcome/login",  
  data: {U_USERNAME: U_USERNAME, U_PASSWORD: U_PASSWORD},  
  cache: false,  
  success: function(result){  
      if(result!=0){  
          // On success redirect.  
      window.location.replace(result);   
      }  
      else  
         alert('failed')  
  }  
  });  
  }  
  return false;  
  });  
  });  
  </script>   