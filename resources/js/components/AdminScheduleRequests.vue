<template>
  <div class="admin">
    <ct>Schedule Requests</ct>

    <div class="px-4 py-6">
      Schedules
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      items: 'admin/schedule/items'
    })
  },

  methods: {
    fetch () {
      this.$http.get(BUNDY.apis.admin.schedule.list)
        .then(({ data }) => {
          this.$store.dispatch('admin/schedule/hydrate', data)
        })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

