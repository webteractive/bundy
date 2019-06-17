<template>
  <page-layout>
    <template slot="content">
      <ct>Edit Profile</ct>

      <div class="px-4 py-6">
        <div class="flex">
          <div class="w-1/2 mr-2">
            <div class="mb-4">
              <label class="block mb-1" for="first_name">
                First Name
                <span class="text-red-500">*</span>
              </label>
              <field
                v-model="form.first_name"
                type="text"
                id="first_name"
                class="text-xl"
              />
            </div>
          </div>

          <div class="w-1/2 ml-1">
            <div class="mb-4">
              <label class="block mb-1" for="last_name">
                Last Name
                <span class="text-red-500">*</span>
              </label>
              <field
                v-model="form.last_name"
                type="text"
                id="last_name"
                class="text-xl"
              />
            </div>
          </div>
        </div>

        <div class="flex">
          <div class="w-1/2 mr-2">
            <div class="mb-4">
              <label class="block mb-1" for="username">
                Username
                <span class="text-red-500">*</span>
              </label>
              <field
                v-model="form.username"
                type="text"
                id="username"
                class="text-xl"
              />
            </div>
          </div>

          <div class="w-1/2 ml-1">
            <div class="mb-4">
              <label class="block mb-1" for="alias">Alias</label>
              <field
                v-model="form.alias"
                type="text"
                id="alias"
                class="text-xl"
              />
            </div>
          </div>
        </div>

        <div>
          <label class="block mb-1" for="bio">Bio / About</label>
          <field
            v-model="form.bio"
            id="bio"
            type="textarea"
          />
        </div>
      </div>

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
      }
    }
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  },

  methods: {
    save () {
      this.$http.post(BUNDY.apis.profile.update, this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
        })
    },

    fill () {
      const {
        bio,
        alias,
        username,
        last_name,
        first_name,
      } = this.user

      this.form.bio = bio
      this.form.alias = alias
      this.form.username = username
      this.form.last_name = last_name
      this.form.first_name = first_name
    }
  },

  created () {
    this.fill()
  }
}
</script>

