<template>
  <page-layout>
    <template slot="content">
      <ct>Home</ct>
      <div>
        <card />
        <card
          v-for="item in 10"
          :key="item"
        />
      </div>
    </template>

    <template slot="sidebar">
      <div class="h-32 bg-white mb-3">
        <ct>You are late today</ct>
      </div>

      <div class="h-64 bg-white mb-3 shadow">
        <ct>Upcoming Events</ct>
      </div>

      <presence-widget />
    </template>
  </page-layout>
</template>

<script>
import PresenceWidget from './PresenceWidget'

export default {
  components: {
    PresenceWidget
  }
}
</script>
