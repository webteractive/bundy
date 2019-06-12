import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './components/App'
import Logo from './components/Logo'
import Card from './components/Card'
import Face from './components/Face'
import Shoe from './components/Shoe'
import Modal from './components/Modal'
import storeIndex from './store/index'
import Field from './components/Field'
import Bundy from './components/Bundy'
import Accent from './components/Accent'
// import Layout from './components/Layout'
import Logout from './components/Logout'
import Helmet from './components/Helmet'
import Widget from './components/Widget'
import Fetcher from './components/Fetcher'
import UserPhoto from './components/UserPhoto'
import Layout from './components/TwitterLayout'
import PushButton from './components/PushButton'
import TimeLogger from './components/TimeLogger'
import PageLayout from './components/PageLayout'
import ContentTitle from './components/ContentTitle'
import Webteractive from './components/Webteractive'
import CustomSelect from './components/CustomSelect'
import OnClickOutside from './components/OnClickOutside'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faHome,
  faBell,
  faSearch,
  faBullhorn
} from '@fortawesome/free-solid-svg-icons'

import './bootstrap'

library.add(faHome)
library.add(faBell)
library.add(faSearch)
library.add(faBullhorn)

Vue.use(Vuex)
Vue.use(VueAxios, axios)

Vue.component('card', Card)
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
Vue.component('ct', ContentTitle)
Vue.component('fetcher', Fetcher)
Vue.component('fa', FontAwesomeIcon)
Vue.component('user-photo', UserPhoto)
Vue.component('time-logger', TimeLogger)
Vue.component('page-layout', PageLayout)
Vue.component('bundy-select', CustomSelect)
Vue.component('webteractive', Webteractive)
Vue.component('on-click-outside', OnClickOutside)

const { user } = BUNDY
const store = new Vuex.Store(storeIndex)

store.dispatch('hydrate', BUNDY)
store.dispatch('user/hydrate', user)

new Vue({
  el: '#bundy',
  store,
  render: h => h(App)
})
