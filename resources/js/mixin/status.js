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
      return typeof this.todaysSchedule !== 'undefined'
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
        return 'You are late today, boo!'
      }

      if (this.earlyBird) {
        return 'We have an early bird right here!'
      }

      return 'You are on-time, good job!'
    }
  },

  methods: {
    formatDate
  }
}