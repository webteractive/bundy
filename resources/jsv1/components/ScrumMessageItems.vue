<template>
  <div>
    <h3
      v-text="title"
      class="mb-1 font-black"
    />
    <div
      v-for="(item, index) in items"
      :key="index"
      class="relative font-gray-800 pl-5"
    >
      <span :class="[iconColor]" class="absolute left-0">
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
    },

    iconColor: {
      type: String,
      default: ''
    }
  }
}
</script>

