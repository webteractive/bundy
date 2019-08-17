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
        'bg-red-500 text-white': log.late,
        'bg-blue-500 text-white': log.on_time,
        'bg-green-500 text-white': log.early_bird,
      }]"
    >
      <fa icon="clock" />
    </div>

    <h3 v-text="title" class="font-bold mb-1" />

    <p v-html="status" class="mb-1" />
    
    <div class="text-gray-700 text-sm">
      <div>Expected at: <span class="text-black" v-text="formatDate(log.schedule_starts_at, 'h:mm A')" /></div>
      <div>Logged-in at: <span class="text-black" v-text="formatDate(log.started_at, 'h:mm A')" /></div>
      <div>Last logged-out at: <span class="text-black" v-text="lastLoggedOut" /></div>
      <div v-if="log.rendered_time">Rendered hours: <span class="text-black" v-text="`${log.rendered_time} hours`" /></div>
      <div v-if="log.disputed">Disputed: {{ log.dispute_reason }}</div>
      <div>
        <span v-if="log.late" v-text="`Late`" class="bg-red-500 text-red-100 rounded-full text-xs px-2 leading-snug" />
        <span v-if="log.on_time" v-text="`On-time`" class="bg-blue-500 text-blue-200 rounded-full text-xs px-2 leading-snug" />
        <span v-if="log.early_bird" v-text="`Early Bird`" class="bg-green-500 text-green-200 rounded-full text-xs px-2 leading-snug" />
        <span v-if="log.undertime" v-text="`Undertime`" class="bg-yellow-500 text-yellow-900 text-xs rounded-full px-2 leading-snug" />
      </div>
    </div>

    <drop-down
      :menu="menu"
      class="absolute right-4 top-4 z-20"
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DropDown from './DropDown'
import isToday from 'date-fns/is_today'
import formatDate from 'date-fns/format'

export default {
  props: {
    log: {
      required: true,
      type: Object
    }
  },

  components: {
    DropDown
  },

  computed: {
    menu () {
      return [
        ['dispute', 'Dispute']
      ]
    },

    lastLoggedOut () {
      if (this.log.ended_at === null) {
        return 'Never'
      }

      return formatDate(this.log.ended_at, 'h:mm A')
    },

    title () {
      const dayOfTheWeek = formatDate(this.log.started_at, 'dddd')
      return [
        formatDate(this.log.started_at, 'MMMM DD, YYYY'),
        isToday(this.log.started_at) ? `Today, ${dayOfTheWeek}` : dayOfTheWeek
      ].join(' · ')
    },

    user () {
      return this.$store.getters['user/details']
    },

    fromTheCurrentUser () {
      return this.user.id === this.log.user.id
    },

    theDay () {
      return isToday(this.log.started_at) ? 'today' : 'on this day'
    },

    name () {
      return this.fromTheCurrentUser ? 'You' : this.log.user.first_name
    },

    status () {
      const isOrAre = this.fromTheCurrentUser ? 'are' : 'is'
      const day = isToday(this.log.started_at) ? 'today' : 'on this day'
      const emphasize = value => `<span class="font-bold italic">${value}</span>`

      if (this.log.late) {
        return [this.name, isOrAre, emphasize(this.log.tardiness), 'late', day].join(' ') + '.'
      }

      if (this.log.early_bird) {
        return [this.name, isOrAre, 'an early bird', `(${emphasize(this.log.punctuality)} early)`, day].join(' ') + '.'
      }

      return  [this.name, isOrAre, 'on time', day].join(' ') + '.'
    }
  },

  methods: {
    formatDate
  }
}
</script>
