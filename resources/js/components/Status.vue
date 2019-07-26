<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  props: {
    user: {
      required: true,
    },

    log: {
      required: true
    }
  },

  computed: {
    ...mapGetters({
      dayOfTheWeek: 'clock/dayOfTheWeek'
    }),

    timeLogStartedAt () {
      if (this.log === null) {
        return null
      }

      return formatDate(this.log.started_at, 'hh:mm A')
    },

    schedule () {
      return this.user.schedules.find(schedule => schedule.details.day === this.dayOfTheWeek)
    },

    dayOn () {
      return typeof this.schedule !== 'undefined' && this.user.is_not_admin
    },

    dayOff () {
      return typeof this.schedule === 'undefined'
    },

    loginTime () {
      if (this.dayOff) {
        return null
      }

      if (this.log === null) {
        return null
      }

      return (new Date(this.log.started_at)).getTime()
    },

    scheduledTime () {
      return (new Date(this.schedule.start_date_at)).getTime()
    },

    late () {
      if (this.dayOff) {
        return false
      }

      return this.loginTime > this.scheduledTime
    },

    onTime () {
      return this.loginTime === this.scheduledTime
    },

    earlyBird () {
      return this.loginTime < this.scheduledTime
    }
  },

  render (h) {
    return this.$scopedSlots.default({
      formatDate,
      late: this.late,
      dayOn: this.dayOn,
      dayOff: this.dayOff,
      onTime: this.onTime,
      earlyBird: this.earlyBird,
      dayOfTheWeek: this.dayOfTheWeek,
      timeLogStartedAt: this.timeLogStartedAt,
    })
  },
}
</script>