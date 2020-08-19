<template>
  <modal
    v-if="shown"
    disable-close-button
  >
    <error-manager 
      :error="error"
      v-slot="{
        hasError,
        hasErrors,
        getErrorFor
      }"
    >
      <div class="bg-white border-b-2 border-gray-200 w-380 z-30">
        <ct>Working Remote?</ct>

        <p class="m-4 pb-4 leading-snug border-b">
          Awwww man! You seem to be working remotely as you are accessing <span class="italic">(from <code class="font-mono text-sm text-red-700" v-text="ip" />)</span> Bundy outside. 
          Your time logs will still be logged but will be subjected to a review and approval.
        </p>

        <div class="px-4 mb-4">
          <field
            :has-error="hasError('reason')"
            :errors="getErrorFor('reason')"
            v-model="form.reason"
            required
            label="State your reason"
            type="textarea"
          />
        </div>

        <div class="px-4 py-3 border-t">
          <the-button
            @click="save()"
            type="info"
            label="Save"
          />
        </div>
      </div>
    </error-manager>
  </modal>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      error: null,
      form: {
        reason: ''
      }
    }
  },

  computed: {
    ...mapGetters({
      ip: 'ip',
      user: 'user/details',
      workingRemote: 'workingRemote',
    }),

    shown () {
      const { todays_working_remote_reason: entry, role_id } = this.user
      const isNotAdmin = role_id !== 1
      return this.workingRemote && (entry !== null && entry.reason.length === 0) && isNotAdmin
    }
  },

  methods: {
    save () {
      this.$progress.start()
      this.$http.route('workingRemote.update')
        .post(this.form)
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$progress.done()
          })
          .catch(error => {
            console.log(error)
            this.error = error.response.data
            this.$progress.done()
          })
    }
  }
}
</script>

