<template>
  <div class="login bg-gray-100 border p-4 border-b-4 rounded">
    <h1 class="mb-4 text-2xl">Sign In</h1>

    <field
      v-model="form.email"
      label="Email"
      type="text"
      class="mb-4"
    />

    <field
      v-model="form.password"
      label="Password"
      type="password"
      class="mb-4"
    />

    <div class="field mb-6">
      <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" v-model="form.remember" class="mr-2" />
        Remember me
      </label>
    </div>

    <btn
      label="Login"
      class="bg-blue-500 text-white border-blue-600 border-b-2 rounded hover:bg-blue-600 hover:border-blue-700"
      @click.native="signIn()"
    />
  </div>
</template>

<script>
export default {
  data () {
    return {
      form: {
        email: '',
        password: '',
        remember: false
      }
    }
  },

  methods: {
    signIn () {
      this.$http.post('/void/login', this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/login', user)
        })
    }
  }
}
</script>
