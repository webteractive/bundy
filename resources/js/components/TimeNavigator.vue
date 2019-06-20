<template>
  <div class="flex items-center border-b">
    <ct class="flex-1 border-none">Home</ct>
    
    <div class="px-4 flex">
      <button
        :class="buttonClass"
        @click="back()"
      >
        <fa icon="angle-left" />
      </button>
      <button
        v-if="hasFuture"
        :class="buttonClass"
        @click="present()"
        class="mx-2"
      >
        <fa icon="stop" />
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
        <fa icon="angle-right" />
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
      return `
        flex items-center justify-center text-2xl text-gray-400 hover:text-blue-500
      `
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

