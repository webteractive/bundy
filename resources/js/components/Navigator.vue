<template>
  <bundy v-slot="{ late, normal }">
    <nav
      class="`
        container mx-auto bg-transparent -m-10 h-10 flex justify-center p-0
        md:justify-start
      `"
    >
      <a
        v-for="item in items"
        :key="item"
        :class="{
          'bg-white text-black hover:bg-white': isActive(item),
          'text-gray-600 hover:bg-gray-200': isNotActive(item),
          'border-red-200': late && isActive(item)
        }"
        v-text="item === 'home' ? 'dashboard' : item"
        @click.prevent="setActive(item)"
        class="`
          uppercase px-3 h-10 flex items-center border-l border-r border-t
          border-transparent tracking-widest text-sm cursor-pointer
          md:justify-center
        `"
      />
    </nav>
  </bundy>
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
      return this.active === item
    },

    isNotActive (item) {
      return this.active !== item
    }
  }
}
</script>

