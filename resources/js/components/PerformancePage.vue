<template>
  <div class="bg-white mx-3 shadow">
    <ct>Performance</ct>
    <div class="relative">
      <div
        v-for="user in users"
        :key="user.id"
        class="bg-blue-200 flex"
      >
        <div class="flex">
          <div class="bg-blue-300 w-320 font-bold">{{ user.name }}</div>
          <div class="overflow-y-auto">
            <div class="flex">
              <div
                v-for="day in daysInMonth"
                :key="`user-${user.id}-${day}`"
                v-text="formatDate(dayToDate(day), 'MMMM DD, YYYY')"
                class="w-240"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import PerformanceBar from './PerformanceBar'
import setDate from 'date-fns/set_date'
import formatDate from 'date-fns/format'
import getDaysInMonth from 'date-fns/get_days_in_month'

export default {
  components: {
    PerformanceBar
  },

  data () {
    return {
      date: new Date().getTime()
    }
  },

  computed: {
    ...mapGetters({
      users: 'performance/users',
      timeLogs: 'performance/timeLogs',
    }),

    daysInMonth () {
      return getDaysInMonth(this.date)
    }
  },

  methods: {
    formatDate,

    fetch () {
      this.$http.route('performance')
        .get()
          .then(({ data }) => {
            this.$store.dispatch('performance/hydrate', data)
          })
    },

    userTimeLogs ({ id }) {
      return this.timeLogs.filter(timeLog => timeLog.user_id === id)
    },

    dayToDate (day) {
      return setDate(this.date, day)
    },
  },

  mounted () {
    this.fetch()
  }
}
</script>

