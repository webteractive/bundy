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
                  :has-error="hasError('password')"
                  :errors="getErrorFor('password')"
                  v-model="form.password"
                  required
                  class="mb-4"
                  label="New Password"
                  field-class="text-xl"
                />
              </div>

              <div class="w-1/2 ml-1">
                <field
                  :has-error="hasError('password_confirmation')"
                  :errors="getErrorFor('password_confirmation')"
                  v-model="form.password_confirmation"
                  required
                  class="mb-4"
                  field-class="text-xl"
                  label="New Password Confirmation"
                />
              </div>
            </div>
          </div>

          <div class="px-4 py-3">
            <field
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
          </div>

          <div class="border-t px-4 py-3">
            <the-button
              @click="change()"
              type="info"
              label="Change Password"
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
import ErrorManager from './ErrorManager'
import UserProfileSidebar from './UserProfileSidebar'
import UpcomingEventsWidget from './UpcomingEventsWidget'

export default {
  mixins: [
    profile
  ],

  components: {
    ErrorManager,
    UserProfileSidebar,
    UpcomingEventsWidget
  },

  data () {
    return {
      error: null,
      form: {
        password: '',
        password_confirmation: '',
        current_password: ''
      }
    }
  },

  methods: {
    change () {
      this.$http.route('account.password.update')
        .post(this.form)
          .then(({ data: { message } }) => {
            this.$bus.emit('successful', { message })
          })
          .catch(error => {
            this.error = error.response.data
          })
    }
  }
}
</script>

