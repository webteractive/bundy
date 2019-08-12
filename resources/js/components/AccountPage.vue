<template>
  <page-layout>
    <template slot="content">
      <ct>Account</ct>
    </template>

    <user-profile-sidebar slot="sidebar" />
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

