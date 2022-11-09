$('.custom-file-input').on('change', function() {
let fileName = $(this).val().split('\\').pop();
$(this).next('.custom-file-label').addClass("selected").html(fileName); 
});

document.onkeydown = function(e) {
  if (e.ctrlKey && 
      (e.keyCode === 67 || 
       e.keyCode === 86 || 
       e.keyCode === 85 || 
       e.keyCode === 117)) {
      return false;
  } else {
      return true;
  }
};

$(document).keypress("u",function(e) {
  if(e.ctrlKey) {
    return false;
  } else {
    return true;
  }
});

function flashdata(message) {
  Swal.fire({
    type: 'success',
    title: message,
    showConfirmButton: false,
    timer: 1500
  });
}

function confirm_delete(text, href) {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: text,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'OK',
    cancelButtonText: 'Batal',
    reverseButtons: true,
  }).then((result) => {
    if (result.value) {
      $.ajax({
          url : href,
          type: "POST",
          dataType: "JSON",
          success: function(response) {
            success_delete();
            flashdata(response.message);
          }
      });
    }
  })
}

function datatable(id, href) {
  table = $(id).DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "language": { 
        "infoFiltered": ""
      },
      "ajax": {
        "url": href,
        "type": "POST"
      },
      "columnDefs": [{ 
        "targets": [-1],
        "orderable": false,
      }],
    });
}

function form_serialize(form, btn) {
  $(form).on('submit', function (event) {
      event.preventDefault();
      event.stopImmediatePropagation();
      $(btn).attr('disabled', true);
      $.ajax({
          url: $(this).attr('action'),
          data: $(this).serialize(),
          type: "POST",
          success: function (response) {
            $(btn).removeAttr('disabled');
            if (response.status) {
              if (response.message) {
                flashdata(response.message);
              }
              if (response.id) {
                action_success(response.id);
              } else {
                action_success();
              }
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
      })
  });
}

function form_multipart(form, btn) {
  $(form).on('submit', function (event) {
      event.preventDefault();
      event.stopImmediatePropagation();
      $(btn).attr('disabled', true);
      $.ajax({
          url: $(this).attr('action'),
          type: "POST",
          data: new FormData(this),
          processData:false,
          contentType:false,
          cache:false,
          async:false,
          success: function (response) {
            $(btn).removeAttr('disabled');
            if (response.status) {
              if (response.message) {
                flashdata(response.message);
              }
              if (response.id) {
                action_success(response.id);
              } else {
                action_success();
              }
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
      })
  });
}

function reset_form(form) {
  $(form)[0].reset();
  $("input").removeClass('is-invalid');
  $("select").removeClass('is-invalid');
  $("textarea").removeClass('is-invalid');
  $(".select2").select2(null, false);
  $(".help-block").empty();
}

function reload_table() {
  table.ajax.reload(null, false);
}
function profile() {
  window.location.href = index + "home/profile";
}
function home() {
  window.location.href = index + "home";
}
function logout() {
  window.location.href = index + "login/logout";
}