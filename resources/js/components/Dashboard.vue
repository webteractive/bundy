<template>
  <div class="dash bg-gray-200 min-h-screen relative">
    <div class="header z-10 py-8 px-12">
        <div class="flex">
          <div class="w-1/2">
            <h1 class="text-4xl w-full">Hello {{ user.name }}</h1>
            <h2 class="text-xl w-full">You're late again today</h2>
          </div>

          <div class="w-1/2 flex justify-end">
            <button
              :title="`Logout ${user.name} at once!`"
              @click="logout()"
              type="button"
              class="mr-4 text-red-500 hover:underline hover:text-red-600"
            >
              Logout
            </button>

            <name-initials />
          </div>
        </div>
    </div>

    <div class="z-20 min-h-screen bg-white rounded-t-xl">

    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import NameInitials from './NameInitials'

export default {
  components: {
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

