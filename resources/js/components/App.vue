<template>
  <div id="bundy" class="min-h-screen">
    <div class="w-1/2 min-h-screen mx-auto flex justify-center items-center">
      <keep-alive>
        <component :is="view" />
      </keep-alive>
    </div>
  </div>
</template>

<script>
import Login from './Login'
import Clocky from './Clocky'

export default {
  components: {
    Login,
    Clocky
  },

  computed: {
    view () {
      const { authenticated } = this.$store.getters
      return authenticated ? 'clocky' : 'login'
    }
  }
}
</script>
