<template>
  <div 
    v-if="dayOn"
    class="min-h-32 bg-white mb-3"
  >
    <ct
      :class="{
        'text-red-700': late
      }"
    >
      {{ title }}
    </ct>
    <div class="p-4">
      <div class="mb-4">
        <div class="text-gray-700">Today is:</div>
        <div class="text-xl" v-text="formatDate(now, 'dddd, MMM DD, YYYY')" />
      </div>

      <div class="mb-4">
        <div class="text-gray-700">Your schedule today is:</div>
        <div class="text-xl font-bold">{{ todaysSchedule.starts_at }} AM to {{ todaysSchedule.ends_at }} PM</div>
      </div>

      <div>
        <div class="text-gray-700">You clocked in at:</div>
        <div 
          v-text="todaysTimeLogStartedAt"
          :class="{
            'text-red-700': late,
            'text-green-500': onTime,
            'text-green-700': earlyBird
          }"
          class="text-xl font-bold"
        />
      </div>
    </div>

    <div class="border-t px-4 py-3">
      <warp
        :to="['schedules']"
        label="Show my schedules"
        class="text-blue-500 hover:text-blue-600 hover:underline"
      />
    </div>
  </div>
</template>

<script>
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

      if (this.onTime) {
        if (this.earlyBird) {
          return 'We have an early bird right here!'
        }

        return 'You are on-time, good job!'
      }
    }
  },

  methods: {
    formatDate
  }
}
</script>
