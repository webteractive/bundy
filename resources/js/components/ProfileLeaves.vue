<template>
  <div class="profile-leaves">
    <div
      v-if="editable"
      class="px-4 py-2 bg-gray-100 text-right border-b"
    >
      <button
        v-text="`Request Leave`"
        @click="toggleForm(true)"
        type="button"
        class="bg-green-500 text-green-100 text-sm px-3 py-2 rounded-full leading-none hover:bg-green-600 hover:text-green-200"
      />
    </div>

    <paginator
      :payload="leaves"
      v-slot="{
        items,
        pagination
      }"
    >
      <div
        v-for="leave in items"
        :key="leave.id"
        class="p-4 pl-24 border-b min-h-24 relative"
      >
        <div
          v-if="editable"
          :class="[`
            h-16
            w-16
            flex
            top-4
            left-4
            text-4xl
            absolute
            items-center
            justify-center
            bg-green-500 text-green-100
          `]"
        >
          <fa icon="calendar" />
        </div>

        <user-photo
          v-else
          :user="leave.user"
          size="smaller"
          class="absolute left-4 top-4 text-2xl"
        />

        <h3 class="flex items-center mb-2">
          <span
            v-text="leave.user.name"
            class="font-bold"
          />

          <span 
            v-if="leave.user.username"
            v-text="`@${leave.user.username}`"
            class="text-sm text-gray-500 ml-1"
          />

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="leave.created_at"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />

          <span class="text-sm text-black ml-2">·</span>

          <live-date
            :date="leave.starts_on"
            class="text-sm text-gray-500 ml-2 hover:underline"
          />
        </h3>

        <div class="text-xl leading-none mb-2">
          <span v-text="formatDate(leave.starts_on, 'MMMM DD, YYYY')" />
          <span>&mdash;</span>
          <span v-text="formatDate(leave.ends_on, 'MMMM DD, YYYY')" />
        </div>

        <p v-text="leave.description" class="italic text-gray-700" />
      </div>
    </paginator>


    <portal to="modal">
      <leave-request-form
        v-if="shown"
        @close="toggleForm(false)"
      />
    </portal>

  </div>
</template>

<script>
import Paginator from './Paginator'
import profile from '../mixin/profile'
import formatDate from 'date-fns/format'
import LeaveRequestForm from './LeaveRequestForm'

export default {
  mixins: [
    profile
  ],

  components: {
    Paginator,
    LeaveRequestForm
  },

  data () {
    return {
      shown: false
    }
  },

  computed: {
    leaves () {
      return this.$store.getters['profile/leave/pagination']
    }
  },

  methods: {
    formatDate,

    toggleForm (shown) {
      this.shown = shown
    },

    fetch () {
      this.$http.route('profile.leaves', {username: this.profile.username})
        .get()
          .then(({ data }) => {
            this.$store.dispatch('profile/leave/paginate', data)
          })
    }
  },

  mounted () {
    this.fetch()
  }
}
</script>
