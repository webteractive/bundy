<template>
  <page-layout>
    <template slot="content">
      <component :is="active" />
    </template>

    <template slot="sidebar">
      <div class="bg-white mb-3">
        <ct>Modules</ct>
        <div class="py-4">
          <ul>
            <li
              v-for="[mod, label] in modules"
              :key="mod"
              :class="{
                'bg-blue-100 font-bold text-blue-600': isActive(mod)
              }"
              @click="navigate(mod)"
              class="px-4 py-2 capitalize cursor-pointer hover:bg-blue-100 hover:text-blue-600 flex items-center"
            >
              <span class="flex-1" v-text="label" />
              <span
                v-if="getStats(mod)"
                v-text="getStats(mod)"
                class="bg-blue-500 text-white px-2 py-0 tracking-none font-thin text-sm"
              />
            </li>
          </ul>
        </div>
      </div>
    </template>
  </page-layout>
</template>

<script>
import AdminDashboard from './AdminDashboard'
import AdminPerformance from './AdminPerformance'
import AdminLeaveRequests from './AdminLeaveRequests'
import AdminScheduleRequests from './AdminScheduleRequests'

export default {
  components: {
    AdminDashboard,
    AdminPerformance,
    AdminLeaveRequests,
    AdminScheduleRequests
  },

  data () {
    return {
      stats: null
    }
  },

  computed: {
    modules () {
      return [
        ['dashboard', 'Dashboard'],
        ['schedule-requests', 'Schedule Requests'],
        ['leave-requests', 'Leave Requests'],
        ['performance', 'Performance'],
      ]
    },

    identifier () {
      return this.$store.getters['nav/identifier']
    },

    active () {
      if (this.identifier === null) {
        return 'admin-dashboard'
      }

      return `admin-${this.identifier}`
    }
  },

  methods: {
    navigate (mod) {
      this.$store.dispatch('nav/navigate', {
        page: 'admin',
        identifier: mod === 'dashboard' ? null : mod
      });
    },

    isActive (mod) {
      if (mod === 'dashboard' && this.identifier === null) {
        return true
      }

      return this.identifier === mod
    },

    fetch () {
      this.$http.get(BUNDY.apis.admin.stats)
        .then(({ data }) => {
          this.stats = data
        })
    },

    getStats (mod) {
      if (this.stats === null) {
        return null
      }

      if (mod === 'schedule-requests') {
        return this.stats.scheduleRequests
      }

      return null
    }
  },

  created () {
    this.fetch();
  },

  mounted () {
    this.$bus.on('admin.stats.refresh', () => this.fetch())
  }
}
</script>
