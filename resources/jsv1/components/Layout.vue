<template>
  <div class="min-h-screen">
    <helmet />
    <div class="relative">
      <face class="relative z-10" />
      <navigator class="relative z-20" />
    </div>
    <div class="container mx-auto rounded-b pt-16">
      <slot />
    </div>
    <shoe />
  </div>
</template>

<script>
import Navigator from './Navigator'

export default {
  components: {
    Navigator
  }
}
</script>

