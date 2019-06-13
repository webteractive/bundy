<template>
  <div class="home">
    <div class="container mx-auto">
      <div class="block md:flex">
        <section class="w-full h-128 bg-white mt-3 mb-3 md:w-2/3 md:mr-3 md:mt-0">
          <slot name="content"></slot>
        </section>
        <div class="w-full md:w-1/3">
          <slot name="sidebar">
            <div class="h-32 bg-white mb-3">
              <ct>You are late today</ct>
            </div>

            <div class="h-64 bg-white mb-3 shadow">
              <ct>Upcoming Events</ct>
            </div>

            <presence-widget />
          </slot>

          <shoe />
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import PresenceWidget from './PresenceWidget'

export default {
  components: {
    PresenceWidget
  }
}
</script>