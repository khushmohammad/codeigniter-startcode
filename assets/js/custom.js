  function loader(){
        $('.loader').fadeIn();
      }
        //display loader on page load 
        
  function unloader(){
        $('.loader').fadeOut();
  }  

  $(function(){

    var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('.nav-item a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).addClass('active');
            }
        });

});

 
      
 if($('#menu1sub1 a').find('.active').length !== 0) {
   $('#menu1sub1').addClass('show');
  }
 


