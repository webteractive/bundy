<template>
  <div
    :class="{
      'text-gray-600': notification.read_at !== null,
      'bg-red-100': isType(['change_schedule_request_disapproved']),
      'bg-green-100': isType(['change_schedule_request_approved']),
    }"
    class="relative p-4 pl-20 min-h-20 border-b hover:bg-gray-200"
  >
    <div
      :class="[`
        w-12 h-12 text-3xl flex items-center 
        justify-center absolute left-4 top-4
      `, {
        'text-white bg-blue-500': notification.read_at === null,
        'text-white bg-gray-600': notification.read_at !== null,
      }]"
    >
      <fa :icon="detail.icon" />
    </div>

    <h3 class="mb-1">
      <span v-text="detail.title" class="font-bold" />

      <span class="text-sm text-black">·</span>

      <live-date
        :date="notification.created_at"
        class="text-sm text-gray-500 hover:underline"
      />
    </h3>

    <div>
      <router-link
        v-if="isType(['change_schedule_request'])"
        :to="`/profile/${user.username}`"
        v-text="user.name"
        class="text-blue-500 hover:underline hover:text-blue-600"
      />
      {{ detail.message }}
      Click <a @click="navigate" class="text-blue-500 cursor-pointer hover:underline hover:text-blue-600">here</a> for more details.
    </div>

    <drop-down
      :menu="menu"
      @read="markAsRead()"
      @destroy="destroy()"
      class="absolute right-4 top-4 z-20 text-black"
    />
  </div>
</template>

<script>
import DropDown from './DropDown'

export default {
  props: {
    notification: {
      type: Object,
      required: true
    }
  },

  components: {
    DropDown
  },

  computed: {
    menu () {
      return [
        ['read', 'Mark as read'],
        ['destroy', 'Delete'],
      ]
    },

    payload () {
      return this.notification.data
    },

    type () {
      return this.payload.type
    },

    user () {
      return this.payload.user
    },

    details () {
      return {
        leave_request: {
          icon: 'calendar',
          title: 'Leave Request',
          message: 'has filed a request for leave and awaiting your approval.',
          route: {name: 'admin.leaves'}
        },
        change_schedule_request: {
          icon: 'clock',
          title: 'Change Schedule Request',
          message: 'has filed a request for change schedule and awaiting your approval.',
          route: {name: 'admin.schedules'}
        },
        change_schedule_request_approved: {
          icon: 'clock',
          title: 'Change Schedule Request',
          message: 'Your change schedule request has been approved!',
          route: {name: 'schedules'}
        },
        change_schedule_request_disapproved: {
          icon: 'clock',
          title: 'Change Schedule Request',
          message: 'Your change schedule request has been declined.',
          route: {name: 'schedules'}
        }
      }
    },

    detail () {
      return this.details[this.type]
    }
  },

  methods: {
    isType (types = []) {
      return types.includes(this.type)
    },

    destroy () {
      if (confirm('Are you sure you want to delete this notification?')) {
        this.$http.route('notification.destroy', {id: this.notification.id})
          .post()
            .then(({ data }) => {
              this.$emit('destroyed')
            })
      }
    },

    navigate (event) {
      event.preventDefault()
      this.markAsRead()
    },

    markAsRead () {
      this.$http.route('notification.update', {id: this.notification.id})
        .post()
          .then(({ data }) => {
            this.$emit('read')
            this.$router.push(this.detail.route)
          })
    },
  }
}
</script>