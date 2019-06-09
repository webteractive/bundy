import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './components/App'
import Logo from './components/Logo'
import Face from './components/Face'
import Shoe from './components/Shoe'
import Modal from './components/Modal'
import storeIndex from './store/index'
import Field from './components/Field'
import Bundy from './components/Bundy'
import Accent from './components/Accent'
import Layout from './components/Layout'
import Logout from './components/Logout'
import Helmet from './components/Helmet'
import Widget from './components/Widget'
import PushButton from './components/PushButton'
import TimeLogger from './components/TimeLogger'
import Webteractive from './components/Webteractive'
import CustomSelect from './components/CustomSelect'

import './bootstrap'

Vue.use(Vuex)
Vue.use(VueAxios, axios)

Vue.component('shoe', Shoe)
Vue.component('face', Face)
Vue.component('logo', Logo)
Vue.component('field', Field)
Vue.component('bundy', Bundy)
Vue.component('modal', Modal)
Vue.component('widget', Widget)
Vue.component('layout', Layout)
Vue.component('logout', Logout)
Vue.component('accent', Accent)
Vue.component('helmet', Helmet)
Vue.component('btn', PushButton)
Vue.component('time-logger', TimeLogger)
Vue.component('webteractive', Webteractive)
Vue.component('bundy-select', CustomSelect)

const { user } = BUNDY
const store = new Vuex.Store(storeIndex)

store.dispatch('hydrate', BUNDY)
store.dispatch('user/hydrate', user)

new Vue({
  el: '#bundy',
  store,
  render: h => h(App)
})
