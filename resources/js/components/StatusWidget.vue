<template>
  <div 
    v-if="dayOn"
    class="min-h-32 bg-white mb-3"
  >
    <ct
      :class="{
        'text-red-700': late,
        'text-green-700': earlyBird || onTime,
      }"
    >
      {{ title }}
    </ct>
    <div class="p-4">
      <div class="mb-4">
        <div class="text-gray-700">Today is:</div>
        <div class="font-bold" v-text="formatDate(now, 'dddd, MMMM DD, YYYY')" />
      </div>

      <div class="mb-4">
        <div class="text-gray-700">Your schedule today is:</div>
        <div class="font-bold">{{ todaysSchedule.starts_at_display }} to {{ todaysSchedule.ends_at_display }}</div>
      </div>

      <div>
        <div class="text-gray-700">You clocked in at:</div>
        <div
          :class="{
            'text-red-700': late,
            'text-green-500': onTime,
            'text-green-700': earlyBird
          }"
          class="font-bold"
        >
          <span v-text="todaysTimeLogStartedAt" />
        </div>
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
import status from '../mixin/status'

export default {
  mixins: [
    status
  ]
}
</script>
