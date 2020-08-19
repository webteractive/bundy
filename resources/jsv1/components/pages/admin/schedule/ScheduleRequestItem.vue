<template>
  <div class="relative p-4 pl-24 min-h-24 border-b">
    <user-photo
      :user="item.user"
      size="smaller"
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

    <div class="mb-6 pt-3 border-t">
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
      :loading="approving"
      :disabled="rejecting"
      type="info"
      label="Approve"
      loading-text="Approving..."
      @click="approve(item)"
    />

    <the-button
      :loading="rejecting"
      :disabled="approving"
      type="danger"
      label="Reject"
      loading-text="Rejecting..."
      @click="reject(item)"
    />

    <slot name="buttons" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

export default {
  props: ['item'],

  computed: {
    ...mapGetters({
      schedules: 'schedules',
      daysOfTheWeek: 'clock/daysOfTheWeek'
    })
  },

  data () {
    return {
      approving: false,
      rejecting: false
    }
  },

  methods: {
    toggleLoading (mode, loading) {
      this[mode] = loading
      if (loading) {
        this.$progress.start()
      } else {
        this.$progress.done()
      }
    },

    approve ({ id }) {
      this.toggleLoading('approving', true)
      this.$http.route('admin.schedule.request.update', { id })
        .post()
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$bus.emit('admin.stats.refresh')
            this.$emit('refresh')
            this.toggleLoading('approving', false)
          })
          .cacth(error => {
            console.log(error)
            this.toggleLoading('approving', false)
          })
    },

    reject ({ id }) {
      this.toggleLoading('rejecting', true)
      this.$http.route('admin.schedule.request.destroy', { id })
        .post({ reason: null })
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$bus.emit('admin.stats.refresh')
            this.$emit('refresh')
            this.toggleLoading('approving', false)
          })
          .cacth(error => {
            console.log(error)
            this.toggleLoading('approving', false)
          })
    },

    resolveScheduleList ({from, to}) {
      const requests = Object.keys(to)
      const changed = requests.filter(item => {
        if (typeof from[item] === 'undefined') {
          return false
        }

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
  }
}
</script>