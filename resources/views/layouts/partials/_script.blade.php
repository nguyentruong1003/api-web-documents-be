<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>

<script>
  window.addEventListener('show-toast', event => {
        if (event.detail.type == "success") {
            toastr.success(event.detail.message);
        } else if (event.detail.type == "error") {
            toastr.error(event.detail.message);
        }
    });
</script>
