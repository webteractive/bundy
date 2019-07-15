<template>
  <div class="fixed inset-0 flex h-full w-full items-center justify-center z-50">
    <div class="bg-black absolute inset-0 z-10 opacity-50" @click.stop="shouldClose()" />
    <slot />
    <button
      v-if="enableCloseButton"
      @click.prevent="close()"
      class="absolute flex items-center justify-center top-0 right-0 z-30 text-gray-500 md:text-gray-100 p-0 leading-none w-8 h-8 text-3xl mt-4 mr-4 hover:text-red-300"
    >
      <span>&times;</span>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    backdrop: {
      type: Boolean,
      default: false
    },
    enableCloseButton: {
      type: Boolean,
      default: true
    }
  },

  methods: {
    close () {
      this.$emit('close')
    },

    shouldClose () {
      if (this.backdrop) {
        this.close()
      }
    }
  }
}
</script>


