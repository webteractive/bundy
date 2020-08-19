<template>
  <h3 class="flex items-center mb-2">
    <slot name="name">
      <router-link
        v-if="content.user.username"
        :to="`/profile/${content.user.username}`"
        v-text="content.user.name"
        class="font-bold cursor-pointer hover:underline"
      />
      <span
        v-else
        v-text="content.user.name"
        class="font-bold"
      />
    </slot>

    <span 
      v-if="content.user.username && showUsername"
      v-text="`@${content.user.username}`"
      class="text-sm text-gray-500 ml-1"
    />

    <span class="text-sm text-black ml-2">·</span>

    <live-date
      :date="content.stream_date"
      class="text-sm text-gray-500 ml-2 hover:underline"
    />
  </h3>
</template>

<script>
import profile from '../mixin/profile'

export default {
  props: {
    content: {
      required: true
    },

    showUsername: {
      default: true
    }
  },

  mixins: [
    profile
  ],

  methods: {
    warpToProfile () {
      if (this.content.user.username !== null) {
        this.showProfile(this.content.user)
      }
    }
  }
}
</script>


