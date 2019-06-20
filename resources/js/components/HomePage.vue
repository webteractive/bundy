<template>
  <page-layout>
    <template slot="content">
      <time-navigator />
      <stream />
    </template>
  </page-layout>
</template>

<script>
import Stream from './Stream'
import TimeNavigator from './TimeNavigator'

export default {
  components: {
    Stream,
    TimeNavigator
  }
}
</script>
