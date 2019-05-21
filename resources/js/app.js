import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './components/App'

Vue.use(VueAxios, axios)

new Vue({
    el: '#bundy',
    render: h => h(App)
})
