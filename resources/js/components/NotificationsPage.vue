<template>
  <page-layout>
    <template slot="content">
      <ct>Notifications</ct>

      <div class="p-0">
        <div
          v-for="{id, created_at, data, read_at} in notifications"
          :key="id"
          :class="{
            'text-gray-600': read_at !== null
          }"
          class="relative p-4 pl-20 min-h-20 border-b hover:bg-gray-200"
        >
          <template v-if="data.type === 'change_schedule_request'">
            <div
              :class="[`
                w-12 h-12 text-3xl text-white flex items-center 
                justify-center absolute left-4 top-4
              `, {
                'bg-blue-500': read_at === null,
                'bg-gray-500': read_at !== null
              }]"
            >
              <fa icon="clock" />
            </div>

            <div class="mb-1">
              <span class="font-bold">Change Schedule Request</span>
              <span class="text-sm text-black">·</span>

              <live-date
                :date="created_at"
                class="text-sm text-gray-500 hover:underline"
              />
            </div>

            <div class="relative mb-1">
              <warp
                :to="['profile', data.user.username]"
                :label="data.user.name"
                class="text-blue-500 font-bold hover:underline"
              />

              <span>has requested to change schedule, click <warp :to="['admin', 'schedule-requests']" label="here" class="text-blue-500 hover:underline" /> for more details.</span>
            </div>
          </template>

          <div class="absolute top-4 right-4">
            <button
              v-if="read_at === null"
              :class="`
                text-blue-500 mr-2
                hover:underline hover:text-blue-600
              `"
              v-text="`Mark as read`"
              @click="markAsRead(id)"
              title="Mark as read this notification"
            />

            <button
              :class="`
                text-red-500 
                hover:underline hover:text-red-600
              `"
              v-text="`Delete`"
              @click="destroy(id)"
              title="Delete this notification"
            />
          </div>
        </div>

        <nothing-to-show-yet
          v-if="notifications.length === 0"
          message="No unread notification yet."
          class="px-4 py-3 text-gray-700"
        />
      </div>
    </template>

    <template slot="sidebar">
      <user-profile-sidebar />
    </template>
  </page-layout>
</template>

<script>
import notifier from '../mixin/notifier'
import UserProfileSidebar from './UserProfileSidebar'

export default {
  mixins: [
    notifier
  ],

  components: {
    UserProfileSidebar
  },

  methods: {
    destroy (id) {
      this.$http.route('notification.destroy', { id }).post()
        .then(({ data }) => {
          this.fetchNotifications();
        })
    },

    markAsRead (id) {
      this.$http.route('notification.update', { id }).post()
        .then(({ data }) => {
          this.fetchNotifications();
        })
    },

    destroyAll () {
      this.$http.route('notification.destroyAll').post()
        .then(({ data }) => {
          this.fetchNotifications();
        })
    },

    markAllAsRead () {
      this.$http.route('notification.updateAll').post()
        .then(({ data }) => {
          this.fetchNotifications();
        })
    }
  },

  created () {
    this.fetchNotifications()
  }
}
</script>

