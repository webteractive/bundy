<script>
import { mapGetters } from 'vuex'
import isAfter from 'date-fns/isAfter'
import formatDate from 'date-fns/format'
import isBefore from 'date-fns/isBefore'

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
    timeLogStartedAt () {
      if (this.log === null) {
        return null
      }

      return formatDate(this.log.started_at, 'hh:mm A')
    },

    schedules () {
      return this.log.user.schedules
    },

    schedule () {
      return this.log.user.schedules.find(schedule => schedule.details.day === this.dayOfTheWeek)
    },

    dayOn () {
      return typeof this.schedule !== 'undefined' && this.log.user.is_not_admin
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

      return (new Date(this.log.started_at))
    },

    scheduledTime () {
      return (new Date(this.schedule.created_at))
    },

    test () {
      return [
        formatDate(this.loginTime, 'hh:mm'),
        formatDate(this.scheduledTime, 'hh:mm'),
      ]
    },

    late () {
      if (this.dayOff) {
        return false
      }

      return isAfter(this.loginTime, this.scheduledTime)
    },

    onTime () {
      return this.loginTime === this.scheduledTime
    },

    earlyBird () {
      return isBefore(this.loginTime, this.scheduledTime)
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