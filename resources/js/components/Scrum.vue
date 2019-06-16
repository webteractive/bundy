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
          <field
            type="items"
            id="yesterday"
            placeholder="What did you do yesterday?"
            v-model="form.yesterday"
          />
        </div>

        <div class="mb-4" v-if="todayIsNotMonday">
          <label class="block mb-1" for="blockers">Blockers</label>
          <field
            type="items"
            id="blockers"
            placeholder="What did stop you yesterday?"
            v-model="form.blockers"
          />
        </div>

        <div>
          <label class="block mb-1" for="today">Today</label>
          <field
            id="today"
            type="items"
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
          label="Close"
          class="bg-gray-300 text-black border-gray-400 hover:bg-gray-400 hover:border-gray-500"
        />
      </div>
    </div>
  </modal>
</template>

<script>
import merge from 'lodash.merge'
import { mapGetters } from 'vuex'

export default {
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
      shown: 'scrum/shown',
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

  watch: {
    shown () {
      if (this.scrum !== null) {
        const { yesterday, blockers, today } = this.scrum
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
      let api = BUNDY.apis.scrum.store

      if (this.scrum !== null) {
        api = `${BUNDY.apis.scrum.update}/${this.scrum.id}`
      }

      this.$http.post(api, this.form)
        .then(({ data: { user } }) => {
          this.$store.dispatch('user/hydrate', user)
          this.$bus.emit('stream.refresh')
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

