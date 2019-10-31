<script type="text/javascript"> 
 
 function State_List(countryId,stateId,cityId){
     $('#'+countryId).change(function(){
         $('#'+cityId).html('<option value="" selected> select </option>'); 
         var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('Dashboard/Get_StateList_Ajax');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){                        
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                        }
                        $('#'+stateId).html(html);
                    }
                });
                return false;

      });
  }   
function City_List(stateId,cityId){
       $('#'+stateId).change(function(){
         $('#'+cityId).html('<option value="" selected> select </option>');
         var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('Dashboard/Get_CityList_Ajax');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){                        
                        var html = '';
                        var i;
                        if(!data.length == ''){
                        for(i=0; i<data.length; i++){

                            html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                        }
                      }else{
                            html += '<option value="">Select</option>';                       
                      }
                       $('#'+cityId).html(html);
                    }
                });
                return false;
      });
   }     
</script>
</div>
 <!-- /.container-fluid -->
<!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div> 
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
</body>
<script src="<?= site_url('assets/vendor/js/sb-admin.min.js');?>"></script> 
<script src="<?= site_url('assets/js/custom.js');?>"></script>

</html>