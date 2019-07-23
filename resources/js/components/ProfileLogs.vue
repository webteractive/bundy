<template>
  <paginator
    :payload="logs"
    v-slot="{
      items,
      pagination
    }"
  >

    <div
      v-for="log in items"
      :key="log.id"
      :class="`
        p-4
        pl-24
        border-b
        min-h-24
        relative
      `"
    >
      <div
        :class="`
          h-16
          w-16
          flex
          top-4
          left-4
          text-4xl
          absolute
          text-white
          bg-gray-500
          items-center
          justify-center
        `"
      >
        <fa icon="clock" />
      </div>

      <h3 class="mb-2">
        <span
          v-text="formatDate(log.started_at, 'MMMM DD, YYYY')"
          class="font-bold"
        />
      </h3>
      <p class="mb-2">Your are early/on time/late</p>
      <div>
        <div>Time rendered: N hours</div>
        <div>Disputed: Yep, Lorem ipsum sit dolor amit</div>
      </div>

      <drop-down
        :menu="menu"
        class="absolute right-4 top-4 z-20"
      />
    </div>
  </paginator>
</template>

<script>
import DropDown from './DropDown'
import { mapGetters } from 'vuex'
import Paginator from './Paginator'
import formatDate from 'date-fns/format'

export default {
  components: {
    DropDown,
    Paginator
  },

  computed: {
    ...mapGetters({
      profile: 'profile/details',
      logs: 'profile/logs/pagination',
    }),

    menu () {
      return [
        ['dispute', 'Dispute'],
        ['view', 'View Logs'],
      ]
    }
  },

  methods: {
    formatDate,

    fetch () {
      this.$http.route('profile.logs', {user: this.profile.id})
        .get()
          .then(({ data }) => {
            this.$store.dispatch('profile/logs/paginate', data)
          })
    }
  },

  created () {
    this.fetch()
  }
}
</script>
