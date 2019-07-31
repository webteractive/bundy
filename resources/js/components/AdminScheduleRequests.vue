<template>
  <div class="admin">
    <ct>Schedule Requests</ct>

    <paginator
      :payload="scheduleRequests"
      v-slot="{
        items,
        pagination,
      }"
    >
      <div
        v-for="item in items"
        :key="item.id"
        class="relative p-4 pl-24 min-h-24 border-b"
      >
        <user-photo
          :user="item.user"
          class="absolute left-4 top-4 text-2xl"
        />

        <h3 class="flex items-center">
          <warp
            :label="item.user.name"
            :to="['profile', item.user.username]"
            class="font-bold hover:underline"
          />
          <span class="text-gray-700 ml-2">wants to change schedule</span>

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="item.created_at"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />
        </h3>

        <p class="mb-3" v-text="item.reason"/>

        <div class="mb-6 pt-3 border-dashed border-t">
          <div
            v-for="(schedule, index) in resolveScheduleList(item)"
            :key="`scheduule-${item.id}-${index}`"
            class="mb-2"
          >
            <div class="capitalize font-bold mb-1" v-text="schedule.day.name" />
            <div class="border-r">
              <div class="flex items-center">
                <div class="mr-3">
                  {{ schedule.from.starts_at_display }}
                  &mdash;
                  {{ schedule.from.ends_at_display }}
                </div>
                <span class="mr-3">
                  <fa icon="long-arrow-alt-right" />
                </span>
                <div>
                  {{ schedule.to.starts_at_display }}
                  &mdash;
                  {{ schedule.to.ends_at_display }}
                </div>
              </div>
            </div>
          </div>          
        </div>

        <the-button
          type="info"
          label="Approve"
          @click="approve(item)"
        />

        <the-button
          label="Decline"
          @click="disapprove(item)"
        />
      </div>
    </paginator>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Paginator from './Paginator'
import formatDate from 'date-fns/format'

export default {
  components: {
    Paginator
  },

  computed: {
    ...mapGetters({
      schedules: 'schedules',
      items: 'admin/schedule/items',
      scheduleRequests: 'admin/scheduleRequest/pagination',
      daysOfTheWeek: 'clock/daysOfTheWeek'
    })
  },

  methods: {
    fetch () {
      this.$http.route('admin.schedule.requests')
        .get()
          .then(({ data }) => {    
            this.$store.dispatch('admin/scheduleRequest/paginate', data)
          })
    },

    approve ({ id }) {
      this.$http.route('admin.schedule.request.update', { id })
        .post()
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$bus.emit('admin.stats.refresh')
            this.fetch()
          })
    },

    disapprove ({ id }) {
      this.$http.route('admin.schedule.request.destroy', { id })
        .post()
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.fetch()
            this.$bus.emit('admin.stats.refresh')
          })
    },

    resolveScheduleList ({from, to}) {
      const requests = Object.keys(to)
      const changed = requests.filter(item => {
        return from[item] !== to[item]
      })

      const final = changed.map(day => {
        return {
          day: this.daysOfTheWeek.find(item => item.name === day),
          from: this.schedules.find(schedule => schedule.id === from[day]),
          to: this.schedules.find(schedule => schedule.id === to[day])
        }
      })

      return final
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

