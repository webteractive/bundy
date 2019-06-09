<template>
  <bundy v-slot="{ off, late, time, normal, formatter }">
    <div class="relative bg-gray-300">
      <accent class="h-screen-50" />
      <div class="flex min-h-screen justify-center items-center relative">
        <div class="login">
          <div class="bg-white p-6 border-gray-500 border-b-2 rounded">
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
              :label="`Login @ ${formatter('hh:MM A')}`"
              :class="{
                'bg-gray-900 text-white border-black border-b-2 rounded hover:bg-black': off,
                'bg-blue-500 text-white border-blue-600 border-b-2 rounded hover:bg-blue-600 hover:border-blue-700': normal,
                'bg-red-500 text-white border-red-600 border-b-2 rounded hover:bg-red-600 hover:border-red-700': late,
              }"
              @click.native="login()"
            />
          </div>
          
          <shoe />
        </div>
      </div>
    </div>
  </bundy>
</template>

<script>
import Cookies from 'js-cookie'

const cookieKey = 'bundy_remembered_email'

export default {
  data () {
    return {
      form: {
        email: '',
        password: '',
        remember: true
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
      this.$http.post(BUNDY.apis.login, this.form)
        .then(({ data: { user } }) => {
          
          if (this.form.remember) {
            Cookies.set(cookieKey, this.form.email, {expires: 7})
          } else {
            Cookies.remove(cookieKey)
          }

          this.$store.dispatch('user/hydrate', user)
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
      this.form.remember = true
    }
  },

  created () {
    if (typeof Cookies.get(cookieKey) !== 'undefined') {
      this.form.email = Cookies.get(cookieKey)
    }
  }
}
</script>

<style lang="scss" scoped>
.login {
  width: 380px;
}
</style>
