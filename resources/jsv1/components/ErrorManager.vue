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

    getArrayField (field) {
      return Object.keys(this.error.errors)
                  .find(keyField => {
                    const test = keyField.split('.')
                    return test.length > 1 && test[0] === field
                  })
    },

    isArrayField (field) {
      return typeof this.getArrayField(field) !== 'undefined'
    },
    
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
