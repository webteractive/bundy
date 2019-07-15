<template>
  <div class="inline-block relative w-full">
    <select
      v-model="selected"
      @change="input()"
      class="block appearance-none w-full bg-gray-200 border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 shadow leading-tight"
    >
      <option
        v-for="{value, text} in options"
        :key="value"
        :value="value"
        v-text="text"
      />
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      default: ''
    },
    
    options: {
      type: Array,
      default: () => ([])
    }
  },

  data () {
    return {
      selected: this.value
    }
  },

  watch: {
    value (value) {
      this.selected = value
    }
  },

  methods: {
    input () {
      this.$emit('input', this.selected)
    }
  }
}
</script>

