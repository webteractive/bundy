<template>
  <span
    :title="tooltip"
    v-text="text"
  />
</template>

<script>
import formatDate from 'date-fns/format'
import distanceInWordsToNow from 'date-fns/distance_in_words_to_now'

export default {
  props: {
    date: {
      required: true
    }
  },

  data () {
    return {
      text: null,
      tooltip: null
    }
  },

  methods: {
    tick () {
      const date = new Date(this.date)
      this.tooltip = formatDate(date, 'MM/DD/YYYY hh:mm A')
      this.text = distanceInWordsToNow(date, {includeSeconds: true, addSuffix: true})
    }
  },

  created () {
    this.tick()
    this.interval = setInterval(this.tick, 1000)
  },

  beforeDestroy () {
    clearInterval(this.interval)
  }
}
</script>

