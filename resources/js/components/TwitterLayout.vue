<template>
  <bundy v-slot="{ late, punctual }">
    <div
      :class="{
        'bg-red-300': late,
        'bg-gray-300': punctual
      }"
      class="relative twitter-layout bg-gray-300 min-h-screen pt-0 md:pt-16"
    >
      <header class="bg-white relative w-full shadow md:fixed md:left-0 md:top-0 md:right-0 z-40">
        <div class="container mx-auto">
          <div class="block md:flex md:items-center md:flex-row-reverse">
            <div class="w-full md:w-2/3">
              <div class="flex items-center justify-between p-2 pb-4 md:justify-end md:p-0 md:pb">
                <logo class="block bg-black text-white md:hidden" />
                <search class="mr-3 hidden md:block" />
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
                class="text-2xl py-2 px-0 cursor-pointer flex-1 text-center md:flex-0 md:px-2"
              >
                <fa :icon="icon" />
              </a>
            </div>
          </div>
        </div>
      </header>

      <main class="relative z-20">
        <keep-alive>
          <component :is="page" />
        </keep-alive>
      </main>

      <scheduler />
      <time-logger />
    </div>
  </bundy>
</template>

<script>
import Card from './Card'
import Search from './Search'
import UserPane from './UserPane'
import HomePage from './HomePage'
import { mapActions } from 'vuex'
import AdminPage from './AdminPage'
import Scheduler from './Scheduler'
import TimeLogger from './TimeLogger'
import ProfilePage from './ProfilePage'
import SettingsPage from './SettingsPage'
import PresenceWidget from './PresenceWidget'
import NotificationsPage from './NotificationsPage'
import AnnouncementsPage from './AnnouncementsPage'

export default {
  components: {
    Card,
    Search,
    UserPane,
    HomePage,
    Scheduler,
    AdminPage,
    TimeLogger,
    ProfilePage,
    SettingsPage,
    PresenceWidget,
    NotificationsPage,
    AnnouncementsPage,
  },

  computed: {
    user () {
      this.$store.getters['user/details']
    },

    menu () {
      return this.$store.getters['nav/items']
    },

    active () {
      return this.$store.getters['nav/active']
    },

    page () {
      return `${this.active}-page`
    }
  },

  methods: {
    navigate (page) {
      this.$store.dispatch('nav/navigate', { page })
      this.$progress.start()
      this.$progress.done()
    },
    
    isActive (item) {
      return this.active === item
    }
  }
}
</script>

