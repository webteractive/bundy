<template>
  <master-layout>
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
        <div class="border-b flex justify-between py-1">
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

          <div class="pr-4">
            <label>
              <input type="checkbox" v-model="excludeWeekends">
              <span>Exclude weekends</span>
            </label>
          </div>
        </div>
        <div class="flex">
          <div class="w-64 border-r">
            <div class="px-4 py-2 font-bold border-b">&nbsp;</div>
            <div
              v-for="user in users"
              :key="user.id"
              class="relative h-24 px-4 py-2 pl-20 border-b"
            >
              <user-photo
                :user="user"
                size="smaller"
                class="absolute left-4 top-3"
              />
              <div class="pl-4">
                <h2 class="mb-1">
                  <router-link
                    v-text="user.first_name"
                    :title="user.name"
                    :to="`/profile/${user.username}`"
                    class="cursor-pointer hover:text-blue-500 hover:underline"
                  />
                </h2>
                <div class="text-gray-700 text-sm">
                  <div>Lates: <span v-text="countLates(user)" class="text-black  font-bold" /></div>
                </div>
                <div class="text-gray-700 text-sm">
                  <div>Absences: <span v-text="countAbsences(user)" class="text-black font-bold" /></div>
                </div>
              </div>
            </div>
          </div>
          <div class="flex-1 overflow-y-auto max-w-full">
            <div class="flex flex-no-wrap">
              <div
                v-for="(date, day) in datesInMonth"
                :key="`heading-day-${day}`"
                :class="{
                  'border-r': (day + 1) !== datesInMonth.length,
                  'border-r-0': (day + 1) === datesInMonth.length,
                }"
                class="w-48 px-0 py-2 flex-none border-b text-center"
              >
                <router-link
                  :to="`/${formatDate(date, 'YYYY/MM/DD')}`"
                  v-text="formatDate(date, 'ddd · MMM DD, YYYY')"
                  class="cursor-pointer hover:text-blue-500 hover:underline"
                />
              </div>
            </div>
            <div
              v-for="user in users"
              :key="`user-${user.id}`"
              class="flex flex-no-wrap"
            >
              <div
                v-for="(date, day) in datesInMonth"
                :key="`user-${user.id}-day-${day}`"
                :class="{
                  'border-r': (day + 1) !== datesInMonth.length,
                  'border-r-0': (day + 1) === datesInMonth.length,
                  [labels.late]: status(user, date).late(),
                  [labels.onTime]: status(user, date).onTime(),
                  [labels.future]: status(user, date).future(),
                  [labels.weekend]: status(user, date).weekend(),
                  [labels.earlyBird]: status(user, date).earlyBird(),
                  [labels.undertime]: status(user, date).undertime(),
                  [labels.absent]: (!status(user, date).future() && !status(user, date).weekend()) && status(user, date).absent(),
                }"
                class="h-24 w-48 flex-none border-b transition-bg-color flex items-center justify-center text-sm"
              >
                <span v-if="status(user, date).late()" v-text="`${status(user, date).timeLog.tardiness} late`" />
                <span v-if="status(user, date).earlyBird()" v-text="`${status(user, date).timeLog.punctuality} early`" />
                <span v-if="status(user, date).onTime()" v-text="`${status(user, date).timeLog.punctuality} early`" />
                <span v-if="status(user, date).undertime()" v-text="`${status(user, date).timeLog.punctuality} early`" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </master-layout>
</template>

<script>
import { mapGetters } from 'vuex'
import profile from '../mixin/profile'
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
import { isSunday, isSaturday } from 'date-fns';

export default {
  mixins: [
    profile
  ],

  components: {
    PerformanceBar
  },

  data () {
    return {
      date: new Date(),
      excludeWeekends: false
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

    datesInMonth () {
      let dates = []
      const daysInMonth = getDaysInMonth(this.date)
      for (let day = 1; day <= daysInMonth; day++) {
        dates.push(setDate(this.date, day))
      }

      if (this.excludeWeekends) {
        return dates.filter(date => {
          return this.isWeekday(date)
        })
      }

      return dates
    },

    labels () {
      return {
        weekend: 'bg-gray-200',
        future: 'bg-gray-200',
        onTime: 'bg-blue-500 text-white',
        earlyBird: 'bg-green-500 text-white',
        late: 'bg-red-600 text-white',
        absent: 'bg-red-800 text-white',
        undertime: 'bg-yellow-500 text-black',
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

    isWeekend (date) {
      return isSunday(date) || isSaturday(date)
    },

    isWeekday (date) {
      return ! this.isWeekend(date)
    },

    inFuture (date) {
      return date.setHours(0,0,0,0) > new Date().setHours(0,0,0,0)
    },

    status ({ id }, date) {
      const now = new Date()
      const timeLog = this.timeLogs.find(timeLog => timeLog.user_id === id && isSameDay(timeLog.started_at, date))
      const future = this.inFuture(date)
      const absent = typeof timeLog === 'undefined'
      const late = ! absent && timeLog.late
      const onTime = ! absent && ! timeLog.undertime && timeLog.on_time
      const earlyBird = ! absent && ! timeLog.undertime && timeLog.early_bird 
      const undertime = ! absent && ! late && timeLog.undertime 

      return {
        timeLog,
        late: () => late,
        absent: () => absent,
        future: () => future,
        onTime: () => onTime,
        earlyBird: () => earlyBird,
        undertime: () => undertime,
        weekend: () => this.isWeekend(date)
      }
    },

    countLates ({ id }) {
      return this.timeLogs.filter(timeLog => timeLog.user_id === id && timeLog.late).length
    },

    countAbsences ({ id }) {
      let absences = 0
      this.datesInMonth.forEach(date => {
        const datesUserLogs = this.timeLogs.filter(timeLog => {
          const formatStr = 'MMMM DD, YYYY'
          const isUsersLogs = timeLog.user_id === id
          const queryDate = formatDate(date, formatStr)
          const startedAt = formatDate(timeLog.started_at, formatStr)
          return isUsersLogs && queryDate === startedAt
        })

        if (this.isWeekday(date) && (this.inFuture(date) === false) && datesUserLogs.length === 0) {
          absences++
        }
      });

      return absences
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

