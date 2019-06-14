<template>
  <span
    :title="tooltip"
    v-text="text"
  />
</template>

<script>
import moment from 'moment'

export default {
  props: {
    date: {
      required: true
    }
  },

  computed: {
    momentDate () {
      return moment(this.date)
    },

    text () {
      return this.momentDate.fromNow(true)
    },

    tooltip () {
      return this.momentDate.format('MM/DD/YYYY hh:mm A')
    }
  }
}
</script>

