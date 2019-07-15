<template>
  <paginator
    :payload="logs"
    v-slot="{
      items,
      pagination
    }"
  >

    <div
      v-for="log in items"
      :key="log.id"
      :class="`
        px-4
        py-3
        border-b
        min-h-32
      `"
    >
      {{ log }}
    </div>

  </paginator>
</template>

<script>
import { mapGetters } from 'vuex'
import Paginator from './Paginator'

export default {
  components: {
    Paginator
  },

  computed: {
    ...mapGetters({
      logs: 'profile/logs/pagination',
    })
  },

  methods: {
    fetch () {
      this.$http.route('profile.logs')
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
