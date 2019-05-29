<template>
  <div class="dash bg-gray-100 min-h-screen relative">
    <accent />
    <div class="header relative z-10 py-8 px-8 text-white md:px-12">
      <div class="container mx-auto md:px-4">
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
            <h1 class="text-4xl w-full leading-none mb-2 text-center md:text-left">Hello {{ user.name }}</h1>
            <status />
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto relative z-20 min-h-screen bg-white shadow-lg rounded-t">

    </div>
  </div>
</template>

<script>
import Status from './Status'
import { mapGetters } from 'vuex'
import NameInitials from './NameInitials'

export default {
  components: {
    Status,
    NameInitials
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  },

  methods: {
    logout () {
      this.$http.post('void/logout')
        .then(() => {
          this.$store.dispatch('user/logout')
        })
    }
  }
}
</script>

