<template>
  <modal
    v-if="shown"
    disable-close-button
  >
    <error-manager
      :error="error"
      v-slot="{
        hasError,
        getErrorFor
      }"
    >
      <div class="bg-white w-screen h-screen md:h-auto md:w-500 relative z-20 shadow">
        <ct>{{ hasPostedScrum ? 'Edit' : 'Add' }} Scrum</ct>

        <div class="px-4 py-6">
          <div class="mb-4">
            <label class="block font-bold" for="yesterday">Yesterday</label>
            <p class="text-xs leading-none mb-2 italic">What did you do and accomplished yesterday?</p>
            <field
              :disabled="loading"
              :has-error="hasError('yesterday')"
              :errors="getErrorFor('yesterday')"
              v-model="form.yesterday"
              type="items"
              id="yesterday"
              placeholder="Type in your completed tasks or WIPs and hit the enter or return key"
            />
          </div>

          <div class="mb-4">
            <label class="block font-bold" for="blockers">Blockers</label>
            <p class="text-xs leading-none mb-2 italic">What did stop you for completing your tasks yesterday?<br/>Leave it empty if no blockers</p>
            <field
              :disabled="loading"
              :has-error="hasError('blockers')"
              :errors="getErrorFor('blockers')"
              v-model="form.blockers"
              type="items"
              id="blockers"
              placeholder="Type in your blockers and hit the enter or return key"
            />
          </div>

          <div>
            <label class="block mb-1 font-bold" for="today">
              Today
              <span class="text-red-500">*</span>
            </label>
            <p class="text-xs leading-none mb-2 italic">What will you do today?</p>
            <field
              :disabled="loading"
              :has-error="hasError('today')"
              :errors="getErrorFor('today')"
              v-model="form.today"
              id="today"
              type="items"
              placeholder="Type in your todos and hit the enter or return key"
            />
          </div>
        </div>

        <div class="bg-gray-100 p-4 border-t">
          <the-button
            :loading="loading"
            :label="hasPostedScrum ? 'Save Changes' : 'Post Scrum'"
            @click="save()"
            type="info"
          />
        
          <the-button
            :disabled="loading"
            @click="close()"
            label="Close"
          />
        </div>
      </div>
    </error-manager>
  </modal>
</template>

<script>
import merge from 'lodash.merge'
import { mapGetters } from 'vuex'
import ErrorManager from './ErrorManager'

export default {
  components: {
    ErrorManager
  },

  data () {
    return {
      error: null,
      loading: false,
      form: {
        today: [],
        yesterday: [],
        blockers: []
      }
    }
  },

  computed: {
    ...mapGetters({
      shown: 'scrum/shown',
      user: 'user/details',
      scrum: 'scrum/details',
      shouldScrum: 'scrum/shown',
      scheduled: 'user/scheduled',
      hasClockedIn: 'user/hasClockedIn',
      hasPostedScrum: 'user/hasPostedScrum',
    }),

    hasNotPostedScrum () {
      return this.hasPostedScrum === false
    }
  },

  watch: {
    shown () {
      if (this.scrum !== null) {
        const { yesterday, blockers, today } = JSON.parse(JSON.stringify(this.scrum))
        this.form.today = today
        this.form.blockers = blockers
        this.form.yesterday = yesterday
      } else {
        this.form.today = []
        this.form.blockers = []
        this.form.yesterday = []
      }
    }
  },

  methods: {
    save () {
      this.toggleLoading(true)
      this.$http.route('scrum.store')
        .post(this.form)
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$bus.emit('stream.refresh')
            this.toggleLoading(false)
            this.close()
          })
          .catch(error => {
            this.error = error.response.data
            this.toggleLoading(false)
          })
    },

    close () {
      this.$store.dispatch('scrum/close')
    },

    toggleLoading (loading) {
      this.loading = loading

      if (loading) {
        this.$progress.start()
      } else {
        this.$progress.done()
      }
    }
  },

  mounted () {
    this.$store.dispatch('scrum/toggle', this.scheduled && this.hasClockedIn && this.hasNotPostedScrum)
  }
}
</script>

