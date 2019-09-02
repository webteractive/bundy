<template>
  <div
    :class="{
      'text-gray-600': leave.archived && leave.today === false,
    }"
    class="relative p-4 pl-24 border-b min-h-24 hover:bg-gray-100"
  >
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
        'bg-blue-500 text-blue-100': leave.today,
        'bg-green-500 text-green-100': leave.upcoming,
        'bg-gray-300 text-gray-600': leave.archived && leave.today === false,
      }]"
    >
      <fa icon="calendar" />
    </div>

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
    </h3>

    <div class="text-xl leading-none mb-2">
      <span v-text="formatDate(leave.starts_on, 'MMMM DD, YYYY')" />
      <span v-if="leave.duration > 1">&mdash;</span>
      <span  v-if="leave.duration > 1" v-text="formatDate(leave.ends_on, 'MMMM DD, YYYY')" />
    </div>

    <p v-text="leave.description" class="mb-1" />

    <div class="mb-1">
      <stats-item label="Duration" :value="`${leave.duration} ${leave.duration === 1 ? 'day' : 'days'}`" />
      <stats-item 
        v-if="leave.upcoming"
        label="Starts"
      >
        <live-date :date="leave.starts_on" slot="value" />
      </stats-item>

      <stats-item label="Status">
        <template slot="value">
          <capsule v-if="leave.status === -1" type="info" label="Rejected" />
          <capsule v-if="leave.status === 0" type="warning" label="Pening for approval" />
          <capsule v-if="leave.status === 1" type="success" label="Approved" />
          <capsule v-if="leave.status === 2" type="danger" label="Cancelled" />
        </template>
      </stats-item>
    </div>

    <div class="leave-status">
      
    </div>

    <drop-down
      v-if="leave.upcoming && unmanageable"
      :menu="menu"
      class="absolute right-4 top-4 z-20 text-black"
    />
  </div>
</template>

<script>
import Capsule from './Capsule'
import DropDown from './DropDown'
import StatsItem from './StatsItem'
import formatDate from 'date-fns/format'

export default {
  props: {
    leave: {
      type: Object,
      required: true
    },

    manageable: {
      type: Boolean,
      default: false
    }
  },

  components: {
    Capsule,
    DropDown,
    StatsItem,
  },

  computed: {
    menu () {
      return [
        ['cancel', 'Cancel'],
        ['edit', 'Edit']
      ]
    },

    unmanageable () {
      return ! this.manageable
    }
  },

  methods: {
    formatDate
  }
}
</script>