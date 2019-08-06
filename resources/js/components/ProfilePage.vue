<template>
  <page-layout>
    <template slot="content">
      <div class="relative mb-6">
        
        <div class="relative h-64 bg-gray-400 overflow-hidden z-10">
          <img
            v-if="cover"
            :src="cover"
            class="object-cover h-64 w-full"
          />
          <media-button
            v-if="editable"
            @click="toggleFileUploader(true, 'cover')"
            title="Update cover photo"
            class="absolute inset-0 opacity-50 text-white cursor-pointer hover:bg-black"
          />
        </div>

        <div class="relative z-20">
          <user-photo
            :user="profile"
            class="absolute left-4 bottom-0 border-4 border-white z-20 text-5xl"
          >
            <media-button
              @click="toggleFileUploader(true, 'photo')"
              slot="extra"
              title="Update profile photo"
              class="absolute inset-0 opacity-50 text-white cursor-pointer hover:bg-black"
            />
          </user-photo>

          <div class="flex justify-end items-center bg-white px-4 py-3">
            <warp
              v-if="editable"
              :to="['edit_profile']"
              :class="`
                bg-white text-blue-500 px-8 py-2 border border-blue-500
                hover:bg-blue-500 hover:text-white
              `"
              label="Edit Profile"
            />
          </div>
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
        :tabs="tabs"
        :tab="defaultTab"
        v-slot="{ active }"
        @change="navigate"
      >
        <component :is="componentize(active)" />
      </tab>

      <portal to="modal">
        <file-uploader
          :collection="fileUploaderTarget"
          v-if="fileUploaderShown"
          @close="toggleFileUploader(false, null)"
        />
      </portal>
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
import MediaButton from './MediaButton'
import ProfileWall from './ProfileWall'
import ProfileLogs from './ProfileLogs'
import StatusWidget from './StatusWidget'
import FileUploader from './FileUploader'
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
    MediaButton,
    ProfileWall,
    ProfileLogs,
    StatusWidget,
    FileUploader,
    ProfileLeaves,
    ProfileScrums,
    SchedulesWidget,
    UserProfileSidebar,
    UpcomingEventsWidget
  },

  data () {
    return {
      fileUploaderTarget: null,
      fileUploaderShown: false
    }
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
    },

    tabs () {
      return [
        ['wall', 'Wall'],
        ['with_logs', 'Time Logs'],
        ['with_scrums', 'Scrums'],
        ['with_leaves', 'Leaves']
      ]
    },

    defaultTab () {
      const inner = this.$store.getters['nav/inner']
      return typeof inner === 'undefined' || inner === null ? 'with_logs' : inner
    },

    cover () {
      if (typeof this.profile.cover === 'undefined' || this.profile.cover === null) {
        return null
      }

      return this.profile.cover.banner
    }
  },

  methods: {
    hasProperty (property) {
      if (this.profile === null) {
        return false
      }

      const value = this.profile[property]

      return typeof value !== 'undefined' && value !== null
    },

    componentize (page) {
      return `profile-${page.replace('with_', '')}`
    },

    navigate (tab) {
      this.$store.dispatch('nav/navigate', {
        page: 'profile',
        identifier: this.profile.username,
        inner: tab === 'wall' ? null : tab
      })
    },

    toggleFileUploader (shown, target) {
      this.fileUploaderShown = shown
      this.fileUploaderTarget = target
    }
  }
}
</script>

