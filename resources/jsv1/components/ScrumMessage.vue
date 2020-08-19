<template>
  <div class="scrum-message text-gray-800">
    <scrum-message-items
      v-if="scrum.yesterday.length > 0"
      :items="scrum.yesterday"
      class="mb-4"
      title="Yesterday"
      icon="check-square"
      icon-color="text-green-400"
    />

    <scrum-message-items
      v-if="scrum.blockers.length > 0"
      :items="scrum.blockers"
      class="mb-4"
      title="Blockers"
      icon="thumbs-down"
      icon-color="text-red-400"
    />

    <scrum-message-items
      :items="scrum.today"
      class="mb-4"
      title="Today"
      icon="square"
      icon-color="text-gray-500"
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
