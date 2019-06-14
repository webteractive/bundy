<template>
  <div class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100">
    <user-photo
      :user="content.user"
      class="absolute left-4 top-4 text-2xl"
    />

    <div class="p-0">
      <h3 class="mb-2">
        <span
          :class="{
            'hover:underline cursor-pointer': content.hasProfile
          }"
          v-text="content.user.name"
          class="text-sm text-base font-bold"
        />

        <span 
          v-if="content.user.username"
          v-tex="content.user.username"
          class="text-sm text-gray-500"
        />

        <span class="text-sm text-gray-500">·</span>

        <live-date class="text-sm text-gray-500" :date="content.date"/>
      </h3>

      <slot 
        :message="message"
        name="message"
      >
        <p v-text="content.message" />
      </slot>
    </div>

    <slot name="extra" />
  </div>
</template>

<script>
export default {
  props: {
    content: {
      required: true
    }
  }
}
</script>
