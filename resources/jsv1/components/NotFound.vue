<template>
  <div class="container mx-auto text-red-700">
    <span v-text="active" class="capitalize font-bold" />? This is definitely a four-o-four! 
  </div>
</template>

<script>
export default {
  computed: {
    active () {
      return this.$store.getters['nav/active']
    }
  }
}
</script>


