<template>
  <div class="flex border-b">
    <div class="w-320 px-4 border-r">
      <h2>{{ user.name }}</h2>
      <div class="text-sm text-gray-600">
        <div>Lates: 2</div>
      </div>
    </div>
    <div class="flex">
      <div
        v-for="day in daysInMonth"
        :key="`${user.id}-${day}`"
        class="w-240 border-r text-center"
      >
        {{ day }}
      </div>
    </div>
  </div>
</template>

<script>
import setDay from 'date-fns/setDay'
import getDaysInMonth from 'date-fns/getDaysInMonth'

export default {
  props: {
    user: {
      type: Object
    },
    timeLogs: {
      type: Array
    },
    isHeading: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      date: new Date().getTime()
    }
  },

  computed: {
    daysInMonth () {
      return getDaysInMonth(this.date)
    }
  },

  methods: {
    dayToDate (day) {
      return setDay(this.date, day)
    },
  }
}
</script>
