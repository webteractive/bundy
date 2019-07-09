<template>
  <page-layout>
    <template slot="content">
      <div class="h-64 bg-gray-400 relative mb-6">
        <user-photo
          :user="profile"
          size="32"
          class="absolute left-4 bottom-0 border-4 border-white z-20 text-5xl"
        />
        <div class="flex justify-end items-center bg-white absolute left-0 bottom-0 right-0 p-4">
          <warp
            v-if="editable"
            :to="['edit-profile']"
            :class="`
              bg-white text-blue-500 px-8 py-2 border border-blue-500
              hover:bg-blue-500 hover:text-white
            `"
          >
            Edit Profile
          </warp>
        </div>
      </div>

      <div class="px-4 pb-4">
        <h2 class="text-xl font-bold">
          <span v-text="profile.name" />
          <span v-if="profile.alias">({{ profile.alias }})</span>
        </h2>
        <h3 class="text-gray-500 mb-4" v-text="`@${profile.username}`" />
        <bio v-if="profile.bio" :bio="profile.bio" />

        <ul v-if="stats.length > 0">
          <li 
            v-for="(stat, index) in stats"
            :key="index"
            v-text="stat"
          />
        </ul>

      </div>

      <tab
        :tabs="['wall', 'logs', 'scrums', 'leaves']"
        v-slot="{ active }"
        tab="wall"
      >
        <component :is="`profile-${active}`" />
      </tab>
    </template>

    <template slot="sidebar">
      <user-profile-sidebar v-if="editable" />
      <schedules-widget
        v-else
        class="mb-4"
      />
      <upcoming-events-widget />
    </template>
  </page-layout>
</template>

<script>
import Bio from './Bio'
import profile from '../mixin/profile'
import ProfileWall from './ProfileWall'
import ProfileLogs from './ProfileLogs'
import StatusWidget from './StatusWidget'
import ProfileLeaves from './ProfileLeaves'
import ProfileScrums from './ProfileScrums'
import SchedulesWidget from './SchedulesWidget'
import UserProfileSidebar from './UserProfileSidebar'
import UpcomingEventsWidget from './UpcomingEventsWidget'

export default {
  mixins: [
    profile
  ],

  components: {
    Bio,
    ProfileWall,
    ProfileLogs,
    StatusWidget,
    ProfileLeaves,
    ProfileScrums,
    SchedulesWidget,
    UserProfileSidebar,
    UpcomingEventsWidget
  },

  computed: {
    stats () {
      let items = []
      
      if (this.hasProperty('address')) {
        items.push(this.profile.address)
      }

      if (this.hasProperty('dob')) {
        items.push(this.profile.dob)
      }

      return items
    }
  },

  methods: {
    hasProperty (property) {
      if (this.profile === null) {
        return false
      }

      const value = this.profile[property]

      return typeof value !== 'undefined' && value !== null
    }
  }
}
</script>

