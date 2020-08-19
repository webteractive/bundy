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
    },

    payload: {
      type: Object,
      default: null
    },

    qs: {
      type: Object,
      default: null
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
        if (identifier !== null) {
          this.$store.dispatch('profile/hydrate', identifier === this.user.username ? this.user : this.payload)
        }
      }

      this.$store.dispatch('nav/navigate', {
        page,
        inner,
        identifier,
        qs: this.qs
      })

      this.$emit('navigate')
    }
  }
}
</script>
