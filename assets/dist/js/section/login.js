  $(document).ready(function () {
    $.validator.setDefaults({
        submitHandler: function () {
          logged_in();
        }
    });

    $('#form').validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true
        },
      },
      messages: {
        email: {
          required: "Email harus diisi",
          email: "Email tidak valid"
        },
        password: {
          required: "Password harus diisi"
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });

  function logged_in() {
      $.ajax({
          url : index + "login",
          type: "POST",
          data: $('#form').serialize(),
          dataType: "JSON",
          success: function(response) {
              if (response.status) {
                  window.location.href = index + "home";
              } else {
                if (response.error) {
                  $('[name="' + response.error + '"]').val(null);
                } else {
                  $('#form')[0].reset();
                }

                Swal.fire({
                  type: 'error',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                });

              }
          }
      });
  }