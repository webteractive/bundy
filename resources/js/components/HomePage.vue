<template>
  <page-layout>
    <template slot="content">
      <ct>Home</ct>
      <stream />
    </template>
  </page-layout>
</template>

<script>
import Stream from './Stream'

export default {
  components: {
    Stream
  }
}
</script>
