<template>
  <div class="relative flex items-center">
    <div
      @click="toggle()"
      :class="{
        'justify-start border-gray-500': inactive,
        'justify-end bg-green-500 border-green-500': active,
      }"
      class="flex bg-white border rounded-full w-16 cursor-pointer mr-2"
    >
      <span
        :class="{
          'border-gray-400': inactive,
          'border-green-500': active,
        }"
        class="w-8 h-8 bg-white rounded-full border shadow"
      />
    </div>
    <span>
      <slot>{{ label }}</slot>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      default: false
    },

    label: {
      type: String,
      default: ''
    }
  },

  data () {
    return {
      active: this.value
    }
  },

  computed: {
    inactive () {
      return this.active === false
    }
  },

  methods: {
    toggle () {
      this.active = ! this.active
      this.$emit('input', this.active)
    }
  }
}
</script>