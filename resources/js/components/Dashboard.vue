<template>
  <div class="dash bg-gray-100 border p-4 border-b-4 rounded">
    <btn
      label="Logout"
      class="bg-blue-500 text-white border-blue-600 border-b-2 rounded hover:bg-blue-600 hover:border-blue-700"
      @click.native="logout()"
    />
  </div>
</template>

<script>
export default {
  methods: {
    logout () {
      this.$http.post('void/logout')
        .then(() => {
          this.$store.dispatch('user/logout')
        })
    }
  }
}
</script>

