<template>
  <modal
    v-if="shown"
    backdrop
    @close="close()"
  >
    <div class="bg-white w-screen h-screen md:h-auto md:w-800 relative z-20 shadow">
      <ct>
        <span v-text="name" />
        <span>logs for</span>
        <span
          :title="formattedDate"
          v-text="date"
        />
      </ct>

      <div class="py-3 max-h-320 overflow-y-auto">
        <div
          v-for="(item, index) in logs"
          :key="item.id"
          class="italic hover:bg-gray-100 px-4 py-1"
        >
          <span class="font-bold">{{ (item.user_id === user.id) ? 'You' : item.user.first_name }}</span>
          <span>logged in {{ index > 0 ? 'back ' : ' ' }}at</span>
          <span class="font-bold">{{ formatDate(item.started_at, 'hh:mm A') }}</span>
          <span v-if="item.ended_at !== null">and logged out at <span class="font-bold" v-text="formatDate(item.ended_at, 'hh:mm A')" /></span>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import isToday from 'date-fns/is_today'
import formatDate from 'date-fns/format'

export default {
  data () {
    return {
      details: null,
      logs: []
    }
  },

  computed: {
    user () {
      return this.$store.getters['user/details']
    },

    shown () {
      return this.details !== null
    },

    author () {
      if (this.shown) {
        return this.details.user_id
      }

      return 0
    },

    fromUser () {
      if (this.shown) {
        return this.author === this.user.id
      }

      return false
    },

    name () {
      if (this.shown) {
        const { user: { name } } = this.details
        return this.fromUser ? 'Your' : `${name}'s`
      }

      return null
    },

    formattedDate () {
      if (this.shown) {
        const { started_at } = this.details
        return formatDate(started_at, 'MMMM DD, YYYY')
      }

      return null
    },

    date () {
      if (this.shown) {
        const { started_at } = this.details
        return `${isToday(started_at) ? 'Today' : this.formattedDate}`
      }

      return null
    },

    filterDate () {
      if (this.shown) {
        const { started_at } = this.details
        return formatDate(started_at, 'YYYY-MM-DD')
      }

      return null
    }
  },

  methods: {
    formatDate,

    open (details) {
      this.details = details
      this.$nextTick(function() {
        this.fetch()
      })
    },

    close () {
      this.details = null
    },

    fetch () {
      this.$http.route('profile.logs.show', {date: this.filterDate, user: this.author})
        .get()
          .then(( { data }) => {
            this.logs = data
          })
    }
  },

  mounted () {
    this.$bus.on('timeLog.open' , this.open) 
  }
}
</script>
