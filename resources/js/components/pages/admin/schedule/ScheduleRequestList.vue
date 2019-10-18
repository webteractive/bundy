<template>
  <div class="schedule-list">
    <ct>Schedule Requests</ct>
    <paginator
      :payload="scheduleRequests"
      v-slot="{
        items,
        pagination,
      }"
    >
      <schedule-request-item
        v-for="item in items"
        :key="item.id"
        :item="item"
        @refresh="fetch()"
      />
    </paginator>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Paginator from '@components/Paginator'
import ScheduleRequestItem from './ScheduleRequestItem'

export default {
  components: {
    Paginator,
    ScheduleRequestItem
  },

  computed: {
    ...mapGetters({
      items: 'admin/schedule/items',
      scheduleRequests: 'admin/scheduleRequest/pagination',
    })
  },

  methods: {
    fetch () {
      this.$http.route('admin.schedule.requests')
        .get()
          .then(({ data }) => {    
            this.$store.dispatch('admin/scheduleRequest/paginate', data)
          })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>