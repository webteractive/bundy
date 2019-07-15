<template>
  <div class="relative">
    <slot
      :items="items"
      :pagination="pagination"
    />
  </div>
</template>

<script>
export default {
  props: {
    payload: {
      type: Object,
      required: true
    }
  },

  computed: {
    items () {
      return this.payload.items
    },

    pagination () {
      return this.payload.pagination
    }
  }
}
</script>

