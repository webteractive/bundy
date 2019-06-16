<template>
  <page-layout>
    <template slot="content">
      <ct>Schedules</ct>

      <div class="schedules">
        <div
          v-for="schedule in schedules"
          :key="schedule.id"
          class="border-b px-4 py-3 flex"
        >
          <div
            :class="`
              h-24 w-24 bg-gray-500 text-white mr-4 text-3xl 
              flex items-center justify-center
            `" 
            v-text="daysOfTheWeek[schedule.details.day].substring(0, 3)"
          />
          <div class="flex-1">
            <h3 class="text-xl mb-2" v-text="daysOfTheWeek[schedule.details.day]" />
            <div class="mb-1">
              <span class="text-gray-700 mr-2">Expected Time In:</span>
              <span v-text="formatDate(schedule.start_date_at, 'hh:mm A')" />
            </div>
            <div class="mb-1">
              <span class="text-gray-700 mr-2">Time to go out:</span>
              <span v-text="formatDate(schedule.end_date_at, 'hh:mm A')" />
            </div>
            <div class="mb-1">
              <span class="text-gray-700 mr-2">Last updated at:</span>
              <span v-text="formatDate(schedule.updated_at, 'MM/DD/YYYY')" />
            </div>
          </div>
        </div>
      </div>
    </template>

    <user-profile-sidebar slot="sidebar" />
  </page-layout>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'
import UserProfileSidebar from './UserProfileSidebar'

export default {
  components: {
    UserProfileSidebar
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    }),

    schedules () {
      return this.user.schedules
    },

    daysOfTheWeek () {
      return [
        'Sunday', 'Monday', 'Tuesday', 'Wednesday',
        'Thursday', 'Friday', 'Saturday'
      ]
    }
  },

  methods: {
    formatDate
  }
}
</script>

