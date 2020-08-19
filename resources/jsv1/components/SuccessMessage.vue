<template>
  <div class="py-2 bg-green-700 text-white">
    <div class="container mx-auto flex items-center">
      <p class="flex-1" v-html="message" />
      <span
        v-html="`&times;`"
        @click="remove()"
        title="Close"
        class="leading-none -mt-1 text-xl cursor-pointer hover:text-red-700"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    payload: {
      type: Object,
      required: true
    }
  },

  computed: {
    autoHide () {
      if (typeof this.payload.autoHide === 'undefined') {
        return true
      }

      this.payload.autoHide
    },

    delay () {
      if (typeof this.payload.delay === 'undefined') {
        return 20000
      }

      return this.payload.delay
    },

    message () {
      return this.payload.message
    }
  },

  methods: {
    remove () {
      this.$emit('remove', this.payload)
    }
  },

  created () {
    this.timeout = null
  },

  mounted () {
    this.timeout = setTimeout(() => {
      this.remove()
    }, this.delay);
  },

  beforeDestroy () {
    clearTimeout(this.timeout)
  }
}
</script>
