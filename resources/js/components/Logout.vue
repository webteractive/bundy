<template>
  <button
    type="button"
    @click="logout()"
  >
    Logout
  </button>
</template>

<script>
export default {
  methods: {
    logout () {
      this.$http.post(BUNDY.apis.logout)
        .then(() => {
          this.$store.dispatch('user/logout')
        })
    }
  }
}
</script>

