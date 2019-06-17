<template>
  <div class="relative bg-gray-300">
      <accent class="h-screen-50" />
      <div class="flex min-h-screen justify-center items-center relative">
        <div class="login">
          <div class="bg-white shadow">
            <ct>Sign In</ct>

            <div class="p-4">
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
                type="email"
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
                :label="`Login @ ${formatDate(now, 'hh:mm:ss A')}`"
                @click.native="login()"
                class="bg-blue-500 text-white border border-blue-600 hover:bg-blue-600 hover:border-blue-700"
              />
            </div>
          </div>
          
          <shoe />
        </div>
      </div>
    </div>
</template>

<script>
import Cookies from 'js-cookie'
import { mapGetters } from 'vuex'
import formatDate from 'date-fns/format'

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
    ...mapGetters({
      now: 'clock/time'
    }),

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
    formatDate,

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
