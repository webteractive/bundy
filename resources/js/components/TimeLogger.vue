<template>
  <bundy
    v-slot="{ formatter, needsToLoggedInToday }"
  >
    <modal
      v-if="needsToLoggedInToday && scheduled"
      :enable-close-button="false"
    >
      <div class="bg-gray-100 rounded border-b-2 border-gray-200 p-4 w-380 z-30">
        <h2 class="text-2xl mb-4">Time In</h2>
        
        <hr class="border-b border-dotted m-0 mb-4" />

        <p class="mb-6 leading-snug italic">You haven't log in yet, click the button below to log your time.</p>
        <button
          type="button"
          @click="save()"
          class="`
            block w-full bg-blue-500 text-white rounded border-b-2 border-blue-600 py-3 px-4
            hover:bg-blue-600 hover:border-blue-700
          `"
        >
          Log my time now (<span class="font-bold" v-text="formatter('hh:MM:s A')" />)
        </button>
      </div>
    </modal>
  </bundy>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  data () {
    return {
      error: null
    }
  },

  computed: {
    ...mapGetters({
      scheduled: 'user/scheduled'
    })
  },

  methods: {
    save () {
      this.$http.post(BUNDY.apis.logs.store)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
        })
        .catch(error => {
          this.error = error.response.data
        })
    }
  }
}
</script>
