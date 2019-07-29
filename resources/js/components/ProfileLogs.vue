<template>
  <paginator
    :payload="logs"
    v-slot="{
      items,
      pagination
    }"
    @next="next"
  >
    <profile-log-item
      v-for="log in items"
      :key="log.id"
      :log="log"
    />
  </paginator>
</template>

<script>
import DropDown from './DropDown'
import { mapGetters } from 'vuex'
import Paginator from './Paginator'
import ProfileLogItem from './ProfileLogItem'

export default {
  components: {
    DropDown,
    Paginator,
    ProfileLogItem
  },

  computed: {
    ...mapGetters({
      profile: 'profile/details',
      logs: 'profile/logs/pagination',
    }),

    menu () {
      return [
        ['dispute', 'Dispute'],
        ['view', 'View Logs'],
      ]
    }
  },

  methods: {
    fetch () {
      this.$http.route('profile.logs', {username: this.profile.username})
        .get()
          .then(({ data }) => {
            this.$store.dispatch('profile/logs/paginate', data)
          })
    },

    next (url) {
      this.$http.get(url)
          .then(({ data }) => {
            this.$store.dispatch('profile/logs/concat', data)
          })
    }
  },

  created () {
    this.fetch()
  }
}
</script>
