<template>
  <button
    :disabled="loading"
    type="button"
    class="px-4 py-2 border"
  >
    <slot>{{ label }}</slot>
  </button>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: ''
    },

    loading: {
      type: Boolean,
      default: false
    }
  }
}
</script>

