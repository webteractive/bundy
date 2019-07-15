import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      user: 'user/details',
      profile: 'profile/details',
    }),

    editable () {
      if (this.profile === null) {
        return false
      }
      
      return this.user.username === this.profile.username
    },
  },

  methods: {
    fetchProfile (username, callback = null) {
      this.$http.route('employee.show', { username }).get()
        .then(({ data }) => {
          this.$store.dispatch('profile/hydrate', data.user)
          
          if (callback !== null) {
            callback(data)
          }
        })
        .catch(error => {
          console.log(error)          
        })
    },

    showProfile ({ username }) {
      this.$progress.start()
      this.fetchProfile(username, () => {
        this.$store.dispatch('nav/navigate', {
          page: 'profile',
          identifier: username
        })
        this.$progress.done()
      })
    }
  }
}