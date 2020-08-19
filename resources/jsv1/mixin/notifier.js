import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      notifications: 'notification/all',
      unreadNotifications: 'notification/unread'
    }),

    unreadNotificationsCount () {
      return this.unreadNotifications.length
    }
  },

  methods: {
    fetchNotifications () {
      this.$http.route('notifications').get()
        .then(({ data: notifications }) => {
          this.$store.dispatch('notification/hydrate', notifications)
        })
    }
  }
}