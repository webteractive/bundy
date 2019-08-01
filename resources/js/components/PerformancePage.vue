<template>
  <div class="bg-white mx-3 shadow">
    <ct class="flex items-center">
      <span class="flex-1" v-text="title" />
      <div class="ml-4 font-normal">
        <button
        :class="navButtonClass"
        @click="back()"
        title="Back"
      >
        <fa icon="step-backward" />
      </button>

      <button
        :class="navButtonClass"
        @click="present()"
        class="mx-2"
        title="Today"
      >
        Today
      </button>

      <button
        :class="navButtonClass"
        @click="forward()"
        title="Forward!"
      >
        <fa icon="step-forward" />
      </button>
      </div>
    </ct>
    <div class="relative">
      <div class="border-b flex justify-center py-1">
        <ul class="text-sm font-normal">
          <li
            v-for="(className, label) in labels"
            :key="label"
            class="inline-flex items-center ml-4"
          >
            <span :class="[className]" class="h-4 w-4" />
            <span v-text="label" class="capitalize ml-1" />
          </li>
        </ul>
      </div>
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
            <div class="pl-2">
              <h2 class="mb-1">{{ user.name }}</h2>
              <div class="text-gray-700 text-sm">
                <div>Lates: <span v-text="countLates(user)" class="text-black" /></div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex-1 overflow-y-auto max-w-full">
          <div class="flex flex-no-wrap">
            <div
              v-for="day in daysInMonth"
              :key="`heading-day-${day}`"
              :class="{
                'border-r': day !== daysInMonth,
                'border-r-0': day === daysInMonth
              }"
              v-text="formatDate(dayToDate(day), 'MMMM DD, YYYY')"
              class="w-48 px-0 py-2 flex-none border-b text-center"
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
              :class="{
                'border-r': day !== daysInMonth,
                'border-r-0': day === daysInMonth,
                [labels.late]: status(user, day).late(),
                [labels.onTime]: status(user, day).onTime(),
                [labels.future]: status(user, day).future(),
                [labels.earlyBird]: status(user, day).earlyBird(),
                [labels.absent]: !status(user, day).future() && status(user, day).absent(),
              }"
              v-html="`&nbsp;`"
              class="h-20 w-48 flex-none border-b transition-bg-color"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import getYear from 'date-fns/get_year'
import setDate from 'date-fns/set_date'
import formatDate from 'date-fns/format'
import getMonth from 'date-fns/get_month'
import isFuture from 'date-fns/is_future'
import addMonths from 'date-fns/add_months'
import subMonths from 'date-fns/sub_months'
import isSameDay from 'date-fns/is_same_day'
import PerformanceBar from './PerformanceBar'
import getDaysInMonth from 'date-fns/get_days_in_month'

export default {
  components: {
    PerformanceBar
  },

  data () {
    return {
      date: new Date()
    }
  },

  computed: {
    ...mapGetters({
      users: 'performance/users',
      timeLogs: 'performance/timeLogs',
    }),

    daysInMonth () {
      return getDaysInMonth(this.date)
    },

    labels () {
      return {
        future: 'bg-gray-200',
        onTime: 'bg-blue-500',
        earlyBird: 'bg-green-500',
        late: 'bg-red-600',
        absent: 'bg-red-800',
      }
    },

    navButtonClass () {
      return 'text-base font-normal text-blue-500 hover:underline hover:text-blue-600'
    },

    title () {
      return [
        formatDate(this.date, 'MMMM YYYY'),
        'Performance'
      ].join(' ')
    }
  },

  methods: {
    formatDate,

    fetch (payload = {}) {
      this.$http.route('performance', payload)
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

    status ({ id }, day) {
      const now = new Date()
      const date = this.dayToDate(day)
      const inFuture = date => date.setHours(0,0,0,0) > new Date().setHours(0,0,0,0);
      const timeLog = this.timeLogs.find(timeLog => timeLog.user_id === id && isSameDay(timeLog.started_at, date))
      const future = inFuture(date)
      const absent = typeof timeLog === 'undefined'
      const late = ! absent && timeLog.late
      const onTime = ! absent && timeLog.on_time
      const earlyBird = ! absent && timeLog.early_bird      

      return {
        late: () => late,
        absent: () => absent,
        future: () => future,
        onTime: () => onTime,
        earlyBird: () => earlyBird
      }
    },

    countLates ({ id }) {
     return this.timeLogs.filter(timeLog => timeLog.user_id === id && timeLog.late).length
    },

    back () {
      this.jump(subMonths(this.date, 1))
    },

    present () {
      this.jump(new Date())
    },

    forward () {
      this.jump(addMonths(this.date, 1))
    },

    jump (date) {
      this.date = date
      this.fetch({
        year: getYear(date),
        month: getMonth(date) + 1,
      })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

