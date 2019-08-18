<template>
  <span
    v-html="label"
    :class="[selected]"
    style="padding-top: 1px; padding-bottom: 1px;"
    class="rounded-full text-xs px-2 leading-none"
  />  
</template>

<script>
export default {
  props: {
    label: String,
    default: '&nbsp',

    type: {
      type: String,
      default: 'info'
    },

    custom: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    types () {
      return {
        info: 'bg-blue-500 text-blue-200',
        warning: 'bg-yellow-500 text-yellow-900',
        danger: 'bg-red-500 text-red-100',
        success: 'bg-green-500 text-green-200',
      }
    },

    selected () {
      if (this.custom) {
        return ''
      }

      return this.types[this.type]
    }
  }
}
</script>