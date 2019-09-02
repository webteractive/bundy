<template>
  <div class="admin">
    <ct>Leave Requests</ct>

    <paginator
      :payload="leaveRequests"
      v-slot="{
        items,
        pagination,
      }"
    >
      <leave-item
        v-for="leave in items"
        :key="leave.id"
        :leave="leave"
      />
    </paginator>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Paginator from './Paginator'
import LeaveItem from './LeaveItem'

export default {
  components: {
    Paginator,
    LeaveItem
  },

  computed: {
    ...mapGetters({
      leaveRequests: 'admin/leaveRequest/pagination',
    })
  },

  methods: {
    fetch () {
      this.$http.route('admin.leaves')
        .get()
          .then(({ data }) => {
            this.$store.dispatch('admin/leaveRequest/paginate', data)
          })
    }
  },
  
  created () {
    this.fetch()
  }
}
</script>