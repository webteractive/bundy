<template>
  <div class="scrum-message text-gray-800">
    <scrum-message-items
      v-if="scrum.yesterday.length > 0"
      :items="scrum.yesterday"
      title="Yesterday"
      icon="check-square"
      class="mb-4"
    />

    <scrum-message-items
      v-if="scrum.blockers.length > 0"
      :items="scrum.blockers"
      class="mb-4"
      title="Blockers"
      icon="thumbs-down"
    />

    <scrum-message-items
      :items="scrum.today"
      class="mb-4"
      title="Today"
      icon="square"
    />
  </div>
</template>

<script>
import ScrumMessageItems from './ScrumMessageItems'

export default {
  props: {
    scrum: {
      required: true
    }
  },

  components: {
    ScrumMessageItems
  }
}
</script>
