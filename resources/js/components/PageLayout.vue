<template>
  <master-layout>
    <div class="home">
      <div class="container mx-auto">
        <div class="block md:flex">
          <section class="w-full bg-white mt-3 mb-3 md:w-2/3 md:mr-3 md:mt-0">
            <slot name="content"></slot>
          </section>
          <div class="w-full md:w-1/3">
            <slot name="sidebar">
              <leaderboard-widget />
              <status-widget />
              <upcoming-events-widget />
              <presence-widget />
            </slot>

            <shoe />
          </div>
        </div>
      </div>
    </div>
  </master-layout>
</template>



<script>
import StatusWidget from './StatusWidget'
import PresenceWidget from './PresenceWidget'
import LeaderboardWidget from './widgets/Leaderboard'
import UpcomingEventsWidget from './UpcomingEventsWidget'

export default {
  components: {
    StatusWidget,
    PresenceWidget,
    LeaderboardWidget,
    UpcomingEventsWidget
  }
}
</script>