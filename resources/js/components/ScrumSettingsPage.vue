<template>
  <page-layout>
    <template slot="content">
      <ct>Scrum Settings</ct>

      <div class="px-4 py-3 border-b">
        <h4 class="mb-2 font-bold"><fa :icon="['fab', 'slack']" /> Slack Integration</h4>
        <p v-if="slackIsConfigured" class="mb-1">Bundy is already authorize post on your behalf.</p>
        <p v-else class="mb-1">Authorize Bundy to post on your behalf to Slack.</p>
        <the-button
          @click="authorize()"
          type="info"
        >
          <span v-text="slackButtonLabel" />
        </the-button>
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

  computed: {
    ...mapGetters({
      user: 'user/details'
    }),

    slack () {
      return this.user.slack
    },

    slackIsConfigured () {
      return this.slack !== null
    },

    slackButtonLabel () {
      return this.slackIsConfigured ? 'Re-authorize Bundy' : 'Authorize Bundy'
    }
  },

  methods: {
    authorize () {
      this.$http.route('slack.authorize')
        .post()
          .then(({ data: { authorization_url } }) => {
            location.href = authorization_url
          })
    }
  }
}
</script>

