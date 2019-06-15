<template>
  <div class="relative min-h-256">
    <card
      v-for="item in items"
      :key="`${item.stream_type}-${item.id}`"
      :content="item"
    >

      <scrum-message
        v-if="item.stream_type === 'scrum'"
        :scrum="item"
        slot="message"
      />

      <span
        v-if="item.stream_type === 'scrum' && canEdit(item.user)"
        v-text="`Edit`"
        @click="editScrum(item)"
        slot="extra"
        title="Edit Scrum"
        class="absolute top-4 right-4 text-blue-500 cursor-pointer hover:underline"
      />

      <time-log-card-content
        v-if="item.stream_type === 'time_log'"
        :content="item"
        slot="card"
      />

      <span
        v-if="item.stream_type === 'quote'"
        v-text="`Quote`"
        slot="extra"
        class="absolute top-0 right-4 text-xs italic bg-gray-300 text-gray-600 rounded-b px-2"
      />
    </card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ScrumMessage from './ScrumMessage'
import TimeLogCardContent from './TimeLogCardContent'

export default {
  components: {
    ScrumMessage,
    TimeLogCardContent
  },

  computed: {
    ...mapGetters({
      items: 'stream/items',
      user: 'user/details',
    }),
  },

  methods: {
    fetch () {
      this.$progress.start()

      this.$http.get(BUNDY.apis.stream)
        .then(({ data }) => {
          this.$store.dispatch('stream/hydrate', data)
          this.$progress.done()
        })
        .catch(error => {
          this.$progress.done()
        })
    },

    canEdit (user) {
      return this.user.id === user.id
    },

    editScrum (scrum) {
      this.$store.dispatch('scrum/edit', scrum)
    }
  },

  created () {
    this.fetch()
  }
}
</script>
