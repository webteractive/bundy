<script>
import get from 'lodash.get'
import Loader from './Loader'

export default {
  props: {
    api: {
      required: true
    }
  },

  data () {
    return {
      loading: false,
      result: null,
      error: null
    }
  },

  methods: {
    fetch () {
      this.toggleLoading(true)
      this.$http.route(this.api).get()
        .then(({ data }) => {
          this.result = data
          this.$emit('sucessful', data)
          this.toggleLoading(false)
        })
        .catch(error => {
          this.error = error
          this.$emit('failed', error)
          this.toggleLoading(false)     
        })
    },

    toggleLoading (loading) {
      this.loading = loading
    }
  },

  render (h) {
    if (this.loading) {
      return h(Loader)
    } else {
      return this.$scopedSlots.default({
        fetch: this.fetch,
        result: this.result,
      })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>
