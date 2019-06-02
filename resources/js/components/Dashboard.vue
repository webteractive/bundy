<template>
  <div class="dash bg-gray-300 min-h-screen relative">
    <accent />
    <div class="header relative z-10 p-4 text-white md:py-8 md:px-4">
      <div class="container mx-auto">
        <div class="block md:flex md:flex-row-reverse">
          <div class="w-full mb-4 md:w-1/2 md:mb-0 flex justify-end items-center">
            <button
              :title="`Logout ${user.name} at once!`"
              @click="logout()"
              type="button"
              class="mr-4 hover:underline hover:text-red-600"
            >
              Logout
            </button>

            <name-initials />
          </div>

          <div class="w-full md:w-1/2">
            <h1 class="text-3xl w-full font-thin leading-none mb-2">Hello {{ user.name }}</h1>
            <status />
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto relative bg-gray-100 z-20 min-h-screen bg-white rounded-t">

    </div>

    <scheduler v-if="showScheduler" />
  </div>
</template>

<script>
import Status from './Status'
import { mapGetters } from 'vuex'
import Scheduler from './Scheduler'
import NameInitials from './NameInitials'

export default {
  components: {
    Status,
    Scheduler,
    NameInitials
  },

  data () {
    return {
      showScheduler: false
    }
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  },

  methods: {
    logout () {
      this.$http.post(BUNDY.apis.logout)
        .then(() => {
          this.$store.dispatch('user/logout')
        })
    }
  },

  mounted () {
    this.showScheduler = ! this.user.scheduled
  }
}
</script>

