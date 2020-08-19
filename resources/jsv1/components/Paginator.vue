<template>
  <div class="relative">
    <slot
      :items="items"
      :isEmpty="isEmpty"
      :pagination="pagination"
    />

    <div v-if="pagination.next_page_url" class="px-4 py-3">
      <button
        @click.prevent="$emit('next', pagination.next_page_url)"
        class="text-blue-500 w-full hover:text-blue-600 hover:underline"
      >
        More
      </button>
    </div>
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
    },

    isEmpty () {
      return this.pagination.total === 0
    }
  }
}
</script>

