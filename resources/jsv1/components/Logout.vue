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
      this.$store.dispatch('nav/navigate', {page: 'home'})
        .then(() => {
          this.$http.route('logout')
              .post()
                .then(() => {
                  
                  // this.$store.dispatch('user/logout')
                  window.location.replace(this.$http.resolveURL('login'))
                })
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

