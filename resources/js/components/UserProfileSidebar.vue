<template>
  <div class="bg-white mb-3">
    <ct>Account Info</ct>
    <div class="py-4">
      <ul>
        <li
          v-for="[route, label] in menu"
          :key="route"
          :class="{
            'bg-blue-100 font-bold text-blue-600': isActive(route)
          }"
          v-text="label"
          @click="navigate(route)"
          class="px-4 py-2 capitalize cursor-pointer hover:bg-blue-100 hover:text-blue-600"
        />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    menu () {
      return [
        ['edit-profile', 'Edit Profile'],
        ['schedules', 'Schedules'],
        ['account', 'Account']
      ]
    }
  },

  methods: {
    navigate (page) {
      this.$store.dispatch('nav/navigate', {
        page
      });
    },

    isActive (page) {
      return this.$store.getters['nav/active'] === page
    }
  }
}
</script>

