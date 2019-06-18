<template>
  <stream-layout>
    <user-photo
      :user="content.user"
      class="absolute left-4 top-4 text-2xl"
    />
  </stream-layout>
</template>

<script>
import StreamItem from './StreamItem'

export default {
  extends: StreamItem
}
</script>
