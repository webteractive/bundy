<template>
  <div id="bundy" class="min-h-screen">
    <div class="w-1/2 min-h-screen mx-auto flex justify-center items-center">
      <clocky />
    </div>
  </div>
</template>

<script>
import Clocky from './Clocky'

export default {
  components: {
    Clocky
  }
}
</script>
