<template>
  <span v-text="humanReadable" />
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
    humanReadable () {
      return moment(this.date).fromNow(true)
    }
  }
}
</script>

