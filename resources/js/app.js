import Vue from 'vue'
import Bus from './module/bus'
import Http from './module/http'
// import Echo from './module/echo'
import App from './components/App'
import Tab from './components/Tab'
import PortalVue from 'portal-vue'
import Warp from './components/Warp'
import Logo from './components/Logo'
import Face from './components/Face'
import Shoe from './components/Shoe'
import Modal from './components/Modal'
import storeIndex from './store/index'
import Field from './components/Field'
import Bundy from './components/Bundy'
import Vuex, { mapGetters } from 'vuex'
import Progress from './module/progress'
import Accent from './components/Accent'
import Logout from './components/Logout'
import Helmet from './components/Helmet'
import Widget from './components/Widget'
import Fetcher from './components/Fetcher'
import LiveDate from './components/LiveDate'
import UserPhoto from './components/UserPhoto'
import TheButton from './components/TheButton'
import Layout from './components/TwitterLayout'
import PushButton from './components/PushButton'
import TimeLogger from './components/TimeLogger'
import PageLayout from './components/PageLayout'
import ContentTitle from './components/ContentTitle'
import Webteractive from './components/Webteractive'
import CustomSelect from './components/CustomSelect'
import ErrorManager from './components/ErrorManager'
import OnClickOutside from './components/OnClickOutside'
import NothingToShowYet from './components/NothingToShowYet'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faHome,
  faUser,
  faBell,
  faCogs,
  faStop,
  faPlus,
  faLink,
  faImage,
  faClock,
  faTrash,
  faSearch,
  faMapPin,
  faSquare,
  faHistory,
  faBullhorn,
  faSlidersH,
  faUserPlus,
  faAngleLeft,
  faHeartbeat,
  faAngleDown,
  faUserClock,
  faUserShield,
  faAngleRight,
  faSignOutAlt,
  faThumbsDown,
  faChevronLeft,
  faCheckSquare,
  faCalendarDay,
  faStepForward,
  faChevronRight,
  faStepBackward,
  faUserAstronaut,
  faLongArrowAltLeft,
  faLongArrowAltRight,
} from '@fortawesome/free-solid-svg-icons'
import {
  faSlack,
} from '@fortawesome/free-brands-svg-icons'

import './bootstrap'

library.add(faSlack)

library.add(faPlus)
library.add(faCogs)
library.add(faStop)
library.add(faUser)
library.add(faHome)
library.add(faBell)
library.add(faLink)
library.add(faImage)
library.add(faClock)
library.add(faTrash)
library.add(faSquare)
library.add(faSearch)
library.add(faMapPin)
library.add(faHistory)
library.add(faUserPlus)
library.add(faBullhorn)
library.add(faSlidersH)
library.add(faUserClock)
library.add(faHeartbeat)
library.add(faAngleDown)
library.add(faAngleLeft)
library.add(faHeartbeat)
library.add(faUserShield)
library.add(faAngleRight)
library.add(faThumbsDown)
library.add(faSignOutAlt)
library.add(faSignOutAlt)
library.add(faChevronLeft)
library.add(faCalendarDay)
library.add(faCheckSquare)
library.add(faStepForward)
library.add(faChevronRight)
library.add(faStepBackward)
library.add(faUserAstronaut)
library.add(faLongArrowAltLeft)
library.add(faLongArrowAltRight)

Vue.use(Vuex)
Vue.use(Http)
// Vue.use(Echo)
Vue.use(Bus)
Vue.use(Progress)
Vue.use(PortalVue)

Vue.component('tab', Tab)
Vue.component('warp', Warp)
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
Vue.component('live-date', LiveDate)
Vue.component('fa', FontAwesomeIcon)
Vue.component('the-button', TheButton)
Vue.component('user-photo', UserPhoto)
Vue.component('time-logger', TimeLogger)
Vue.component('page-layout', PageLayout)
Vue.component('bundy-select', CustomSelect)
Vue.component('webteractive', Webteractive)
Vue.component('error-manager', ErrorManager)
Vue.component('on-click-outside', OnClickOutside)
Vue.component('nothing-to-show-yet', NothingToShowYet)

const { user, profile, request } = BUNDY
const store = new Vuex.Store(storeIndex)

store.dispatch('hydrate', BUNDY)
store.dispatch('user/hydrate', user)

if (request.page === 'profile' && request.identifier !== null) {
  store.dispatch('profile/hydrate', profile)
}

window.onpopstate = event => store.dispatch('nav/warp', event.state)

new Vue({
  el: '#bundy',
  
  store,

  computed: {
    ...mapGetters({
      dayOfTheWeek: 'clock/dayOfTheWeek'
    })
  },

  watch: {
    dayOfTheWeek () {
      this.$nextTick(function() {
        this.$http.route('user.refresh').get()
          .then(({ data }) => {
            if (data !== false) {
              this.$store.dispatch('user/hydrate', data)
            } else {
              location.reload(true)
            }
          })
      })
    }
  },

  render: h => h(App),

  methods: {
    tick () {
      this.$store.dispatch('clock/tick')
    }
  },

  created () {
    this.tick()
    this.interval = setInterval(this.tick, 1000)
  },

  beforeDestroy () {
    clearInterval(this.interval)
  }
})
