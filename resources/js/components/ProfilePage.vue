<template>
  <page-layout>
    <template v-if="profile" slot="content">
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
              v-if="editable"
              @click="toggleFileUploader(true, 'photo')"
              slot="extra"
              title="Update profile photo"
              class="absolute inset-0 opacity-50 text-white cursor-pointer hover:bg-black"
            />
          </user-photo>

          <div class="flex justify-end items-center bg-white px-4 py-3">
            <router-link
              v-if="editable"
              :class="`
                bg-white text-blue-500 px-8 py-2 border border-blue-500
                rounded-full hover:bg-blue-500 hover:text-white
              `"
              to="/profile/edit"
              v-text="`Edit Profile`"
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

        <div v-if="profile.links">
          <a
            v-for="(link, index) in profile.links"
            :key="`link-${index}`"
            :href="link"
            :title="`Visit ${link}`"
            target="_blank"
            class="text-blue-500 mr-1 inline-flex items-center hover:underline hover:text-blue-600"
          >
            <fa icon="link" />
            <span v-text="link" class="ml-1" />
          </a>
        </div>
      </div>

      <div class="relative">
        <div class="flex border-b border-gray-400">
          <router-link
            v-if="editable"
            :to="`/profile/${profile.username}`"
            exact
            tag="button"
            active-class="border-blue-500 text-blue-500"
            class="capitalize py-4 outline-none flex-1 font-bold border-b-2 border-transparent text-gray-700 hover:bg-gray-100 hover:text-blue-500 focus:outline-none"
          >
            Wall
          </router-link>

          <router-link
            v-for="[route, label] in tabs"
            :key="route"
            :to="route"
            v-text="label"
            tag="button"
            active-class="border-blue-500 text-blue-500"
            class="capitalize py-4 outline-none flex-1 font-bold border-b-2 border-transparent text-gray-700 hover:bg-gray-100 hover:text-blue-500 focus:outline-none"
          />
        </div>
        
        <router-view />
      </div>

      <portal to="modal">
        <file-uploader
          :collection="fileUploaderTarget"
          v-if="fileUploaderShown"
          @close="toggleFileUploader(false, null)"
        />
      </portal>
    </template>

    <div v-else slot="content">Loading</div>


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
import { http } from '../module/http'
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

const fetchProfile = username => {
  return http.route('employee.show', { username }).get()
}

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
      const { username } = this.profile
      
      return [
        [`/profile/${username}/logs`, 'Time Logs'],
        [`/profile/${username}/scrums`, 'Scrums'],
        [`/profile/${username}/leaves`, 'Leaves']
      ]
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

    toggleFileUploader (shown, target) {
      this.fileUploaderShown = shown
      this.fileUploaderTarget = target
    },

    hydrate (data) {
      this.$store.dispatch('profile/hydrate', data.user)
    }
  },

  beforeRouteEnter (to, from, next) {
    fetchProfile(to.params.username)
      .then(({ data }) => {
        next(vm => vm.hydrate(data))
      })
  },

  beforeRouteUpdate (to, from, next) {
    fetchProfile(to.params.username)
      .then(({ data }) => {
        this.hydrate(data)
        next()
      })
  }
}
</script>

