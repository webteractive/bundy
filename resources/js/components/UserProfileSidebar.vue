<template>
  <div class="bg-white mb-3">
    <ct>Account Info</ct>
    <div class="py-4">
      <ul>
        <li
          v-for="[page, route] in menu"
          :key="page"
          :class="{
            'bg-blue-100 font-bold text-blue-600': isActive(route)
          }"
          v-text="page"
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
        ['profile', 'edit-profile'],
        ['schedules', 'schedules'],
        ['account', 'account']
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

