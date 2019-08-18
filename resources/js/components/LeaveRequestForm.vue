<template>
  <modal disable-close-button>
    <div class="bg-white w-screen h-screen md:w-500 md:h-auto relative z-20 shadow">
      <ct>Request Leave</ct>
      <error-manager
        :error="error"
        v-slot="{
          hasError,
          getErrorFor
        }"
      >
        <div class="px-4 py-3">

          <field
            :disabled="loading"
            :has-error="hasError('dates')"
            :errors="getErrorFor('dates')"
            v-model="form.dates"
            required
            class="mb-4"
            type="dates"
            label="Leave Dates"
            field-class="text-xl"
          />

          <field
            :disabled="loading"
            :has-error="hasError('description')"
            :errors="getErrorFor('description')"
            v-model="form.description"
            required
            type="textarea"
            label="Reason"
            field-class="text-xl"
          />
        </div>
      </error-manager>

      <div class="px-4 py-3 border-t">
        <the-button
          :loading="loading"
          @click="store()"
          type="info"
          label="Send Leave Request"
        />

        <the-button
          :disabled="loading"
          @click="close()"
          label="Cancel"
        />
      </div>
    </div>
  </modal>
</template>

<script>
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
        dates: null,
        description: ''
      }
    }
  },

  methods: {
    toggleLoading (loading) {
      this.loading = loading

      if (this.loading) {
        this.$progress.start()
      } else {
        this.$progress.done()
      }
    },

    empty () {
      return {
        starts_on: null,
        ends_on: null,
        description: ''
      }
    },

    store () {
      this.toggleLoading(true)
      this.$http.route('profile.leave.store')
        .post(this.form)
          .then(({ data: { message } }) => {
            this.$bus.emit('successful', { message })
            this.toggleLoading(false)
            this.$emit('reload')
            this.close()
          })
          .catch(error => {
            this.error = error.response.data
            this.toggleLoading(false)
          })
    },

    close () {
      this.form = this.empty()
      this.$emit('close')
    }
  }
}
</script>