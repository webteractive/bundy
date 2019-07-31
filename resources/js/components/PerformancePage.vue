<template>
  <div class="bg-white mx-3 shadow">
    <ct>Performance</ct>
    <div class="relative">
      <div class="flex">
        <div class="w-64 border-r">
          <div class="px-4 py-2 font-bold border-b">&nbsp;</div>
          <div
            v-for="user in users"
            :key="user.id"
            class="relative h-20 px-4 py-2 pl-16 border-b"
          >
            <user-photo
              :user="user"
              size="10"
              class="absolute left-4 top-3"
            />
            <h2 class="mb-1">{{ user.name }}</h2>
            <div class="text-sm">
              <div>Lates: 2</div>
            </div>
          </div>
        </div>
        <div class="flex-1 overflow-y-auto max-w-full">
          <div class="flex flex-no-wrap">
            <div
              v-for="day in daysInMonth"
              :key="`heading-day-${day}`"
              v-text="formatDate(dayToDate(day), 'MMMM DD, YYYY')"
              class="w-48 px-0 py-2 flex-none font-bold text-center"
            />
          </div>
          <div
            v-for="user in users"
            :key="`user-${user.id}`"
            class="flex flex-no-wrap"
          >
            <div
              v-for="day in daysInMonth"
              :key="`user-${user.id}-day-${day}`"
              v-html="`&nbsp;`"
              class="h-20 w-48 flex-none bg-red-200"
            />
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

