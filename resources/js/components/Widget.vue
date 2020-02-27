<template>
  <div class="bg-white mb-3">
    <slot name="title">
      <ct v-if="title">{{ title }}</ct>
    </slot>
    <slot />
  </div>
</template>

<script>
export default {
  props: ['title']
}
</script>