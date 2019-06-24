<template>
  <modal
    v-if="shown"
    :enable-close-button="false"
  >
    <div
      :class="{
        'md:w-600': scheduled,
        'md:w-500': unscheduled,
      }"
      class="bg-white w-screen h-screen md:h-auto relative z-20 shadow"
    >
      <ct>{{ unscheduled ? 'Setup' : 'Change' }} Schedules</ct>

      <div class="px-4 pt-4 pb-2">
        <div class="flex flex-wrap">
          <div
            v-for="name in fields"
            :key="name"
            :class="{
              'w-1/2': scheduled,
              'w-full': unscheduled,
              'pr-2': odd(name),
              'pl-2': ! odd(name),
            }"
          >
            <field
              :select-options="schedules"
              :name="name"
              v-model="form[name]"
              type="select"
              class="mb-4"
            >
              <label
                :for="name"
                :class="{
                  'flex items-center': scheduled
                }"
                slot="label" 
                class="block mb-1 text-base"
              >
                <span v-text="name.capitalize()" />
                <span
                  v-if="getCurrentScheduleByDay(name)"
                  v-text="`(${getCurrentScheduleByDay(name)})`"
                  :title="`You current schedule for this day is ${getCurrentScheduleByDay(name)}`"
                  class="font-bold text-sm ml-2 hover:underline"
                />
              </label>
            </field>
          </div>
        </div>

        <field
          label="Reason"
          v-model="form.reason"
          type="textarea"
          class="mb-4"
        />
      </div>

      <div class="px-4 py-3 border-t">
        <the-button
          v-if="unscheduled"
          @click="save()"
          type="info"
          label="Save Schedules"
        />

        <the-button
          v-if="scheduled"
          @click="update()"
          type="info"
          label="Send Request"
        />

        <the-button
          v-if="scheduled"
          @click="close()"
          label="Cancel"
        />
      </div>
    </div>
  </modal>
</template>

<script>
import merge from 'lodash.merge'
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  data () {
    return {
      error: null,
      shown: false,
      form: {
        monday: 5,
        tuesday: 5,
        wednesday: 5,
        thursday: 5,
        friday: 5,
        saturday: 6,
        reason: ''
      }
    }
  },

  computed: {
    ...mapGetters({
      scheduled: 'user/scheduled',
      unscheduled: 'user/unscheduled'
    }),

    fields () {
      return Object.keys(this.form).filter(field => field !== 'reason')
    },

    schedules () {
      const schedules = this.$store.getters.schedules
      return schedules.map(schedule => {
        const text = [
          formatDate(schedule.start_date_at, 'h:mm A'),
          formatDate(schedule.end_date_at, 'h:mm A')
        ].join(' - ')

        return {
          text,
          value: schedule.id
        }
      })
    },

    daysOfTheWeek () {
      return {sunday: 0, monday: 1, tuesday: 2, wednesday: 3, thursday: 4, friday: 5, saturday: 6}
    }
  },

  methods: {
    save () {
      this.$http.post(BUNDY.apis.schedules.store, this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
        })
        .catch(error => {
          this.error = error.response.data
        })
    },

    update () {
      this.$http.post(BUNDY.apis.schedules.update, this.form)
        .then(({ data }) => {
          console.log(data)
        })
        .catch(error => {
          this.error = error.response.data
        })
    },

    toggle (shown) {
      this.shown = shown
    },

    open () {
      const { schedules } = this.$store.getters['user/details']

      for (const field in this.form) {
        const dayAsNumber = this.daysOfTheWeek[field]

        if (typeof dayAsNumber !== 'undefined') {
          const schedule = schedules.find(item => item.details.day === dayAsNumber)
          if (typeof schedule !== 'undefined') {
            this.form[field] = schedule.id
          }
        }
      }

      this.toggle(true)
    },

    close () {
      this.toggle(false)
    },

    odd (day) {
      return ['monday', 'wednesday', 'friday'].includes(day)
    },

    getCurrentScheduleByDay (day) {
      if (this.unscheduled) {
        return null
      }

      const dayAsNumber = this.daysOfTheWeek[day]
      const { schedules } = this.$store.getters['user/details']
      const schedule = schedules.find(schedule => schedule.details.day === dayAsNumber)
      
      if (typeof schedule === 'undefined') {
        return null
      }

      return [
          formatDate(schedule.start_date_at, 'h:mm A'),
          formatDate(schedule.end_date_at, 'h:mm A')
        ].join(' - ')
    }
  },

  mounted () {
    this.toggle(this.unscheduled)
    this.$bus.on('schedule.change', () => this.open())
  }
}
</script>

