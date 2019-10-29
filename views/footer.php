<script type="text/javascript">  
  function getBlockLov(rpbCode,prhCode) {
      var $obj = $('[name="'+rpbCode+'"]');
       $obj.parent().find('.bs-searchbox').children('.form-control').unbind().keyup(function(e){
        $array = [37,38,39,40];
        if ($.inArray(e.keyCode,$array)!=-1) {
           return false;
        }
        $search=$(this).val();
        var prh_Code = $('[name="'+prhCode+'"]').find('option:selected').val() ;
        $.ajax({
          type:"POST",
          url: "<?php echo site_url('RealestateCtr/getBlockAjax'); ?>",
          data: {searchdata: $search,prh_Code:prh_Code},
          success:function(response){
            $obj.html(response).selectpicker('refresh');
          }
        });
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

</html>