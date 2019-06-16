<template>
  <button @click="navigate()">
    <slot>
      {{ label }}
    </slot>
  </button>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  props: {
    label: {
      type: String,
      default: ''
    },

    to: {
      type: Array,
      required: true
    }
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  },

  methods: {
    navigate () {
      let [page, identifier, inner] = this.to

      if (typeof identifier === 'undefined') {
        identifier = null
      }

      if (typeof inner === 'undefined') {
        inner = null
      }
      
      if (page === 'profile') {
        if (identifier === this.user.username) {
          this.$store.dispatch('profile/hydrate', this.user)
        }
      }

      this.$store.dispatch('nav/navigate', {
        page,
        inner,
        identifier,
      })
    }
  }
}
</script>
