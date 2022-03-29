<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        const pusher = new Pusher("14724be792f637a12cc0", {
            cluster: 'mt1'
        });

        const channel = pusher.subscribe('sgis-z');
        channel.bind('my-event', function(data) {
            //alert(JSON.stringify(data));
            Push.create('Hello World!', {
                timeout: 2000,
                requireInteraction: true,
                body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, expedita.',
                onClick() {
                    location.href = "/";
                }
            })
                .catch(e => {
                    alert('please enable notification')
                    console.log(e);
                })
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>

</body>
