<template>
  <div id="bundy" class="min-h-screen">
    <component :is="view" />
  </div>
</template>

<script>
import Login from './Login'
import Clocky from './Clocky'
import Dashboard from './dashboard'

export default {
  components: {
    Login,
    Clocky,
    Dashboard
  },

  computed: {
    view () {
      const authenticated = this.$store.getters['user/authenticated']
      return authenticated ? 'dashboard' : 'login'
    }
  }
}
</script>
