import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  computed: {
    ...mapGetters({
      now: 'clock/time',
      user: 'user/details',
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
    },

    title () {
      if (this.late) {
        return 'The Later'
      }

      if (this.earlyBird) {
        return 'The Early Bird'
      }

      return 'The On-Timer'
    }
  },

  methods: {
    formatDate
  }
}