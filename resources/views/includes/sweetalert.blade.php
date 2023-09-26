@push('css_vendor')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>
@endpush

@push('scripts_vendor')
    <script>
        function showAlert(message, type) {
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast',
                    },
                });
                switch (type) {
                    case 'success':
                        Toast.fire({
                            icon: 'success',
                            position: 'center',
                            title: message,
                        })
                        break;
                    case 'gagal':
                        Toast.fire({
                            icon: 'error',
                            position: 'center',
                            title: message,
                        })
                        break;

                    default:
                        break;
                }


            })
        }


        // ---- Start Function untuk delete data
        function deleteData(url) {
            Swal.fire({
                title: 'Yakin ?',
                text: "Menghapus Data Ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#87adbd ',
                cancelButtonColor: '#f27474',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',

            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            showAlert(response.message, 'success');
                            timeOut();
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            console.log(errors);
                            var message = 'Data gagal dihapus'
                            showAlert(message, 'gagal')
                        })
                }
            })
        }
        // ---- End Function untuk delete data

        // ---- Start Function untuk restore data
        function restoreData(url) {
            Swal.fire({
                title: 'Yakin ?',
                text: "Mengaktifkan Data Ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#87adbd ',
                cancelButtonColor: '#f27474',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',

            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'POST'
                        })
                        .done((response) => {
                            showAlert(response.message, 'success');
                            timeOut();
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            console.log(errors);
                            var message = 'Data gagal diaktifkan'
                            showAlert(message, 'gagal')
                        })
                }
            })
        }
        // ---- End Function untuk restore data

        function loopErrors(errors, message = true) {
            $('.invalid-feedback').remove();

            if (errors == undefined) {
                return;
            }

            for (error in errors) {
                $(`[name=${error}]`).addClass('is-invalid');

                if ($(`[name=${error}]`).hasClass('select2')) {
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`).next());
                } else if ($(`[name=${error}]`).hasClass('summernote')) {
                    $('.note-editor').addClass('is-invalid');
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`).next());
                } else if ($(`[name=${error}]`).hasClass('custom-control-input')) {
                    $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                        .insertAfter($(`[name=${error}]`).next());
                } else {
                    if ($(`[name=${error}]`).length == 0) {
                        $(`[name="${error}[]"]`).addClass('is-invalid');
                        $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                            .insertAfter($(`[name="${error}[]"]`).next());
                    } else {
                        $(`<span class="error invalid-feedback">${errors[error][0]}</span>`)
                            .insertAfter($(`[name=${error}]`));
                    }
                }
            }
        }

        function resetInput(selector) {
            $('.form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .custom-radio, .select2, .note-editor')
                .removeClass('is-invalid');
        }

        function resetForm(selector) {
            $(selector)[0].reset();
            $('.select2').trigger('change');
            $(`[name=body]`).summernote('code', '');
            $('.form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .custom-radio, .select2, .note-editor')
                .removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(`.preview-path_image`).attr('src', '').hide();
            $(`#preview-image`).attr('src', '').hide();
        }

        function loopForm(originalForm) {
            for (field in originalForm) {
                if ($(`[name=${field}]`).attr('type') != 'file') {
                    if ($(`[name=${field}]`).hasClass('summernote')) {
                        $(`[name=${field}]`).summernote('code', originalForm[field])
                    } else if ($(`[name=${field}]`).attr('type') == 'radio') {
                        $(`[name=${field}]`).filter(`[value="${originalForm[field]}"]`).prop('checked', true);
                    } else {
                        $(`[name=${field}]`).val(originalForm[field]);
                    }
                    $('select').trigger('change');
                } else {
                    $(`.preview-${field}`).attr('src', '/storage/' +
                        originalForm[field]).show();
                }
            }
        }

        function timeOut() {
            setTimeout(function() {
                location.reload();
            }, 2500);
        }
    </script>
@endpush
