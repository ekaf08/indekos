@push('scripts')
    <script>
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
    </script>
@endpush
