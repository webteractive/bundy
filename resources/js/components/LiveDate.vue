<template>
  <span
    :title="formattedDate"
    v-text="duration"
  />
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'
import distanceInWords from 'date-fns/formatDistance'

export default {
  props: {
    date: {
      required: true
    }
  },

  computed: {
    ...mapGetters({
      now: 'clock/time'
    }),

    duration () {
      return distanceInWords(this.now, new Date(this.date), {includeSeconds: true, addSuffix: true});
    },

    formattedDate () {
      return formatDate(new Date(this.date), 'MM/DD/YYYY h:mm A')
    }
  },
}
</script>

