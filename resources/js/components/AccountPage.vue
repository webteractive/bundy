<template>
  <page-layout>
    <template slot="content">
      <ct>Account</ct>
      
      <error-manager
        :error="error"
        v-slot="{
          hasError,
          getErrorFor
        }"
      >
        <div class="relative">
          <div class="px-4 py-3 border-b">
            <div class="flex">
              <div class="w-1/2 mr-2">
                <field
                  :disabled="loading"
                  :has-error="hasError('password')"
                  :errors="getErrorFor('password')"
                  v-model="form.password"
                  required
                  class="mb-4"
                  type="password"
                  label="New Password"
                  field-class="text-xl"
                />
              </div>

              <div class="w-1/2 ml-1">
                <field
                  :disabled="loading"
                  :has-error="hasError('password_confirmation')"
                  :errors="getErrorFor('password_confirmation')"
                  v-model="form.password_confirmation"
                  required
                  class="mb-4"
                  type="password"
                  field-class="text-xl"
                  label="New Password Confirmation"
                />
              </div>
            </div>
          </div>

          <div class="px-4 py-3">
            <field
              :disabled="loading"
              :has-error="hasError('current_password')"
              :errors="getErrorFor('current_password')"
              v-model="form.current_password"
              required
              class="mb-4"
              type="password"
              field-class="text-xl"
              label="Current Password"
              instruction="Enter your current password to confirm password action"
            />

            <switch-field
              v-model="form.logoutOtherDevices"
              class="mb-4"
              label="Logout other devices after password change"
            />

            <switch-field
              v-model="form.reLogin"
              label="Re-login after password change"
            />
          </div>

          <div class="border-t px-4 py-3">
            <the-button
              :loading="loading"
              @click="change()"
              type="info"
              label="Change Password"
            />

            <the-button
              :disabled="loading"
              @click="reset()"
              label="Reset"
            />
          </div>
        </div>
      </error-manager>
    </template>

    <user-profile-sidebar slot="sidebar" />
  </page-layout>
</template>

<script>
import profile from '../mixin/profile'
import SwitchField from './SwitchField'
import ErrorManager from './ErrorManager'
import UserProfileSidebar from './UserProfileSidebar'
import UpcomingEventsWidget from './UpcomingEventsWidget'

export default {
  mixins: [
    profile
  ],

  components: {
    SwitchField,
    ErrorManager,
    UserProfileSidebar,
    UpcomingEventsWidget
  },

  data () {
    return {
      error: null,
      loading: false,
      form: this.empty()
    }
  },

  methods: {
    change () {
      this.toggleLoading(true)
      this.$http.route('account.password.update')
        .post(this.form)
          .then(({ data: { message } }) => {
            this.$bus.emit('successful', { message })

            if (this.form.reLogin) {
              location.reload(true)
            }

            this.reset()
            this.toggleLoading(false)
          })
          .catch(error => {
            this.error = error.response.data
            this.toggleLoading(false)
          })
    },

    toggleLoading (loading) {
      this.loading = loading
      if (this.loading) {
        this.$progress.start()
      } else {
        this.$progress.done()
      }
    },

    empty () {
      return {
        password: '',
        password_confirmation: '',
        current_password: '',
        logoutOtherDevices: false,
        reLogin: false
      }
    },

    reset () {
      this.error = null
      this.form = this.empty()
    }
  }
}
</script>

