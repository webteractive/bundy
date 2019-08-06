<template>
  <stream-layout :clickable="false">
    <user-photo
      :user="content.user"
      size="smaller"
      class="absolute left-4 top-4 text-2xl"
    />

    <stream-head :content="content" />

    <p v-text="content.message" />

    <span
      v-text="`Quote`"
      class="absolute top-0 right-4 text-xs italic bg-gray-300 text-gray-600 px-2"
    />

  </stream-layout>
</template>

<script>
import StreamItem from './StreamItem'

export default {
  extends: StreamItem
}
</script>
