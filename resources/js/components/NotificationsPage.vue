<template>
  <page-layout>
    <template slot="content">
      <ct>Notifications {{ unreadNotificationsCount > 0 ? ` (${unreadNotificationsCount})` : '' }}</ct>

      <notification-item
        v-for="notification in notifications"
        :key="notification.id"
        :notification="notification"
        @read="refresh()"
        @destroyed="refresh()"
      />

      <nothing-to-show-yet
        v-if="notifications.length === 0"
        message="No unread notification yet."
        class="px-4 py-3 text-gray-700"
      />
    </template>

    <template slot="sidebar">
      <user-profile-sidebar />
    </template>
  </page-layout>
</template>

<script>
import notifier from '../mixin/notifier'
import NotificationItem from './NotificationItem'
import UserProfileSidebar from './UserProfileSidebar'

export default {
  mixins: [
    notifier
  ],

  components: {
    NotificationItem,
    UserProfileSidebar
  },

  methods: {

    destroyAll () {
      this.$http.route('notification.destroyAll')
        .post()
          .then(({ data }) => {
            this.refresh();
          })
    },

    markAllAsRead () {
      this.$http.route('notification.updateAll')
        .post()
          .then(({ data }) => {
            this.refresh();
          })
    },

    refresh () {
      this.fetchNotifications()
    }
  },

  created () {
    this.fetchNotifications()
  }
}
</script>

