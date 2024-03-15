<x-admin-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button onclick="startFCM()"
                        class="btn btn-danger btn-flat">Allow notification
                </button>
                <div class="card mt-3">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('send.web-notification') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Message Title</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label>Message Body</label>
                                <textarea class="form-control" name="body"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyACAtIbXFrOnUy-_l-rvT3HHR0OarhqkEs",

            authDomain: "victoira-e0643.firebaseapp.com",

            projectId: "victoira-e0643",

            storageBucket: "victoira-e0643.appspot.com",

            messagingSenderId: "236393939756",

            appId: "1:236393939756:web:375bf6c41f69b1ea0b2289",

            measurementId: "G-FT1P390BTJ"

        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function startFCM() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (response) {
                    // Include CSRF token in AJAX request headers
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{ route("store.token") }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            token: response,
                        },
                        dataType: 'json',
                        success: function (response) {
                            alert('Token stored.');
                        },
                        error: function (error) {
                            alert('Error storing token.');
                        },
                    });
                })
                .catch(function (error) {
                    alert(error);
                });
        }

        messaging.onMessage(function (payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });
    </script>

</x-admin-layout>
