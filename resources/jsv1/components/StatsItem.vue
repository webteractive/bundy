<template>
  <div class="stats-item">
    <span v-html="`${label}:`" class="text-gray-600"/>
    <slot name="value">
      <span v-html="value" class="text-black"/>
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: ''
    },

    value: {
      type: String,
      default: ''
    }
  }
}
</script>