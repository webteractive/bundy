<template>
  <button
    :disabled="loading"
    :class="[buttonClass, {
      'cursor-not-allowed': loading,
      'opacity-50 cursor-not-allowed': disabled
    }]"
    @click="$emit('click')"
    type="button"
    class="px-4 py-3 leading-none rounded-full"
  >
    <slot>{{ loading ? loadingText : label }}</slot>
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
    },

    loading: {
      type: Boolean,
      default: false
    },

    loadingText: {
      type: String,
      default: 'Working...'
    },

    disabled: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    buttonClass () {

      if (this.type === 'info') {
        return 'bg-blue-500 text-white border-b border-blue-600 hover:bg-blue-600 hover:border-blue-700'
      }

      if (this.type === 'danger') {
        return 'bg-red-500 text-white border-b border-red-600 hover:bg-red-600 hover:border-red-700'
      }

      if (this.type === 'warning') {
        return 'bg-yellow-300 border-b border-yellow-400 hover:bg-yellow-400 hover:border-yellow-500'
      }

      if (this.type === 'success') {
        return 'bg-green-500 border-b border-green-600 border-b text-white hover:bg-green-600 hover:border-green-700'
      }

      return 'bg-gray-300 border-b border-gray-400 text-gray-800 hover:bg-gray-400 hover:border-gray-500 hover:text-gray-900'
    }
  }
}
</script>

