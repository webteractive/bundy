<template>
  <div class="bg-white mb-3">
    <ct>Account Info</ct>
    <div class="py-4">
      <ul class="sidebar-menu">
        <router-link
          v-for="[route, label] in menu"
          :key="route"
          :to="route"
          tag="li"
          active-class="active"
          v-text="label"
        />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    menu () {
      const { username } = this.$store.getters['user/details']

      return [
        [`/profile/${username}`, 'Profile'],
        [`/profile/edit`, 'Edit Profile'],
        ['/settings', 'Settings'],
        ['/account', 'Account'],
        ['/schedules', 'Schedules'],
      ]
    }
  }
}
</script>

