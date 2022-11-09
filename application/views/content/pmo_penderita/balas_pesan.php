<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><?= $subtitle ?></h3>
            <input type="text" name="received_id" value="<?= $received_id ?>" style="display: none;">
            <input type="text" name="base_url" value="<?= site_url('pmo/message/') ?>"  style="display: none;">
            <div class="card-tools"></div>
          </div>
          <div class="card-body">
            <div id="content"></div>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12"></div>
    </div>
  </div>
</section>
<script type="text/javascript">
  var received_id   = $('[name="received_id"]').val();
  var base_url      = $('[name="base_url"]').val();

   $(document).ready(function() {
      get_message();

      $('#message').keypress(function (event) {
       if(event.which == 13) {
          $('#btn_submit').click();
          return false;  
        }
      }); 
      
   });

   function get_message() {
     $.ajax({
         url : base_url + "get_message/" + received_id,
         type: "GET",
         dataType: "JSON",
         success: function(response) {
           $('#content').html(response.message);
         }
     });
   }

   function send_message() {
     $.ajax({
         url : base_url + "send_message/" + received_id,
         type: "POST",
         data: new FormData($('#form')[0]),
         contentType:false,
         processData:false,
         dataType: "JSON",
         success: function(response) {
           if (response.status) {
               get_message();
           } else {
             $.each(response.errors, function (key, val) {
                 $('[name="' + key + '"]').addClass('is-invalid');
                 $('[name="'+ key +'"]').next('.help-block').text(val);
                 if (val === '') {
                     $('[name="' + key + '"]').removeClass('is-invalid');
                     $('[name="'+ key +'"]').next('.help-block').text('');
                 }
             });
           }
         }
     });
   }

   function delete_massage(id) {
     $.ajax({
         url : base_url + "delete/" + id,
         type: "POST",
         dataType: "JSON",
         success: function(response) {
           get_message();
         }
     });
   }


</script>