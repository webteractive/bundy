<script>
export default {
  props: {
    tag: {
      type: String,
      default: 'button'
    }
  },

  methods: {
    logout () {
      this.$http.post(BUNDY.apis.logout)
        .then(() => {
          this.$store.dispatch('user/logout')
        })
    }
  },

  render (h) {
    return h(this.tag, {
      on: {
        click: this.logout
      }
    }, [this.$slots.default])
  }
}
</script>

