import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './components/App'
import storeIndex from './store/index'
import Field from './components/Field'
import PushButton from './components/PushButton'

Vue.use(Vuex)
Vue.use(VueAxios, axios)

Vue.component('field', Field)
Vue.component('btn', PushButton)

const store = new Vuex.Store(storeIndex)

store.dispatch('hydrate', BUNDY)

new Vue({
  el: '#bundy',
  store,
  render: h => h(App)
})
