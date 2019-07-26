<template>
  <paginator
    :payload="logs"
    v-slot="{
      items,
      pagination
    }"
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
import formatDate from 'date-fns/format'
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
    formatDate,

    fetch () {
      this.$http.route('profile.logs', {user: this.profile.id})
        .get()
          .then(({ data }) => {
            this.$store.dispatch('profile/logs/paginate', data)
          })
    }
  },

  created () {
    this.fetch()
  }
}
</script>
