<template>
  <status
    :log="log"
    :user="profile"
    v-slot="{
      late,
      onTime,
      earlyBird,
      timeLogStartedAt
    }"
  >
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
          'bg-blue-500 text-white': onTime,
          'bg-green-500 text-white': earlyBird,
          'bg-red-500 text-white': late,
        }]"
      >
        <fa icon="clock" />
      </div>

      <h3 class="mb-1">
        <span
          v-text="`${dayOfTheWeek} · ${date}`"
          class="font-bold"
        />
      </h3>
      <p class="mb-1" v-text="statusText(late, onTime, earlyBird)" />
      <div>
        <div>Logged-in at: {{ timeLogStartedAt }}</div>
        <div>Time rendered: N hours</div>
        <div>Disputed: Yep, Lorem ipsum sit dolor amit</div>
      </div>

      <drop-down
        :menu="menu"
        class="absolute right-4 top-4 z-20"
      />
    </div>
  </status>
</template>

<script>
import Status from './Status'
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
    Status,
    DropDown
  },

  computed: {
    ...mapGetters({
      user: 'user/details',
      profile: 'profile/details'
    }),

    isTheUser () {
      return this.user.id === this.profile.id
    },

    date () {
      return formatDate(this.log.started_at, 'MMMM DD, YYYY')
    },

    dayOfTheWeek () {
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
      return this.isTheUser ? 'You' : this.profile.first_name
    },

    theDay () {
      return isToday(this.log.started_at) ? 'today' : 'on this day'
    }
  },

  methods: {
    statusText (late, onTime, earlyBird) {
      const isOrAre = this.isTheUser ? 'are' : 'is'

      if (late) {
        return [this.name, isOrAre, 'late', this.theDay].join(' ') + '.'
      }

      if (earlyBird) {
        return [this.name, isOrAre, 'an early bird', this.theDay].join(' ') + '.'
      }

      return  [this.name, isOrAre, 'on time', this.theDay].join(' ') + '.'
    }
  }
}
</script>
