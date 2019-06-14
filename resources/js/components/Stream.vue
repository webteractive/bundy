<template>
  <div class="relative min-h-256">
    <card
      v-for="(item, index) in items"
      :key="index"
      :content="item"
    >
      <span
        v-if="item.type === 'quote'"
        v-text="`Quote of the Day`"
        slot="extra"
        class="absolute top-0 right-4 text-xs italic bg-gray-300 text-gray-600 rounded-b px-2"
      />
    </card>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import QuoteOfTheDay from './QuoteOfTheDay'

export default {
  components: {
    QuoteOfTheDay
  },

  computed: {
    ...mapGetters({
      items: 'stream/items'
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
    }
  },

  created () {
    this.fetch()
  }
}
</script>
