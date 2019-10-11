<template>
  <div
    :class="{
      [randomColor]: timeLog === null,
      'bg-red-300': timeLog && timeLog.late,
      'bg-gray-300': timeLog && (timeLog.on_time || timeLog.early_bird),
    }"
    class="transition-bg-color relative twitter-layout min-h-screen pt-0 md:pt-16"
  >
    <header class="bg-white relative w-full shadow md:fixed md:left-0 md:top-0 md:right-0 z-40">
      <div class="container mx-auto">
        <div class="block md:flex md:items-center md:flex-row-reverse">
          <div class="w-full md:w-2/3">
            <div class="flex items-center justify-between p-2 pb-4 md:justify-end md:p-0 md:pb">
              <logo class="block bg-black text-white md:hidden" />
              <search class="mr-3 hidden md:block" />
              <!-- <actionables class="mr-3" /> -->
              <user-pane />
            </div>
          </div>

          <div class="flex items-center w-full md:justify-start md:w-1/3">
            <a
              v-for="[name, icon] in menu"
              :key="name"
              :class="{
                'md:hidden': name === 'search',
                'border-blue-500 border-b-2 text-blue-500': isActive(name),
                'border-transparent border-b-2 text-gray-400 hover:bg-gray-100 hover:text-blue-500': ! isActive(name),
              }"
              @click="navigate(name)"
              class="relative text-2xl py-2 px-0 cursor-pointer flex-1 text-center md:flex-0 md:px-2"
            >
              <fa :icon="icon" />
              <span
                v-if="name === 'notifications' && unreadNotifications.length > 0"
                :class="`
                  bg-blue-500 text-white text-xs px-1 absolute 
                  border-2 border-white
                `"
                v-text="unreadNotifications.length"
                style="left: 50%; margin-left: 2px; margin-top: -1px;"
              />
            </a>
          </div>
        </div>
      </div>
    </header>

    <success-manager />

    <main class="relative z-20">
      <!-- <component :is="page" /> -->
      <router-view />
    </main>

    <scrum />
    <remote />
    <scheduler />
    <time-logger />
    <time-log-details />

    <portal-target name="modal" />
  </div>
</template>

<script>
import Scrum from './Scrum'
import Search from './Search'
import Remote from './Remote'
import UserPane from './UserPane'
import HomePage from './HomePage'
import NotFound from './NotFound'
import AdminPage from './AdminPage'
import Scheduler from './Scheduler'
import TimeLogger from './TimeLogger'
import Actionables from './Actionables'
import AccountPage from './AccountPage'
import ProfilePage from './ProfilePage'
import notifier from '../mixin/notifier'
import SettingsPage from './SettingsPage'
import SchedulesPage from './SchedulesPage'
import SuccessManager from './SuccessManager'
import PresenceWidget from './PresenceWidget'
import TimeLogDetails from './TimeLogDetails'
import { mapGetters, mapActions } from 'vuex'
import PerformancePage from './PerformancePage'
import EditProfilePage from './EditProfilePage'
import PermissionDenied from './PermissionDenied'
import NotificationsPage from './NotificationsPage'
import AnnouncementsPage from './AnnouncementsPage'

export default {
  mixins: [
    notifier
  ],

  components: {
    Scrum,
    Search,
    Remote,
    UserPane,
    HomePage,
    NotFound,
    Scheduler,
    AdminPage,
    TimeLogger,
    Actionables,
    AccountPage,
    ProfilePage,
    SettingsPage,
    SchedulesPage,
    TimeLogDetails,
    SuccessManager,
    PresenceWidget,
    EditProfilePage,
    PerformancePage,
    PermissionDenied,
    NotificationsPage,
    AnnouncementsPage,
  },

  data () {
    return {
      randomColor: 'bg-gray-300'
    }
  },

  computed: {
    ...mapGetters({
      // menu: 'nav/items',
      pages: 'nav/pages',
      active: 'nav/active',
      user: 'user/details',
    }),

    menu () {
      return [
        ['/', 'home']
      ]
    },

    timeLog () {
      return this.user.todays_time_log
    },

    page () {
      if (this.pages.includes(this.active) === false) {
        return 'not-found'
      }

      const { permissions } = this.user

      if (this.active === 'admin' && permissions.includes('manage-admin') === false) {
        return 'permission-denied'
      }

      return `${this.active.toComponent()}-page`
    }
  },

  methods: {
    navigate (page) {
      this.$store.dispatch('nav/navigate', { page })
      
      if (page === 'home') {
        this.$bus.emit('stream.refresh')
      }

      this.$progress.start()
      this.$progress.done()
    },
    
    isActive (item) {
      return this.active === item
    },

    pickColor () {
      const colors = [
        'bg-yellow-500', 'bg-teal-500', 'bg-indigo-900', 'bg-purple-900',
        'bg-black', 'bg-gray-900', 'bg-pink-900'
      ]
      
      this.randomColor = colors[Math.floor(Math.random() * colors.length)]
    },
  },

  created () {
    this.fetchNotifications()

    this.pickColor();
    this.interval = setInterval(this.pickColor, 10000)

    // this.$echo.private(`App.User.${this.user.id}`)
    //   .notification((notification) => {
    //     this.fetchNotifications()
    //   });
  },

  beforeDestroy () {
    clearInterval(this.interval)
  }
}
</script>

