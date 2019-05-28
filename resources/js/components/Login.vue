<template>
  <div class="flex min-h-screen justify-center items-center">
    <div class="login">
      <div class="bg-gray-100 border p-6 border-b-4 rounded">
        <h1 class="mb-4 text-2xl">Sign In</h1>

        <div
          v-if="showErrors"
          class="bg-red-500 text-white -ml-6 -mr-6 mb-4" 
        >
          <div class="py-3 px-6">
            <p class="text-md mb-2" v-text="error.message" />
            <ul class="pl-4">
              <li 
                v-for="(error, index) in allErrors"
                :key="index"
                v-text="error"
                class="text-sm list-disc font-bold"
              />
            </ul>
          </div>
        </div>

        <field
          :with-error="hasError('email')"
          v-model="form.email"
          label="Email"
          type="text"
          class="mb-4"
          @enter="login()"
        />

        <field
          :with-error="hasError('password')"
          v-model="form.password"
          label="Password"
          type="password"
          class="mb-4"
          @enter="login()"
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
          @click.native="login()"
        />
      </div>
      <p class="text-center py-4">
        Bundy by <a href="https://webteractive.co" class="bg-gray-500 text-gray-100 px-2 py-1 rounded hover:bg-black hover:text-white">Webteractive</a>
      </p>
    </div>
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
      },
      error: null
    }
  },

  computed: {
    showErrors () {
      return this.error !== null
    },

    allErrors () {
      if (this.showErrors) {
        let errors = []
        for (const key in this.error.errors) {
          if (this.error.errors.hasOwnProperty(key)) {
            const items = this.error.errors[key];
            items.forEach(item => {
              errors.push(item)
            });
          }
        }
        return errors
      } else {
        return []
      }
    }
  },

  methods: {
    login () {
      this.$http.post('/void/login', this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/login', user)
          this.reset()
        })
        .catch(error => {
          this.error = error.response.data
        })
    },

    hasError (field) {
      if (this.error === null) {
        return false
      }
      return typeof this.error.errors[field] !== 'undefined'
    },

    reset () {
      this.error = null 
      this.form.email = ''
      this.form.password = ''
      this.form.remember = false
    }
  }
}
</script>

<style lang="scss" scoped>
.login {
  width: 380px;
}
</style>
