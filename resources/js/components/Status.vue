<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  props: {
    user: {
      required: true
    }
  },

  computed: {
    ...mapGetters({
      now: 'clock/time',
      dayOfTheWeek: 'clock/dayOfTheWeek'
    }),

    todaysTimeLog () {
      return this.user.todays_time_log
    },

    todaysTimeLogStartedAt () {
      if (this.todaysTimeLog === null) {
        return null
      }

      return formatDate(this.todaysTimeLog.started_at, 'hh:mm A')
    },

    todaysSchedule () {
      return this.user.schedules.find(schedule => schedule.details.day === this.dayOfTheWeek)
    },

    dayOn () {
      return typeof this.todaysSchedule !== 'undefined' && this.user.is_not_admin
    },

    dayOff () {
      return typeof this.todaysSchedule === 'undefined'
    },

    loginTime () {
      if (this.dayOff) {
        return null
      }

      if (this.todaysTimeLog === null) {
        return null
      }

      return (new Date(this.todaysTimeLog.started_at)).getTime()
    },

    scheduledTime () {
      return (new Date(this.todaysSchedule.start_date_at)).getTime()
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
      todaysTimeLogStartedAt: this.todaysTimeLogStartedAt,
    })
  },
}
</script>