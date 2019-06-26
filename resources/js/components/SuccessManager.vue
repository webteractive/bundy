<template>
  <div
    v-if="messages.length > 0"
    class="relative -mt-2 mb-4"
  >
    <success-message
      v-for="item in messages"
      :key="item.id"
      :payload="item"
      @remove="remove"
    />
  </div>
</template>

<script>
import merge from 'lodash.merge'
import SuccessMessage from './SuccessMessage'

export default {
  components: {
    SuccessMessage
  },

  data () {
    return {
      messages: []
    }
  },

  methods: {
    push (payload) {
      this.messages.push(merge(payload, {
        id: (new Date()).getTime()
      }))
    },

    remove ({ id }) {
      this.messages.splice(this.messages.findIndex(message => message.id === id), 1)
    }
  },

  mounted () {
    this.$bus.on('successful', payload => this.push(payload))
  }
}
</script>
