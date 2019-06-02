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
      time: '',
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

    today () {
      return this.schedules.find(schedule => {
        return parseInt(schedule.details.day) === parseInt(this.day)
      })
    },

    late () {
      if (typeof this.today === 'undefined') {
        return false
      }

      const { starts_at } = this.today
      const timeAsNumber = this.parseToNumber([this.h, this.m].join(':'))
      const { started_at: startedAt } = this.user.timelogs_today[0]

      return false
    },

    off () {
      return this.day === 0
    }
  },

  methods: {
    tick () {
      const date = new Date()
      this.h = format(date, 'H')
      this.m = format(date, 'm')
      this.s = format(date, 's')
      this.time = format(date, 'hh:mm:ss A')
      this.day = format(date, 'd')
    },

    parseToNumber (time) {
      const [h, m] = time.split(':')
      return parseFloat(this.h) + (parseFloat(this.m) / 60)
    },

    dateToLocal (dateUTCString) {
      return moment.utc(dateUTCString)
    }
  },

  render () {
    return this.$scopedSlots.default({
      late: this.late,
      off: this.off,
      time: this.time
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
