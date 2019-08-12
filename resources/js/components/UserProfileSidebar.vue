<template>
  <div class="bg-white mb-3">
    <ct>Account Info</ct>
    <div class="py-4">
      <ul class="sidebar-menu">
        <li
          v-for="[route,,,, label] in menu"
          :key="route"
          :class="{
            'active': isActive(route)
          }"
          v-text="label"
          @click="navigate(route)"
        />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    menu () {
      return this.$store.getters['nav/allItems'].filter(item => {
        const [,,, position] = item
        return position.includes('sidebar')
      })
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

