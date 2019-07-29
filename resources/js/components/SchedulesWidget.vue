<template>
  <div class="min-h-32 bg-white pb-6">
    <ct>{{ profile.first_name }}'s Schedules</ct>
    <div
      v-for="schedule in profile.schedules"
      :key="schedule.details.day"
      :class="{
        'border-gray-200': schedule.details.day !== dayOfTheWeek,
        'bg-blue-100 border-blue-200': schedule.details.day === dayOfTheWeek,
      }"
      class="px-4 py-2 border-b"
    >
      <h4
        v-text="`${schedule.details.day === dayOfTheWeek ? 'Today, ': ''}${getDayName(schedule.details.day)}`"
        :class="{
          'text-gray-800': schedule.details.day !== dayOfTheWeek,
          'text-black font-bold': schedule.details.day === dayOfTheWeek,
        }"
        class="mb-0 text-sm"
      />
      <div
        :class="{
          'text-gray-900': schedule.details.day !== dayOfTheWeek,
          'text-black font-bold': schedule.details.day === dayOfTheWeek,
        }"
        class="text-sm"
      >
        {{ schedule.starts_at_display }} to {{ schedule.ends_at_display }}
      </div>

      <div class="text-xs">
        <span class="text-gray-600">Break</span>
        <span v-text="schedule.break" class="text-gray-700 hover:underline" />
        <span>,</span>
        <span class="text-gray-600">Grace Period</span>
        <span v-text="schedule.grace_period" class="text-gray-700 hover:underline" />
      </div>

      <div class="text-xs">
        <span class="text-gray-600">Last updated</span>
        <live-date :date="schedule.updated_at" class="text-gray-700 hover:underline"/>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  computed: {
    ...mapGetters({
      profile: 'profile/details',
      dayOfTheWeek: 'clock/dayOfTheWeek'
    })
  },

  methods: {
    formatDate,

    getDayName (day) {
      return [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ][day]
    }
  }
}
</script>
