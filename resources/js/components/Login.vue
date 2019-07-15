<template>
  <error-manager
    :error="error"
    v-slot="{
      hasError,
      hasErrors,
      getErrorFor
    }"
  >
    <div class="relative bg-gray-300">
      <div
        :class="{
          'bg-red-500 text-red-900': hasErrors,
          'bg-gray-900 text-gray-700': hasErrors === false
        }"
        class="absolute h-screen-50 w-full z-0 top-0 left-0 right-0 flex items-start justify-center transition-bg-color"
      >
        <div class="mt-32 leading-none font-clock text-center hidden sm:inline-block">
          <div class="text-nomal tracking-wider mb-1" v-text="formatDate(now, 'MMMM DD, YYYY')" />
          <div class="text-2xl tracking-widest mb-1" v-text="formatDate(now, 'dddd')" />
          <div class="text-2xl tracking-widest" v-text="formatDate(now, 'hh:mm A')" />
        </div>
      </div>
      <div class="flex min-h-screen justify-center items-center relative">
        <div class="login">
          <div class="bg-white shadow">
            <ct>Sign In to Bundy</ct>
            <div class="p-4">

              <field
                :has-error="hasError('email')"
                :errors="getErrorFor('email')"
                v-model="form.email"
                label="Email"
                type="email"
                class="mb-4"
                @enter="signIn()"
              />

              <field
                :has-error="hasError('password')"
                :errors="getErrorFor('password')"
                v-model="form.password"
                label="Password"
                type="password"
                class="mb-4"
                @enter="signIn()"
              />

              <div class="field mb-6">
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" v-model="form.remember" class="mr-2" />
                  Remember me
                </label>
              </div>

              <the-button
                @click="signIn()"
                type="info"
                label="Sign In"
              />
            </div>
          </div>
          
          <shoe />
        </div>
      </div>
    </div>
  </error-manager>
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
    })
  },

  methods: {
    formatDate,

    signIn () {
      this.error = null
      this.$http.route('login')
        .post(this.form)
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

<style lang="scss">
.login {
  width: 380px;
}
</style>
