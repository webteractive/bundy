<template>
  <div class="flex items-center border-b">
    <ct class="flex-1 border-none">{{ title }}</ct>
    
    <div class="px-4 flex">
      <button
        :class="buttonClass"
        @click="back()"
        title="Back"
      >
        <fa icon="step-backward" />
      </button>
      
      <router-link
        v-if="hasFuture"
        :class="buttonClass"
        to="/"
        class="mx-2"
        title="Today"
      >
        Today
      </router-link>

      <button
        :class="buttonClass"
        class="mx-2"
        ref="datePicker"
        title="Pick a day"
      >
        <fa icon="calendar-day" />
      </button>

      <button
        v-if="hasFuture"
        :class="buttonClass"
        @click="forward()"
        title="Forward!"
      >
        <fa icon="step-forward" />
      </button>
    </div>
  </div>
</template>

<script>
import merge from 'lodash.merge'
import { mapGetters } from 'vuex'
import flatpickr from 'flatpickr'
import subDays from 'date-fns/subDays'
import isToday from 'date-fns/isToday'
import addDays from 'date-fns/addDays'
import formatDate from 'date-fns/format'

export default {

  computed: {
    ...mapGetters({
      qs: 'nav/qs',
      now: 'clock/time',
    }),

    buttonClass () {
      return 'text-base font-normal text-blue-500 hover:underline hover:text-blue-600'
    },

    current () {
      if ('year' in this.$route.params) {
        const { year, day, month } = this.$route.params
        return (new Date(year, month - 1, day, 0, 0 , 0))
      }

      return new Date()
    },

    hasFuture () {
      return this.current !== null
    },

    filterDate () {
      return this.hasFuture ? new Date(this.current) : new Date()
    },

    title () {
      if (isToday(this.current)) {
        return 'Today, ' + formatDate(this.current, 'dddd')
      }

      return formatDate(this.current, 'dddd, MMM DD, YYYY')
    }
  },

  methods: {
    back () {
      this.jump(subDays(this.filterDate, 1)) 
    },

    present () {
      this.$route.push({name: 'home'})
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

      const [year, month, day] = formatDate(date, 'YYYY-MM-DD').split('-')

      this.$router.push({
        name: 'home.filter',
        params: {year, month, day}
      })
    },

    initDatePicker () {
      if (this.datePicker !== null) {
        this.datePicker.destroy()
      }

      this.datePicker = flatpickr(this.$refs.datePicker, {
        defaultDate: this.filterDate,
        onChange:  (selectedDates, dateStr, instance) => {
          this.jump(dateStr)
        }
      });
    }
  },

  updated () {
    this.$nextTick(function () {
      this.initDatePicker();
    })
  },

  created () {
    this.datePicker = null
  },

  mounted () {
    this.initDatePicker()
  }
}
</script>

