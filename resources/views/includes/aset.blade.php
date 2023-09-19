@push('scripts')
    <script>
        cekpass = () => {
            var x = document.getElementById("password");
            var y = document.getElementById("confirm_password");
            var z = document.getElementById("old_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }

            if (z.type === "password") {
                z.type = "text";
            } else {
                z.type = "password";
            }
        }
        //End menampilkan password dan konfirmasi password

        // untuk menghilangkan readonly password
        $(document).ready(function() {
            $('#ganti_password').change(function() {
                // console.log('disini');
                if (this.checked) {
                    $("#tampil_password").removeAttr("hidden");
                    $('#old_password').removeAttr('disabled');
                    $('#password').removeAttr('disabled');
                    $('#confirm_password').removeAttr('disabled');
                } else {
                    $("#tampil_password").attr("hidden", true);
                    $("#old_password").attr("disabled", true);
                    $("#password").attr("disabled", true);
                    $("#confirm_password").attr("disabled", true);
                }
            })
        });
        //End untuk menghilangkan readonly password

        //Fungsi untuk preview image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('input[name="path_image"]').change(function() {
            $('#hapus-lampiran').show();
            $('#preview-image').show();
            previewImage(this);
        });

        const hapusLampiran = document.querySelector('#hapus-lampiran');
        const imageTerpilih = document.querySelector('#preview-image');
        const inputImage = document.querySelector('#path_image');

        hapusLampiran.addEventListener('click', function() {
            imageTerpilih.src = '';
            inputImage.value = '';
            $('#hapus-lampiran').hide();
            $('#preview-image').hide();
        })
        //end Fungsi preview image

        // submit ke rout profil update
        $(document).ready(function() {
            $('#btn_simpan').click(function(event) {
                event.preventDefault();
                // Mengambil data dari form
                var formData = new FormData($('#form_profil')[0]);

                // Melakukan permintaan AJAX
                $.ajax({
                    type: 'POST', // Metode HTTP
                    url: '{{ route('profil.update') }}',
                    data: formData,
                    processData: false, // Diperlukan agar FormData tidak diproses secara otomatis
                    contentType: false, // Diperlukan agar tipe konten tidak diatur secara otomatis
                    success: function(response) {
                        showAlert(response.message, 'success');
                    },
                    error: function(errors) {
                        var message = errors.responseJSON.message;
                        showAlert(message, 'gagal');
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
            });
        });
        // End submit ke rout profil update

        // Cek email menggunakan fungsi key up
        $(document).ready(function() {
            $('#email').keyup(function() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var email = $('#email').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('cek_email') }}',
                    data: {
                        _token: csrfToken,
                        email: email
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#emailStatus').text('Alamat email sudah terdaftar.').addClass(
                                'text-danger');
                            $('#email').addClass('is-invalid');
                        } else {
                            // $('#emailStatus').text('Alamat email tersedia.').add('color','green');
                            $('#emailStatus').text('Alamat email tersedia.').addClass(
                                'text-success');
                            $('#email').addClass('is-valid');

                        }
                    },
                    error: function() {
                        $('#emailStatus').text('Terjadi kesalahan dalam memeriksa email.').css(
                            'color', 'red');
                    }
                });
            });
        });
        //End Cek email menggunakan fungsi key up
    </script>
@endpush
