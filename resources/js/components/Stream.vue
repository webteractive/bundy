<template>
  <div class="relative">
    <component
      v-for="item in items"
      :key="`${item.stream_type}-${item.id}`"
      :is="resolve(item)"
      :content="item"
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ScrumMessage from './ScrumMessage'

import StreamItem from './StreamItem'
import ScrumStream from './ScrumStream'
import QuoteStream from './QuoteStream'
import TimeLogStream from './TimeLogStream'

export default {
  components: {
    ScrumMessage,

    StreamItem,
    ScrumStream,
    QuoteStream,
    TimeLogStream
  },

  computed: {
    ...mapGetters({
      items: 'stream/items',
      user: 'user/details',
      dayOfTheWeek: 'clock/dayOfTheWeek'
    }),
  },

  watch: {
    dayOfTheWeek () {
      this.$nextTick(function() {
        this.fetch()
      })
    }
  },

  methods: {
    resolve ({ stream_type: type }) {
      if (type === 'time_log') {
        return 'time-log-stream'
      }

      return `${type}-stream`
    },

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
    this.$bus.on('stream.refresh', () => this.fetch())
  }
}
</script>
