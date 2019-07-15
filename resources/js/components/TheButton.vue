<template>
  <button 
    :class="[buttonClass]"
    @click="$emit('click')"
    type="button"
    class="px-4 py-2"
  >
    <slot>{{ label }}</slot>
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: ''
    },

    label: {
      type: String,
      default: ''
    }
  },

  computed: {
    buttonClass () {

      if (this.type === 'info') {
        return 'bg-blue-500 text-white border-blue-600 hover:bg-blue-600 hover:border-blue-700'
      }

      if (this.type === 'danger') {
        return 'bg-red-500 text-white border-red-600 hover:bg-red-600 hover:border-red-700'
      }

      if (this.type === 'warning') {
        return 'bg-yellow-300 border-blue-400 hover:bg-yellow-400 hover:border-yellow-500'
      }

      if (this.type === 'success') {
        return 'bg-green-500 border-blue-600 text-white hover:bg-green-600 hover:border-green-700'
      }

      return 'bg-gray-300 border-gray-400 text-gray-800 hover:bg-gray-400 hover:border-gray-500 hover:text-gray-900'
    }
  }
}
</script>

