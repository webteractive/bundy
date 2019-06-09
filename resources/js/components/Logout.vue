<template>
  <button
    type="button"
    @click="logout()"
    class="bg-red-600 text-white py-3 px-2 cursor-pointer ml-2 hover:bg-red-700"
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

