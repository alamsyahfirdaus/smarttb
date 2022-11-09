$(document).ready(function () {
  $.validator.setDefaults();
  $('#form').validate({
    rules: {
      password: {
        required: true
      },
      new_password1: {
        required: true,
        minlength: 3
      },
      new_password2: {
        required: true,
        minlength: 3,
        equalTo: "#new_password1"
      },
      pass1: {
        minlength: 3
      },
      pass2: {
        minlength: 3,
        equalTo: "#pass1"
      },
      prodi_id: {
        required: true
      },
      role_id: {
        required: true
      },
      kelas_id: {
        required: true
      },
      email: {
        required: true,
        email: true,
      },
      nim: {
        required: true,
        minlength: 11
      },
      nidn: {
        required: true,
        minlength: 8
      },
      full_name: {
        required: true
      },
      gander: {
        required: true
      },
      date_of_birth: {
        required: true
      },
      phone: {
        required: true,
        minlength: 11
      },
    },
    messages: {
      password: {
        required: "Password wajib diisi"
      },
      new_password1: {
        required: "Password wajib diisi",
        minlength: "Password minimal 3 karakter"
      },
      new_password2: {
        required: "Konfirmasi Password wajib diisi",
        minlength: "Password minimal 3 karakter",
        equalTo: "Konfirmasi Password tidak sama"
      },
      pass1: {
        minlength: "Password minimal 3 karakter"
      },
      pass2: {
        minlength: "Password minimal 3 karakter",
        equalTo: "Konfirmasi Password tidak sama"
      },
      prodi_id: {
        required: "Program Studi wajib diisi"
      },
      kelas_id: {
        required: "Kelas wajib diisi"
      },
      email: {
        required: "Email wajib diisi",
        email: "Email tidak valid"
      },
      nim: {
        required: "NIM wajib diisi",
        minlength: "NIM minimal 11 karakter"
      },
      nidn: {
        required: "NIDN wajib diisi",
        minlength: "NIDN minimal 8 angka"
      },
      full_name: {
        required: "Nama Lengkap wajib diisi"
      },
      phone: {
        required: "No. Handphone wajib diisi",
        minlength: "No. Handphone minimal 11 angka"
      },
      role_id: {
        required: "Jenis Pengguna wajib diisi"
      },
      gander: {
        required: "Jenis Kelamin wajib diisi"
      },
      date_of_birth: {
        required: "Tanggal Lahir wajib diisi"
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.input-group').append(error);
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});