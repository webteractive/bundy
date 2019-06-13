<template>
  <page-layout>
    <template slot="content">
      <div class="h-64 bg-gray-400 relative mb-6">
        <user-photo size="32" class="absolute left-4 bottom-0 border-4 border-white z-20" />
        <div class="flex justify-end items-center bg-white absolute left-0 bottom-0 right-0 p-4">
          <button class="bg-white text-blue-500 px-8 py-2 border border-blue-500 rounded-full hover:bg-blue-500 hover:text-white">
            Edit Profile
          </button>
        </div>
      </div>

      <div class="px-4 pb-4">
        <h2 class="text-xl font-bold" v-text="profile.name" />
        <h3 class="text-gray-500 mb-4" v-text="`@${profile.username}`" />
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae asperiores doloribus architecto, cupiditate, tempora aperiam facilis reiciendis distinctio nam iusto impedit veritatis velit iure inventore, fugiat commodi non necessitatibus sequi?</p>

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
        <div class="p-4">
          Content goes here
        </div>
      </tab>
    </template>

    <template slot="sidebar">
      <div class="h-32 bg-white mb-3">
        <ct>You are late today</ct>
      </div>
    </template>
  </page-layout>
</template>

<script>
export default {
  computed: {
    profile () {
      return this.$store.getters['profile/details']
    },

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

