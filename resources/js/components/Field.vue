<template>
  <div class="relative">
    <span
      class="absolute px-4 py-2"
      v-text="icon"
      v-if="icon"
    />
    <input
      :type="type"
      :class="{
        'pl-10': icon
      }"
      class="border border-b-2 px-4 py-2 w-full rounded"
    />
  </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'text'
    },

    icon: {
      type: String,
      default: ''
    }
  },

  computed: {
    inputTypes () {
      return [
        'text',
        'email',
        'number'
      ].indexOf(this.type)
    }
  }
}
</script>

