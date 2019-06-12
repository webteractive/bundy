<template>
  <div
    :class="[`h-${size}`, `w-${size}`]"
    class="bg-gray-500 rounded-full shadow-inner"
  />
</template>

<script>
export default {
  props: {
    size: {
      default: 16
    }
  }
}
</script>

