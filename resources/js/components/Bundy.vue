<script>
import moment from 'moment'
import format from 'date-fns/format'

export default {
  data () {
    return {
      h: 0,
      m: 0,
      s: 0,
      day: 0,
      time: 0,
      date: new Date()
    }
  },

  computed: {
    user () {
      return this.$store.getters['user/details']
    },

    schedules () {
      if (this.user === null) {
        return []
      }

      return this.user.schedules
    },

    logs () {
      if (this.user === null) {
        return []
      }

      return this.user.timelogs_today
    },

    timeIn () {
      if (this.logs.length === 0) {
        return null
      }

      return new Date(this.logs[0].started_at)
    },

    loggedInToday () {
      return this.logs.length > 0
    },

    needsToLoggedInToday () {
      return this.logs.length === 0
    },

    today () {
      return this.schedules.find(schedule => {
        return parseInt(schedule.details.day) === parseInt(this.day)
      })
    },

    late () {
      if (typeof this.today === 'undefined') {
        return false
      }

      return true

      const date = new Date()
      const { starts_at } = this.today
      const [h, m] = starts_at.split(':')
      const schedule = new Date(date.getFullYear(), date.getMonth(), date.getDate(), h, m, 0)
      return this.time > schedule.getTime() && (this.loggedInToday && this.time > this.timeIn.getTime())
    },

    off () {
      return typeof this.today === 'undefined'
    },

    normal () {
      return this.late && this.off
    },

    earlyBird () {
      if (this.needsToLoggedInToday) {
        return false
      }

      return false

      return this.time > this.timeIn.getTime()
    }
  },

  methods: {
    tick () {
      const date = new Date()
      this.date = date
      this.h = format(date, 'H')
      this.m = format(date, 'm')
      this.s = format(date, 's')
      this.time = date.getTime()
      this.day = format(date, 'd')
    },

    parseToNumber (time) {
      const [h, m] = time.split(':')
      return parseFloat(this.h) + (parseFloat(this.m) / 60)
    },

    dateToLocal (dateUTCString) {
      return moment.utc(dateUTCString)
    },

    formatter (stringFormat, date = null) {
      return format(date !== null ? date : this.date, stringFormat)
    }
  },

  render () {
    return this.$scopedSlots.default({
      off: this.off,
      late: this.late,
      time: this.time,
      logs: this.logs,
      date: this.date,
      timeIn: this.timeIn,
      normal: this.normal,
      earlyBird: this.earlyBird,
      schedules: this.schedules,
      formatter: this.formatter,
      loggedInToday: this.loggedInToday,
      needsToLoggedInToday: this.needsToLoggedInToday
    })
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
