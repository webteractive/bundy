<template>
  <layout>
    <component :is="active" />
    <time-logger />
    <scheduler />
  </layout>
</template>

<script>
import Logs from './Logs'
import Home from './Home'
import Leaves from './Leaves'
import Profile from './Profile'
import Status from './Status'
import Logout from './Logout'
import Scheduler from './Scheduler'
import NameInitials from './NameInitials'
import ProfileWidget from './ProfileWidget'
import ScheduleWidget from './ScheduleWidget'
import { mapGetters } from 'vuex';

export default {
  components: {
    Home,
    Logs,
    Leaves,
    Logout,
    Status,
    Profile,
    Scheduler,
    NameInitials,
    ProfileWidget,
    ScheduleWidget,
  },

  computed: {
    ...mapGetters({
      active: 'nav/active'
    })
  }
}
</script>

