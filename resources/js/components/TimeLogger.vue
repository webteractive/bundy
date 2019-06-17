<template>
  <bundy v-slot="{ formatter, needsToLoggedInToday }">
    <modal
      v-if="needsToLoggedInToday && scheduled"
      :enable-close-button="false"
    >
      <div class="bg-white border-b-2 border-gray-200 w-380 z-30">
        <ct>Time In</ct>
        
        <div class="px-4 py-6">
          <p class="text-xl leading-snug italic">You haven't clocked in your time yet, click the button below to do so.</p>
        </div>

        <div class="px-4 py-3 border-t">
          <button
            type="button"
            @click="save()"
            :class="`
              bg-blue-500 w-full border-blue-600 text-white py-3 px-4
              hover:bg-blue-600 hover:border-blue-700
            `"
          >
            Clock my time now (<span class="font-bold" v-text="formatter('hh:MM:ss A')" />)
          </button>
        </div>
      </div>
    </modal>
  </bundy>
</template>

<script>
import { mapGetters } from 'vuex'

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
          this.$bus.emit('stream.refresh')
        })
        .catch(error => {
          this.error = error.response.data
        })
    }
  }
}
</script>
