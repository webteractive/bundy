<template>
  <modal
    v-if="unscheduled"
    :enable-close-button="false"
  >
    <div class="bg-gray-100 w-screen h-screen md:h-auto md:w-500 relative z-20 p-6 shadow rounded">
      <h2 class="text-2xl mb-4">Setup Schedules</h2>

      <hr class="border-b border-dotted m-0 mb-4" />

      <field
        v-for="(value, name) in form"
        :key="name"
        :label="name.capitalize()"
        :select-options="schedules"
        v-model="form[name]"
        type="select"
        class="mb-6"
      />

      <btn
        label="Set my schedules, please."
        class="bg-blue-500 text-white border-blue-600 border-b-2 rounded hover:bg-blue-600 hover:border-blue-700"
        @click.native="save()"
      />
    </div>
  </modal>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      error: null,
      form: {
        monday: 5,
        tuesday: 5,
        wednesday: 5,
        thursday: 5,
        friday: 5,
        saturday: 6,
      }
    }
  },

  computed: {
    ...mapGetters({
      unscheduled: 'user/unscheduled'
    }),

    schedules () {
      const schedules = this.$store.getters.schedules
      return schedules.map(schedule => {
        return {
          value: schedule.id,
          text: `${schedule.starts_at} - ${schedule.ends_at}`
        }
      })
    }
  },

  methods: {
    save () {
      this.$http.post(BUNDY.apis.schedules.update, this.form)
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

