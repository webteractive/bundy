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
  }
}