window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

const pusher = new Pusher("14724be792f637a12cc0", {
    cluster: 'mt1'
});

const channel = pusher.subscribe('sgis-z');
channel.bind('my-event', function(data) {
    Push.create(data.message, {
        timeout: 2000,
        requireInteraction: true,
        body: 'Nouveau transfert enregistré',
        onClick() {
            location.href = "/";
        }
    })
        .catch(e => {
            alert('please enable notification')
            console.log(e);
        })
});

/*window.Echo = new Echo({
     broadcaster: 'my-event',
     key: process.env.MIX_PUSHER_APP_KEY,
     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
     forceTLS: true,
});*/
