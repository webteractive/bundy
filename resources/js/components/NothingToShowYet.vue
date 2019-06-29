<template>
  <div>
    <slot>
      {{ message }}
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      default: 'Nothing to show yet'
    }
  }
}
</script>

