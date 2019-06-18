<script>
import StreamHead from './StreamHead'
import StreamMenu from './StreamMenu'
import StreamLayout from './StreamLayout'

export default {
  props: {
    content: {
      required: true
    }
  },

  components: {
    StreamHead,
    StreamMenu,
    StreamLayout
  }
}
</script>
