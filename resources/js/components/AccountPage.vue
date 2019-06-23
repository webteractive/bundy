<template>
  <page-layout>
    <template slot="content">
      <ct>Account</ct>
    </template>

    <template slot="sidebar">
      <user-profile-sidebar v-if="editable" />
      <upcoming-events-widget />
    </template>
  </page-layout>
</template>

<script>
import profile from '../mixin/profile'
import UserProfileSidebar from './UserProfileSidebar'
import UpcomingEventsWidget from './UpcomingEventsWidget'

export default {
  mixins: [
    profile
  ],

  components: {
    UserProfileSidebar,
    UpcomingEventsWidget
  }
}
</script>

