<script>
import isAfter from 'date-fns/is_after'
import formatDate from 'date-fns/format'
import isToday from 'date-fns/is_today'
import isBefore from 'date-fns/is_before'
import differenceInSeconds from 'date-fns/difference_in_seconds'
import distanceInWordsStrict from 'date-fns/distance_in_words_strict'
import differenceInMilliseconds from 'date-fns/difference_in_milliseconds'
import differenceInMinutes from 'date-fns/difference_in_minutes'


export default {
  props: {
    log: {
      required: true
    }
  },

  computed: {
    user () {
      return this.$store.getters['user/details']
    },

    fromTheCurrentUser () {
      return this.user.id === this.log.user.id
    },

    date () {
      return formatDate(this.log.started_at, 'MMMM DD, YYYY')
    },

    dayOfTheWeek () {
      return parseInt(formatDate(this.log.started_at, 'd'))
    },

    dayOfTheWeekText () {
      const dayOfTheWeek = formatDate(this.log.started_at, 'dddd')

      if (isToday(this.log.started_at)) {
        return `Today, ${dayOfTheWeek}`
      }
      return dayOfTheWeek
    },

    name () {
      return this.fromTheCurrentUser ? 'You' : this.log.user.first_name
    },

    theDay () {
      return isToday(this.log.started_at) ? 'today' : 'on this day'
    },

    schedule () {
      return this.log.user.schedules.find(schedule => schedule.details.day === this.dayOfTheWeek)
    },

    scheduleStartsAtDate () {
      const [ date ] = this.log.started_at.split(' ')

      if (typeof this.schedule === 'undefined') {
        return null
      }

      const [ , time ] = this.schedule.start_date_at.split(' ')
      return `${date} ${time}`
    },

    isLate () {
      const late = isAfter(this.log.started_at, this.scheduleStartsAtDate)
      const duration = differenceInMinutes(this.log.started_at, this.scheduleStartsAtDate)
      return duration > this.schedule.grace_period
    },

    durationOfLate () {
      if (this.isLate) {
        return distanceInWordsStrict(this.scheduleStartsAtDate, this.log.started_at, {includeSeconds: true})
      }

      return null
    },

    durationOfLateText () {
      return this.isLate ? `${this.durationOfLate} late` : ''
    },

    earliness () {
      return differenceInMinutes(this.scheduleStartsAtDate, this.log.started_at)
    },

    isAnEarlyBird () {
      const onTime = isBefore(this.log.started_at, this.scheduleStartsAtDate)
      return onTime && this.earliness >= 30
    },

    isOnTime () {
      const onTime = isBefore(this.log.started_at, this.scheduleStartsAtDate)
      const duration = differenceInMinutes(this.log.started_at, this.scheduleStartsAtDate)
      
      if (this.isAnEarlyBird) {
        return false
      }

      return onTime || duration < this.schedule.grace_period
    },

    statusText () {
      const isOrAre = this.fromTheCurrentUser ? 'are' : 'is'

      if (this.isLate) {
        return [this.name, isOrAre, `<span class="font-bold italic">${this.durationOfLate}</span>`, 'late', this.theDay].join(' ') + '.'
      }

      if (this.isAnEarlyBird) {
        return [this.name, isOrAre, 'an early bird', this.theDay].join(' ') + '.'
      }

      return  [this.name, isOrAre, 'on time', this.theDay].join(' ') + '.'
    }
  },

  render (h) {
    return this.$scopedSlots.default({
      formatDate,
      date: this.date,
      isLate: this.isLate,
      isOnTime: this.isOnTime,
      isOnTime: this.isOnTime,
      schedule: this.schedule,
      statusText: this.statusText,
      isAnEarlyBird: this.isAnEarlyBird,
      durationOfLate: this.durationOfLate,
      dayOfTheWeekText: this.dayOfTheWeekText,
      durationOfLateText: this.durationOfLateText,
      scheduleStartsAtDate: this.scheduleStartsAtDate,
    })
  },
}
</script>