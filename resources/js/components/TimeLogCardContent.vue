<template>
  <div class="bundy-says">
    <user-photo
      :user="{name: 'Bundy'}"
      class="absolute left-4 top-4 text-2xl"
    />

    <div class="p-0">
      <h3 class="mb-2">
        <span class="text-sm text-base font-bold">Bundy</span>
        
        <span class="text-black">
          <fa icon="bullhorn" />
        </span>

        <span class="text-sm text-black">·</span>

        <live-date
          :date="content.stream_date"
          class="text-sm text-gray-500 hover:underline"
        />
      </h3>

      <p>
        <span
          v-text="content.user.name"
          @click="showProfile(user)"
          class="text-blue-500 font-bold tracking-wide cursor-pointer hover:underline hover:text-blue-600"
        />
        have clocked in at <span v-text="time" class="font-bold" />.
      </p>
    </div>
  </div>
</template>

<script>
import UserPhoto from './UserPhoto'
import profile from '../mixin/profile'
import formatDate from 'date-fns/format'

export default {
  props: {
    content: {
      required: true
    }
  },

  mixins: [
    profile
  ],

  components: {
    UserPhoto
  },

  computed: {
    time () {
      return formatDate(this.content.started_at, 'hh:mm A')
    }
  }
}
</script>

