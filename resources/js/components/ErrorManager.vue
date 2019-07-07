<script>
export default {
  props: {
    error: {
      required: true
    }
  },

  computed: {
    hasErrors () {
      return this.error !== null && typeof this.error.errors !== 'undefined'
    }
  },

  methods: {
    
    hasError (field) {
      if (this.error === null) {
        return false
      }
      
      return typeof this.error.errors[field] !== 'undefined'
    },

    getErrorFor (field) {
      if (this.error === null) {
        return []
      }

      return this.error.errors[field]
    }
  },

  render () {
    return this.$scopedSlots.default({
      hasError: this.hasError,
      hasErrors: this.hasErrors,
      getErrorFor: this.getErrorFor
    })
  }
}
</script>
