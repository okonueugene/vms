<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js/dist/popper.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>
@yield('scripts')

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script type="text/javascript">
    var beep = document.getElementById("myAudio1");

    function sound() {
        beep.play();
    }
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // web_token
        var firebaseConfig = {
            apiKey: "AIzaSyCwsKNDXae_U6PVp28rUsyeUVLZJGd2JsQ",
            authDomain: "visitor-app-f4cf8.firebaseapp.com",
            projectId: "visitor-app-f4cf8",
            storageBucket: "visitor-app-f4cf8.appspot.com",
            messagingSenderId: "916840265010",
            appId: "1:916840265010:web:0a79ffc97842d18924932b",
            measurementId: "G-B6CDGMQ910"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        startFCM();

        function startFCM() {
            messaging.requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajax({
                        url: '{{ route("admin.store.token") }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {

                        },
                        error: function(error) {

                        },
                    });
                }).catch(function(error) {

                });
        }
        messaging.onMessage(function(payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };

            sound();
            window.location.reload();
            new Notification(title, options);
        });

        @if(session('success'))
        iziToast.success({
            title: 'Success',
            message: '{{ session('
            success ') }}',
            position: 'topRight'
        });
        @endif

        @if(session('error'))
        iziToast.error({
            title: 'Error',
            message: '{{ session('
            error ') }}',
            position: 'topRight'
        });
        @endif
    });
</script>
