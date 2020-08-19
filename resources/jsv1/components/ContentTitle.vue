<template>
  <h2 class="px-4 py-3 text-xl font-bold border-b">
    <slot>{{ title }}</slot>
  </h2>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    }
  }
}
</script>
