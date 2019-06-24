<template>
  <div class="admin">
    <ct>Schedule Requests</ct>

    <div
      v-if="items.length > 0"
      class="p-0"
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

        <h3 class="flex items-center mb-2">
          <warp
            :label="item.user.name"
            :to="['profile', item.user.username]"
            class="font-bold hover:underline"
          />
          <span class="text-gray-700 ml-2">has requested to change schedule</span>

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="item.created_at"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />
        </h3>

        <p class="mb-3" v-text="item.reason"/>

        <div class="bg-gray-100 mb-4">
          <div class="flex font-bold px-4 py-2">
            <div class="w-48">Day of the Week</div>
            <div class="flex-1 text-center">Schedules</div>
          </div>

          <div
            v-for="({ name, value }, index) in daysOfTheWeek"
            :key="name"
            :class="{
              'bg-gray-200': (index + 1) % 2
            }"
            class="flex px-4 py-1"
          >
            <div class="w-48 capitalize" v-text="name" />
            <div class="flex-1 flex">
              <div class="flex-1 text-left" v-html="getScheduleTime(name, item, 'from')" />
              <div class="text-center">
                <span>
                  <fa icon="long-arrow-alt-right" />
                </span>
              </div>
              <div class="flex-1 text-right" v-html="getScheduleTime(name, item, 'to')" />
            </div>
          </div>
        </div>

        <the-button
          type="info"
          label="Approved"
          @click="approve(item.id)"
        />
      </div>
    </div>

    <nothing-to-show-yet class="px-4 py-3 italic text-gray-700" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  computed: {
    ...mapGetters({
      schedules: 'schedules',
      items: 'admin/schedule/items',
      daysOfTheWeek: 'clock/daysOfTheWeek'
    })
  },

  methods: {
    fetch () {
      this.$http.get(BUNDY.apis.admin.schedule.list)
        .then(({ data }) => {
          this.$store.dispatch('admin/schedule/hydrate', data)
        })
    },

    approve (id) {
      this.$http.post(`${BUNDY.apis.admin.schedule.update}/${id}`)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
          this.fetch()
          this.$bus.emit('admin.stats.refresh')
        })
    },

    getScheduleTime (day, source, key) {
      const scheduleId = source[key][day]
      return [
        '1:00 AM',
        '7:00 PM'
      ].join('&mdash;')
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>

