<template>
  <stream-layout>
    <div
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
      `, {
        'bg-red-500 text-white': content.late,
        'bg-blue-500 text-white': content.on_time,
        'bg-green-500 text-white': content.early_bird,
      }]"
    >
      <fa icon="clock" />
    </div>

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
      <router-link
        v-text="content.user.name"
        :to="`/profile/${content.user.username}`"
        class="text-blue-500 tracking-wide cursor-pointer hover:underline hover:text-blue-600"
      />
      has clocked in at
      <span
        :class="{
          'hover:underline': content.late || content.early_bird
        }"
        :title="timeTooltip"
        v-text="time"
        class="font-bold"
      />.
    </p>

    <drop-down
      :menu="menu"
      @view="open()"
      @dispute="dispute()"
      class="absolute right-4 top-3 z-20"
    />
  </stream-layout>
</template>

<script>
import DropDown from './DropDown'
import StreamItem from './StreamItem'
import profile from '../mixin/profile'
import formatDate from 'date-fns/format'

export default {
  extends: StreamItem,

  components: {
    DropDown
  },

  mixins: [
    profile
  ],

  computed: {
    time () {
      return formatDate(this.content.started_at, 'hh:mm A')
    },

    menu () {
      return [
        ['dispute', 'Dispute'],
        ['view', 'View Logs']
      ]
    },

    timeTooltip () {
      if (this.content.late) {
        return `${this.content.tardiness} late`
      }

      if (this.content.early_bird) {
        return `${this.content.punctuality} early`
      }

      return null
    }
  },

  methods: {
    open () {
      this.$bus.emit('timeLog.open', this.content)
    },

    dispute () {
      this.$bus.emit('timeLog.dispute', this.content)
    }
  }
}
</script>
