<script type="text/javascript">
    let _token = '{{@csrf_token()}}';

    function show_notify(message, status) {
        const statusClassMap = {
            'success': 'bg-success',
            'fail': 'bg-danger',
            'warning': 'bg-warning',
            'info': 'bg-info'
        };
        Toastify({
            text: message,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            className: statusClassMap[status] || 'bg-info',
            duration: 10000,
            close: true
        }).showToast();
    }

    @if(session()->has('status') && session()->has('message'))
        show_notify("{!! session()->get('message') !!}", "{{session()->get('status')}}");
    @endif

    @if(session()->has('success'))
        show_notify("{!! session()->get('success') !!}", 'success');
    @endif

    @if(session()->has('error'))
        show_notify("{!! session()->get('error') !!}", 'fail');
    @endif

    @if(session()->has('warning'))
        show_notify("{!! session()->get('warning') !!}", 'warning');
    @endif

    @if(session()->has('info'))
        show_notify("{!! session()->get('info') !!}", 'info');
    @endif

    // Start Hide Show Loader
    function show_loader() {$('.custom_loading').fadeIn('slow')}
    function hide_loader() {$('.custom_loading').fadeOut('slow')}
    show_loader();
    // End Hide Show Loader
</script>
