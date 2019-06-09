<template>
  <nav
    class="`
      container mx-auto bg-gray-100 -m-16 h-16 border-t border-r
      border-l border-b-2 flex justify-center
    `"
  >
    <a
      v-for="item in items"
      :key="item"
      :class="{
        'bg-gray-300 hover:bg-gray-300 hover:text-black': isActive(item)
      }"
      v-text="item === 'home' ? 'dashboard' : item"
      @click.prevent="setActive(item)"
      class="`
        text-gray-600 uppercase px-3 h-16 flex items-center
        tracking-widest text-sm cursor-pointer
        border-b-2 border-transparent
        hover:bg-gray-200
      `"
    />
  </nav>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      items: 'nav/items'
    }),

    active: {
      set (active) {
        this.$store.dispatch('setActive', active)
      },

      get () {
        return this.$store.getters['nav/active']
      }
    }
  },

  methods: {
    ...mapActions({
      setActive: 'nav/setActive'
    }),

    isActive (item) {
      return this.active == item
    }
  }
}
</script>

