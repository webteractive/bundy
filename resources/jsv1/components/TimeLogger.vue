<template>
  <modal
    v-if="scheduled && dayOn && hasNotClockedIn"
    disable-close-button
  >
    <div class="bg-white border-b-2 border-gray-200 w-380 z-30">
      <ct>Time In</ct>
      
      <div class="px-4 py-6">
        <p class="text-xl leading-snug italic">You haven't clocked in your time yet, click the button below to do so.</p>
      </div>

      <div class="px-4 py-3 border-t">
        <button
          type="button"
          @click="save()"
          :class="`
            bg-blue-500 w-full border-blue-600 text-white py-3 px-4
            hover:bg-blue-600 hover:border-blue-700
          `"
        >
          Clock my time now (<span class="font-bold" v-text="formatDate(now, 'hh:MM:ss A')" />)
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  data () {
    return {
      error: null
    }
  },

  computed: {
    ...mapGetters({
      now: 'clock/time',
      user: 'user/details',
      scheduled: 'user/scheduled',
      dayOfTheWeek: 'clock/dayOfTheWeek',
      hasNotClockedIn: 'user/hasNotClockedIn',
    }),

    dayOn () {
      return this.dayOfTheWeek !== 0 && this.user.is_not_admin
    }
  },

  methods: {
    formatDate,

    save () {
      this.$http.route('logs.store').post()
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
          this.$bus.emit('stream.refresh')
        })
        .catch(error => {
          this.error = error.response.data
        })
    }
  }
}
</script>
