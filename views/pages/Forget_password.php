<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Forget Password</div>
      <div class="card-body">
          <div class="alertMessage"></div>
        <form  method="post">          
          <div class="form-group">           
            <label for="">Email</label>  
              <input type="email" id="U_EMAIL" name="U_EMAIL" class="form-control" placeholder="user email" required="required">
          </div>
          <input type="submit" value="Send Password" class="btn btn-primary btn-block" id="submit" />
        </form>
        <div class="text-center">
          
          <a class="d-block small" href="<?php echo site_url("Welcome") ?>">Login page</a>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript"> 
  
  // Ajax post  
  $(document).ready(function(){  
  $("#submit").click(function(){  
  var U_EMAIL = $("#U_EMAIL").val();  
   
  // Returns error message when submitted without req fields.  
  if(U_EMAIL=='')  
  {  
       
        $('.alertMessage').append('<div class="alert alert-warning" role="alert">Please enter email </div>');
        setTimeout(function(){ 
          $('.alertMessage').empty();
         }, 2000);
  }  
  else  
  {  
  // AJAX Code To Submit Form. 
   $('.alertMessage').empty();  
  $.ajax({ 

  type: "POST",  
  url:  "<?php echo base_url(); ?>" + "Welcome/Forget_password",  
  data: {U_EMAIL: U_EMAIL},  
  cache: false,  
  success: function(result){  
      if(result!=0){ 
    //  alert('aaya'); 
          // On success redirect.  
      $('.alertMessage').append('<div class="alert alert-success" role="alert">Check your email <a href="'+result+'"> login page</a> </div>');

      }  
      else  {       
          $('.alertMessage').append('<div class="alert alert-danger" role="alert">Wrong user email and Something wrong </div>');
        setTimeout(function(){ 
          $('.alertMessage').empty();
         }, 2000);
  } 
  
  }  
  });  
  return false;  
  }  
  });
  });
   
  </script>   