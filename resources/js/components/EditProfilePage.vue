<template>
  <page-layout>
    <template slot="content">
      <ct>Edit Profile</ct>

      <error-manager
        :error="error"
        v-slot="{
          hasError,
          getErrorFor
        }"
      >
        <div class="px-4 py-6">
          <div class="flex">
            <div class="w-1/2 mr-2">
              <field
                :has-error="hasError('first_name')"
                :errors="getErrorFor('first_name')"
                v-model="form.first_name"
                required
                class="mb-4"
                label="First Name"
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
                label="Last Name"
                field-class="text-xl"
              />
            </div>
          </div>

          <div class="flex">
            <div class="w-1/2 mr-2">
              <field
                :has-error="hasError('username')"
                :errors="getErrorFor('username')"
                v-model="form.username"
                required
                class="mb-4"
                label="Username"
                field-class="text-xl"
              />
            </div>

            <div class="w-1/2 ml-1">
              <field
                :has-error="hasError('alias')"
                :errors="getErrorFor('alias')"
                v-model="form.alias"
                class="mb-4"
                label="Alias"
                field-class="text-xl"
              />
            </div>
          </div>

          <field
            :has-error="hasError('bio')"
            :errors="getErrorFor('bio')"
            v-model="form.bio"
            class="mb-4"
            label="Bio"
            type="textarea"
          />

          <field
            :has-error="hasError('links')"
            :errors="getErrorFor('links')"
            v-model="form.links"
            class="mb-4"
            label="Links"
            type="items"
            placeholder="Type in your links and hit enter or return key"
          />

          <hr class="-mx-4">

          <field
            :has-error="hasError('address')"
            :errors="getErrorFor('address')"
            v-model="form.address"
            class="mb-4"
            label="Address"
            type="textarea"
          />

          <field
            :has-error="hasError('contact_numbers')"
            :errors="getErrorFor('contact_numbers')"
            v-model="form.contact_numbers"
            class="mb-4"
            label="Contact Numbers"
            type="items"
            placeholder="Type in your contact numbers and hit enter or return key"
          />

        </div>
      </error-manager>

      <div class="border-t px-4 py-3">
        <btn
          label="Save Changes"
          @click.native="save()"
          class="bg-blue-500 text-white border-blue-600 hover:bg-blue-600 hover:border-blue-700"
        />

        <warp
          :to="['profile', user.username]"
          label="Back to Profile"
          class="px-4 py-2 border bg-gray-300 text-black border-gray-400 hover:bg-gray-400 hover:border-gray-500"
        />
      </div>
    </template>

    <user-profile-sidebar slot="sidebar" />
  </page-layout>
</template>

<script>
import { mapGetters } from 'vuex'
import UserProfileSidebar from './UserProfileSidebar'

export default {
  components: {
    UserProfileSidebar
  },

  data () {
    return {
      form: {
        first_name: '',
        last_name: '',
        username: '',
        alias: '',
        bio: '',
        address: '',
        links: [],
        contact_numbers: [],
      },
      error: null
    }
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  },

  methods: {
    save () {
      this.error = null
      this.$http.route('profile.update')
        .post(this.form)
          .then(({ data: { user, message } }) => {
            this.$store.dispatch('user/hydrate', user)
            this.$bus.emit('successful', { message })
          })
          .catch(error => {
            this.error = error.response.data
          })
    },

    fill () {
      const {
        bio,
        alias,
        links,
        address,
        username,
        last_name,
        first_name,
        contact_numbers,
      } = this.user

      this.form.bio = bio
      this.form.alias = alias
      this.form.address = address
      this.form.username = username
      this.form.last_name = last_name
      this.form.first_name = first_name
      this.form.links = this.resolveValueTo(links, [])
      this.form.contact_numbers = this.resolveValueTo(contact_numbers, [])
    },

    resolveValueTo (value, defaultValue) {
      if (typeof value === 'undefined' || value === null) {
        return defaultValue
      }

      return value
    }
  },

  created () {
    this.fill()
  }
}
</script>

