<template>
  <page-layout>
    <template slot="content">
      <ct>Home</ct>
      <div class="relative min-h-256">
        <quote-of-the-day />
      </div>
    </template>
  </page-layout>
</template>

<script>
import QuoteOfTheDay from './QuoteOfTheDay'

export default {
  components: {
    QuoteOfTheDay
  }
}
</script>
