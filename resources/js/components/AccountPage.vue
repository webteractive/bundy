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
                  :has-error="hasError('first_name')"
                  :errors="getErrorFor('first_name')"
                  v-model="form.first_name"
                  required
                  class="mb-4"
                  label="New Password"
                  field-class="text-xl"
                />
              </div>

              <div class="w-1/2 ml-1">
                <field
                  :has-error="hasError('last_name')"
                  :errors="getErrorFor('last_name')"
                  v-model="form.last_name"
                  required
                  class="mb-4"
                  label="New Password Confirmation"
                  field-class="text-xl"
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
              instruction="Enter your current password to confirm password change"
            />
          </div>

          <div class="border-t px-4 py-3">
            <the-button
              @click="save()"
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
    save () {

    }
  }
}
</script>

