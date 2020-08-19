import Vue from 'vue'
import VueRouter from 'vue-router'
import PortalVue from 'portal-vue'
import Vuex, { mapGetters } from 'vuex'

import Bus from './module/bus'
import Http from './module/http'
// import Echo from './module/echo'
import Progress from './module/progress'
import GlobalComponents from './module/globalComponents'

import routes from './routes'
import storeIndex from './store/index'

import App from './components/App'

import './fa'
import './bootstrap'

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(Http)
// Vue.use(Echo)
Vue.use(Bus)
Vue.use(Progress)
Vue.use(PortalVue)
Vue.use(GlobalComponents)

const { user, profile, request } = BUNDY
const store = new Vuex.Store(storeIndex)

store.dispatch('hydrate', BUNDY)
store.dispatch('user/hydrate', user)

if (request.page === 'profile' && request.identifier !== null) {
  store.dispatch('profile/hydrate', profile)
}

window.onpopstate = event => store.dispatch('nav/warp', event.state)

const router = new VueRouter({
  routes,
  mode: 'history'
})

new Vue({
  el: '#bundy',
  
  store,

  router,

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
