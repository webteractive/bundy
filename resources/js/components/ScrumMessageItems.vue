<template>
  <div>
    <h3
      v-text="title"
      class="mb-1 font-bold"
    />
    <div
      v-for="(item, index) in items"
      :key="index"
    >
      <span>
        <fa :icon="icon" />
      </span>
      <span v-text="item" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },

    items: {
      type: Array,
      required: true
    },

    icon: {
      required: true
    }
  }
}
</script>

