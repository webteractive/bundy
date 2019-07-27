<template>
  <div
    :class="`
      p-4
      pl-24
      border-b
      min-h-24
      relative
    `"
  >
    <div
      :class="[`
        h-16
        w-16
        flex
        top-4
        left-4
        text-4xl
        absolute
        items-center
        justify-center
      `, {
        'bg-blue-500 text-white': isOnTime,
        'bg-green-500 text-white': isEarlyBird,
        'bg-red-500 text-white': isLate,
      }]"
    >
      <fa icon="clock" />
    </div>

    <h3 class="mb-1">
      <span
        v-text="`${dayOfTheWeekText} · ${date}`"
        class="font-bold"
      />
    </h3>
    <p class="mb-1" v-text="statusText" />
    <div class="text-gray-700">
      <div>Logged-in at: <span class="text-black" v-text="formatDate(log.started_at, 'h:mm A')" /></div>
      <div>Expected at: <span class="text-black" v-text="formatDate(schedule, 'h:mm A')" /></div>
      <div>Time rendered: N hours</div>
      <div>Disputed: Yep, Lorem ipsum sit dolor amit</div>
    </div>

    <drop-down
      :menu="menu"
      class="absolute right-4 top-4 z-20"
    />
  </div>
</template>

<script>
import Status from './Status'
import { mapGetters } from 'vuex'
import DropDown from './DropDown'
import isToday from 'date-fns/is_today'
import formatDate from 'date-fns/format'
import { isAfter, isBefore, distanceInWordsStrict } from 'date-fns';

export default {
  props: {
    log: {
      required: true,
      type: Object
    }
  },

  components: {
    Status,
    DropDown
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    }),

    isTheUser () {
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

    menu () {
      return [
        ['dispute', 'Dispute'],
        ['view', 'View Logs'],
      ]
    },

    name () {
      return this.isTheUser ? 'You' : this.log.user.first_name
    },

    theDay () {
      return isToday(this.log.started_at) ? 'today' : 'on this day'
    },

    schedule () {
      const [ date ] = this.log.started_at.split(' ')
      const schedule = this.log.user.schedules.find(schedule => schedule.details.day === this.dayOfTheWeek)

      if (typeof schedule === 'undefined') {
        return null
      }

      const [ , time ] = schedule.start_date_at.split(' ')
      return `${date} ${time}`
    },

    isLate () {
      return isAfter(this.log.started_at, this.schedule)
    },

    durationOfLate () {
      if (this.isLate) {
        return distanceInWordsStrict(this.schedule, this.log.started_at, {includeSeconds: true})
      }

      return null
    },

    isEarlyBird () {
      return isBefore(this.log.started_at, this.schedule)
    },

    isOnTime () {
      return isBefore(this.log.started_at, this.schedule)
    },

    statusText () {
      const isOrAre = this.isTheUser ? 'are' : 'is'

      if (this.isLate) {
        return [this.name, isOrAre, this.durationOfLate, 'late', this.theDay].join(' ') + '.'
      }

      if (this.isEarlyBird) {
        return [this.name, isOrAre, 'an early bird', this.theDay].join(' ') + '.'
      }

      return  [this.name, isOrAre, 'on time', this.theDay].join(' ') + '.'
    }
  },

  methods: {
    formatDate
  }
}
</script>
