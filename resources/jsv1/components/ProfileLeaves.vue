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
      <profile-leave-item
        v-for="leave in items"
        :key="leave.id"
        :leave="leave"
      />
    </paginator>

    <portal to="modal">
      <leave-request-form
        v-if="shown"
        @close="toggleForm(false),fetch()"
      />
    </portal>

  </div>
</template>

<script>
import Capsule from './Capsule'
import DropDown from './DropDown'
import Paginator from './Paginator'
import profile from '../mixin/profile'
import formatDate from 'date-fns/format'
import ProfileLeaveItem from './ProfileLeaveItem'
import LeaveRequestForm from './LeaveRequestForm'

export default {
  mixins: [
    profile
  ],

  components: {
    Capsule,
    DropDown,
    Paginator,
    ProfileLeaveItem,
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
