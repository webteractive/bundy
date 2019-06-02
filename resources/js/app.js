import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './components/App'
import Modal from './components/Modal'
import storeIndex from './store/index'
import Field from './components/Field'
import Bundy from './components/Bundy'
import Accent from './components/Accent'
import PushButton from './components/PushButton'
import CustomSelect from './components/CustomSelect'

import './bootstrap'

Vue.use(Vuex)
Vue.use(VueAxios, axios)

Vue.component('field', Field)
Vue.component('bundy', Bundy)
Vue.component('modal', Modal)
Vue.component('accent', Accent)
Vue.component('btn', PushButton)
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
