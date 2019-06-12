<script>
import formatter from 'date-fns/format'

export default {
  props: {
    format: {
      default: 'DD/MM/YYYY hh:mm A'
    },

    date: {
      required: true
    }
  },

  render () {
    return this.$$scopedSlots.default({
      result: formatter(this.date, this.format)
    })
  }
}
</script>
