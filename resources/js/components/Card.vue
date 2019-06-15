<template>
  <div class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100">
    <slot name="card">
      <user-photo
        :user="content.user"
        class="absolute left-4 top-4 text-2xl"
      />

      <div class="p-0">
        <h3 class="mb-2">
          <span
            :class="{
              'cursor-pointer hover:underline': content.user.username
            }"
            v-text="content.user.name"
            class="text-sm text-base font-bold"
            @click="warpToProfile()"
          />

          <span 
            v-if="content.user.username"
            v-text="`@${content.user.username}`"
            class="text-sm text-gray-500"
          />

          <span class="text-sm text-black">·</span>

          <live-date
            :date="content.stream_date"
            class="text-sm text-gray-500 hover:underline"
          />
        </h3>

        <slot 
          :message="content.message"
          name="message"
        >
          <p v-text="content.message" />
        </slot>
      </div>
    </slot>

    <slot name="extra" />
  </div>
</template>

<script>
import profile from '../mixin/profile'

export default {
  props: {
    content: {
      required: true
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
