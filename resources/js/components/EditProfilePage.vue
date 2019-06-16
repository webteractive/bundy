<template>
  <page-layout>
    <template slot="content">
      <ct>Edit Profile</ct>
    </template>

    <user-profile-sidebar slot="sidebar" />
  </page-layout>
</template>

<script>
import UserProfileSidebar from './UserProfileSidebar'

export default {
  components: {
    UserProfileSidebar
  }
}
</script>

