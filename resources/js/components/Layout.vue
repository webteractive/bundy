<template>
  <div class="min-h-screen">
    <helmet />
    <div class="relative">
      <face class="relative z-10" />
      <navigator class="relative z-20" />
    </div>
    <div class="container mx-auto bg-white border-l border-r border-b-2 rounded-b pt-20 px-4 pb-4">
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

