import Pusher from 'pusher-js'
import Echo from 'laravel-echo'

const instance = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
})

window.Pusher = Pusher;
window.Echo = instance;

export default {
    install (Vue) {
        Vue.prototype.$echo = instance
    }
}
