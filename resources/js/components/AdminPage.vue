<template>
  <page-layout>
    <template slot="content">
      <router-view />
    </template>

    <template slot="sidebar">
      <div class="bg-white mb-3">
        <ct>Modules</ct>
        <div class="py-4">
          <ul class="sidebar-menu">
            <router-link
              v-for="[route, label] in modules"
              :key="route"
              :to="route"
              tag="li"
              exact
              active-class="active"
            >
              <span class="flex-1" v-text="label" />
              <span
                v-if="getStats(route)"
                v-text="getStats(route)"
                class="bg-blue-500 text-white px-2 py-0 tracking-none font-thin text-sm"
              />
            </router-link>
          </ul>
        </div>
      </div>
    </template>
  </page-layout>
</template>

<script>
import AdminUsers from './AdminUsers'
import AdminRemote from './AdminRemote'
import AdminDashboard from './AdminDashboard'
import AdminLeaveRequests from './AdminLeaveRequests'
import AdminScheduleRequests from './AdminScheduleRequests'

export default {
  components: {
    AdminUsers,
    AdminRemote,
    AdminDashboard,
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
        ['/admin/', 'Dashboard'],
        ['/admin/users', 'Manage Users'],
        ['/admin/schedules', 'Schedule Requests'],
        ['/admin/leaves', 'Leave Requests'],
        ['/admin/remotes', 'Working Remote Requests']
      ]
    },

    identifier () {
      return this.$store.getters['nav/identifier']
    },

    active () {
      if (this.identifier === null) {
        return 'admin-dashboard'
      }

      return `admin-${this.identifier.toComponent()}`
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
      this.$http.route('admin.stats').get()
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
