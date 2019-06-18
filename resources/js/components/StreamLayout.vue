<template>
  <div
    @click.stop="click()"
    class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100"
  >
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    clickable: {
      default: true
    }
  },

  methods: {
    click () {
      if (this.clickable) {
        this.$emit('click')
      }
    }
  }
}
</script>


