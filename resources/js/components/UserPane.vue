<template>
  <on-click-outside :do="close">
    <div 
      :class="[`
        relative flex items-center text-gray-800 pr-0 cursor-pointer
        bg-gray-100 md:pr-1 hover:bg-gray-300
      `, {
        'bg-gray-300': shown
      }]"
      @click="toggle()"
    >
      <user-photo
        :user="user"
        size="smallest"
        class="bg-blue-500 text-base md:h-8 md:w-8 md:mr-2"
      />

      <span v-text="usernameOrAlias" class="hidden md:inline mr-1" />

      <div class="hidden md:inline-flex">
        <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
      </div>

      <div 
        v-if="shown"
        class="absolute w-320 bg-white shadow top-10 right-0"
      >
        <ul>
          <router-link
            v-for="[ name, icon ] in menu"
            :to="`/${name === 'profile' ? (name + '/' + user.username) : name}`"
            :key="name"
            active-class="text-blue-500"
            class="px-4 py-3 hover:text-blue-500 flex items-center"
          >
            <span class="flex w-8 text-xl">
              <fa :icon="icon" />
            </span>
            <span class="capitalize" v-text="name" />
          </router-link>
          <li class="border-b border-gray-200" />
          <logout 
            tag="li"
            class="flex items-center px-4 py-3 m-1 hover:text-red-500 capitalize"
          >
            <span class="flex w-8 text-xl">
              <fa icon="sign-out-alt" />
            </span>
            <span>Logout</span>
          </logout>
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
      active: 'nav/active',
      user: 'user/details',
      profile: 'profile/details',
    }),

    menu () {
      const menu = this.$store.getters['nav/user']

      if (this.user.role_id === 1) {
        return menu
      }

      return menu.filter(item => {
        const [ name ] = item
        return name !== 'admin'
      })
    },

    usernameOrAlias () {
      if (this.user.alias !== null) {
        return this.user.alias
      }

      return this.user.username
    }
  },

  methods: {
    toggle () {
      this.shown = ! this.shown
    },

    close () {
      this.shown = false
    },

    isActive (item) {
      if (this.profile === null) {
        return false
      }

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
