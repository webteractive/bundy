<template>
  <div class="min-h-32 bg-white mb-3">
    <ct
      :class="[textColorStatus]"
      :title="title"
    />

    <p v-html="wisdom" class="p-4 border-b italic leading-tight" />

    <div class="px-4 p-3">
      <div class="mb-2">
        <div class="text-sm text-gray-700">Today is:</div>
        <div v-text="formatDate(now, 'dddd, MMMM DD, YYYY')" />
      </div>

      <div v-if="timeLog.schedule" class="mb-2">
        <div class="text-sm text-gray-700">You are expected at:</div>
        <div>
          <span v-text="timeLog.schedule.starts_at_display" />
          <span>&mdash;</span>
          <span v-text="timeLog.schedule.ends_at_display" />
        </div>
      </div>

      <div v-if="timeLog.schedule" class="mb-2">
        <div class="text-sm text-gray-700">You logged-in at:</div>
        <div :class="[textColorStatus]" class="font-bold">
          <span v-text="formatDate(timeLog.started_at, 'hh:mm A')" />
          <span v-if="timeLog.late" v-text="`(${timeLog.tardiness} late)`" />
          <span v-if="timeLog.early_bird" v-text="`(${timeLog.punctuality} early)`" />
          <span v-if="timeLog.on_grace_period" v-text="`(on gace period)`" />
        </div>
      </div>

      <div v-if="timeLog.schedule && timeLog.ended_at" class="mb-2">
        <div class="text-sm text-gray-700">You last logged-out at:</div>
        <div v-text="formatDate(timeLog.ended_at, 'hh:mm A')" />
      </div>

      <div v-if="timeLog.schedule && timeLog.rendered_time" class="mb-2">
        <div class="text-sm text-gray-700">Your rendered hours so far is:</div>
        <div v-text="`${timeLog.rendered_time} hours`" />
      </div>
    </div>

  <div class="px-4 py-3 border-t flex justify-between">
      <warp
        :to="['schedules']"
        class="text-blue-500 hover:underline hover:text-blue-600"
        label="My Schedules"
      />

      <warp
        :to="['performance']"
        class="text-blue-500 hover:underline hover:text-blue-600"
        label="Performance"
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
      user: 'user/details'
    }),

    timeLog () {
      return this.user.todays_time_log
    },

    title () {
      if (this.timeLog.late) {
        return 'Late'
      }

      if (this.timeLog.early_bird) {
        return 'Early Bird'
      }

      return 'On-time'
    },

    wisdom () {
      if (this.timeLog.late) {
        return `You are late today ${this.user.first_name} but you got this, aight? I know you got this.`
      }

      if (this.timeLog.early_bird) {
        return `You are an early bird today ${this.user.first_name}, keep up the good job!`
      }

      return `You are on-time today ${this.user.first_name}, keep this up!`
    },

    textColorStatus () {
      return {
        'text-red-600': this.timeLog.late,
        'text-blue-500': this.timeLog.on_time,
        'text-green-500': this.timeLog.early_bird,
      }
    }
  },

  methods: {
    formatDate
  }
}
</script>
