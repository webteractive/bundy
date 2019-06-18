<template>
  <stream-layout class="cursor-pointer" @click="open()">
    <user-photo
      :user="{name: 'Bundy'}"
      class="absolute left-4 top-4 text-2xl"
    />
    
    <stream-head
      :content="content"
      :show-username="false"
    >
      <template slot="name">
        <span
          v-text="`Bundy`"
          class="font-bold"
        />

        <span class="ml-1">
          <fa icon="bullhorn" />
        </span>
      </template>
    </stream-head>

    <p>
      <span
        v-text="content.user.name"
        @click.stop="showProfile(content.user)"
        class="text-blue-500 tracking-wide cursor-pointer hover:underline hover:text-blue-600"
      />
      has clocked in at <span v-text="time" class="font-bold" />.
    </p>
  </stream-layout>
</template>

<script>
import StreamItem from './StreamItem'
import profile from '../mixin/profile'
import formatDate from 'date-fns/format'

export default {
  extends: StreamItem,

  mixins: [
    profile
  ],

  computed: {
    time () {
      return formatDate(this.content.started_at, 'hh:mm A')
    }
  },

  methods: {
    open () {
      this.$bus.emit('timeLog.open', this.content)
    }
  }
}
</script>
