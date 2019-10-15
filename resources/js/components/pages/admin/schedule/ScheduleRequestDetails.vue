<template>
  <div>
    <ct>Schedule Request Details</ct>
    Details
    <!-- <schedule-request-item
      :item="item"
    /> -->
  </div>
</template>

<script>
import ScheduleRequestItem from './ScheduleRequestItem'

export default {
  components: {
    ScheduleRequestItem
  },

  data () {
    item: {}
  }
}
</script>