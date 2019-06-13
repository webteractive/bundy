<template>
  <on-click-outside :do="close">
    <div 
      :class="[`
        relative flex items-center text-gray-800 pr-0 cursor-pointer rounded-full
        md:pr-1 hover:bg-gray-300
      `, {
        'bg-gray-300': shown
      }]"
      @click="toggle()"
    >
      <user-photo
        size="12"
        class="bg-gray-500 md:h-8 md:w-8 md:mr-1"
      />

      <span v-text="user.username" class="hidden md:inline mr-1" />

      <div class="hidden md:inline-flex">
        <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>

      <div 
        v-if="shown"
        class="absolute w-320 bg-white shadow top-10 right-0"
      >
        <ul>
          <li
            v-for="[ name, icon ] in menu"
            :key="name"
            :class="{
              'text-blue-500': isActive(name)
            }"
            @click.stop="navigate(name)"
            class="p-4 hover:text-blue-500 flex items-center"
          >
            <span class="flex w-8">
              <fa :icon="icon" />
            </span>
            <span class="capitalize" v-text="name" />
          </li>
          <li class="border-b border-gray-200 mb-4" />
          <li class="p-4">
            <logout class="hover:text-red-500 capitalize" />
          </li>
        </ul>
      </div>
    </div>
  </on-click-outside>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      shown: false
    }
  },

  computed: {
    ...mapGetters({
      menu: 'nav/user',
      active: 'nav/active',
      user: 'user/details',
      profile: 'profile/details',
    })
  },

  methods: {
    toggle () {
      this.shown = ! this.shown
    },

    close () {
      this.shown = false
    },

    isActive (item) {
      return this.active == item && this.user.username === this.profile.username
    },

    navigate (page) {
      let identifier = null

      this.$progress.start()
      this.$progress.done()
      
      if (page === 'profile') {
        identifier = this.user.username

        this.$store.dispatch('profile/hydrate', this.user);
        this.go({page, identifier})

      } else {
        this.go({page, identifier})
      }
    },

    go (payload) {
      this.$store.dispatch('nav/navigate', payload)
      this.close()
    }
  }
}
</script>
