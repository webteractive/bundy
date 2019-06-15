<template>
  <div
    :class="[
      `h-${size}`,
      `w-${size}`,
      `bg-gray-500`,
      {
        'rounded-full': rounded
      }
    ]"
    class="flex items-center justify-center"
  >
    <span
      v-for="letter in initials"
      :key="letter"
      v-text="letter"
      class="uppercase tracking-wide text-white"
    />
    <slot name="extra" />
  </div>
</template>

<script>
export default {
  props: {
    size: {
      default: 16
    },

    user: {
      required: true
    },

    rounded: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    backgroundColor () {
      const colors = [
        'blue', 'red', 'yellow', 'pink', 'indigo', 'purple', 'gray'
      ]

      return colors[Math.floor(Math.random() * colors.length)];
    },
    
    initials () {
      return this.user.name.getInitials()
    },
  }
}
</script>

