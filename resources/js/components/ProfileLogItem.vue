<template>
  <time-log-status
    :log="log"
    v-slot="{
      date,
      isLate,
      isOnTime,
      formatDate,
      statusText,
      isAnEarlyBird,
      dayOfTheWeekText,
      scheduleStartsAtDate,
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
          'bg-red-500 text-white': isLate,
          'bg-blue-500 text-white': isOnTime,
          'bg-green-500 text-white': isAnEarlyBird,
        }]"
      >
        <fa icon="clock" />
      </div>

      <h3 class="mb-1">
        <span
          v-text="`${date} · ${dayOfTheWeekText}`"
          class="font-bold"
        />
      </h3>
      <p v-html="statusText" class="mb-1" />
      <div class="text-gray-700 text-sm">
        <div>Expected at: <span class="text-black" v-text="formatDate(scheduleStartsAtDate, 'h:mm A')" /></div>
        <div>Logged-in at: <span class="text-black" v-text="formatDate(log.started_at, 'h:mm A')" /></div>
        <div>Last logged-out at: <span class="text-black" v-text="lastLoggedOut" /></div>
        <div v-if="log.disputed">Disputed: {{ log.dispute_reason }}</div>
      </div>

      <drop-down
        :menu="menu"
        class="absolute right-4 top-4 z-20"
      />
    </div>
  </time-log-status>
</template>

<script>
import { mapGetters } from 'vuex'
import DropDown from './DropDown'
import formatDate from 'date-fns/format'
import TimeLogStatus from './TimeLogStatus'

export default {
  props: {
    log: {
      required: true,
      type: Object
    }
  },

  components: {
    DropDown,
    TimeLogStatus
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
    }
  }
}
</script>