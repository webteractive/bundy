<template>
  <div
    :class="{
      'text-gray-600': notification.read_at !== null
    }"
    class="relative p-4 pl-20 min-h-20 border-b hover:bg-gray-200"
  >
    <div
      :class="[`
        w-12 h-12 text-3xl text-white flex items-center 
        justify-center absolute left-4 top-4
      `, {
        'bg-blue-500': notification.read_at === null,
        'bg-gray-600': notification.read_at !== null
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
      <warp
        :to="['profile', user.username]"
        :label="user.name"
        class="text-blue-500 hover:underline hover:text-blue-600"
      />
      {{ detail.message }}
      Click <warp :to="detail.link" @navigate="markAsRead()" label="here" class="text-blue-500 hover:underline hover:text-blue-600" /> for more details.
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
          link: ['admin', 'leave_requests', this.payload.id]
        },
        change_schedule_request: {
          icon: 'clock',
          title: 'Change Schedule Request',
          message: 'has filed a request for change schedule and awaiting your approval.',
          link: ['admin', 'schedule_requests', this.payload.id]
        }
      }
    },

    detail () {
      return this.details[this.type]
    }
  },

  methods: {
    destroy () {
      if (confirm('Are you sure you want to delete this notification?')) {
        this.$http.route('notification.destroy', {id: this.notification.id})
          .post()
            .then(({ data }) => {
              this.$emit('destroyed')
            })
      }
    },

    markAsRead (id) {
      this.$http.route('notification.update', {id: this.notification.id})
        .post()
          .then(({ data }) => {
            this.$emit('read')
          })
    },
  }
}
</script>