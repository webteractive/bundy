<template>
  <modal
    v-if="shouldScrum"
    :enable-close-button="false"
  >
    <div class="bg-white w-screen h-screen md:h-auto md:w-500 relative z-20 shadow">
      <ct>{{ scrumed ? 'Edit' : 'Add' }} Scrum</ct>

      <div class="px-4 py-6">

        <div class="mb-4" v-if="todayIsNotMonday">
          <label class="block mb-1" for="yesterday">Yesterday</label>
          <items-field
            id="yesterday"
            placeholder="What did you do yesterday?"
            v-model="form.yesterday"
          />
        </div>

        <div class="mb-4" v-if="todayIsNotMonday">
          <label class="block mb-1" for="blockers">Blockers</label>
          <items-field
            id="blockers"
            placeholder="What did stop you yesterday?"
            v-model="form.blockers"
          />
        </div>

        <div>
          <label class="block mb-1" for="today">Today</label>
          <items-field
            id="today"
            placeholder="What will you do today?"
            v-model="form.today"
          />
        </div>
      </div>

      <div class="bg-gray-100 p-4 border-t">
        <btn
          :label="scrumed ? 'Save Changes' : 'Post Scrum'"
          @click.native="save()"
          class="bg-blue-500 text-white border-blue-600 hover:bg-blue-600 hover:border-blue-700"
        />

        <btn
          @click.native="close()"
          label="Cancel"
          class="bg-gray-300 text-black border-gray-400 hover:bg-gray-400 hover:border-gray-500"
        />
      </div>
    </div>
  </modal>
</template>

<script>
import { mapGetters } from 'vuex'
import ItemsField from './ItemsField'

export default {
  components: {
    ItemsField
  },

  data () {
    return {
      error: null,
      form: {
        today: [],
        yesterday: [],
        blockers: []
      }
    }
  },

  computed: {
    ...mapGetters({
      user: 'user/details',
      scrum: 'scrum/details',
      scrumed: 'user/scrumed',
      shouldScrum: 'scrum/shown',
      scheduled: 'user/scheduled',
      timeLogged: 'user/timeLogged',
    }),

    todayIsNotMonday () {
      return (new Date()).getDay() !== 1
    }
  },

  methods: {
    save () {
      this.$http.post(BUNDY.apis.scrum.store, this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
        })
        .catch(error => {
          this.error = error.response.data
        })
    },

    close () {
      this.$store.dispatch('scrum/close')
    }
  },

  mounted () {
    this.$store.dispatch('scrum/toggle', this.scheduled && this.timeLogged && ! this.scrumed)
  }
}
</script>

