<template>
  <div class="flex items-center border-b">
    <ct class="flex-1 border-none">{{ title }}</ct>
    
    <div class="px-4 flex">
      <button
        :class="buttonClass"
        @click="back()"
      >
        Previous
      </button>
      <button
        v-if="hasFuture"
        :class="buttonClass"
        @click="present()"
        class="mx-2"
      >
        Today
      </button>

      <!-- <button
        v-if="hasFuture"
        :class="buttonClass"
        class="mx-2"
      >
        <fa icon="calendar-day" />
      </button> -->

      <button
        v-if="hasFuture"
        :class="buttonClass"
        @click="forward()"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script>
import merge from 'lodash.merge'
import { mapGetters } from 'vuex'
import subDays from 'date-fns/sub_days'
import isToday from 'date-fns/is_today'
import addDays from 'date-fns/add_days'
import formatDate from 'date-fns/format'
import DatePicker from 'vue-flatpickr-component';

import 'flatpickr/dist/flatpickr.css';

export default {
  components: {
    DatePicker
  },

  computed: {
    ...mapGetters({
      qs: 'nav/qs',
      now: 'clock/time',
    }),

    buttonClass () {
      return 'text-base font-normal text-blue-500 hover:underline hover:text-blue-600'
    },

    current () {

      if (this.qs === null) {
        return null
      }

      const { date } = this.qs
      const [year, day, month] = date.split('-')

      return (new Date(year, month - 1, day, 0, 0 , 0)).getTime()
    },

    hasFuture () {
      return this.current !== null
    },

    filterDate () {
      return this.hasFuture ? new Date(this.current) : new Date()
    },

    title () {
      if (this.current == null) {
        return 'Today'
      }

      return formatDate(this.current, 'MMMM DD, YYYY')
    }
  },

  methods: {
    back () {
      this.jump(subDays(this.filterDate, 1))
    },

    present () {
      this.jump(null)
    },

    forward () {
      const targetDate = addDays(this.filterDate, 1)

      if (isToday(targetDate)) {
        this.present()
      } else {
        this.jump(addDays(this.filterDate, 1))
      }
    },

    jump (date) {

      let payload = {page: 'home'}

      if (date !== null) {
        payload = merge(payload, {
          qs: {
            date: formatDate(date, 'YYYY-DD-MM')
          } 
        })
      }

      this.$store.dispatch('nav/navigate', payload)
      this.$bus.emit('stream.filter')
    }
  }
}
</script>

