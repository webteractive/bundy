<template>
  <div
    :class="[`h-${size}`, `w-${size}`, `bg-${backgroundColor}-600`]"
    class="rounded-full flex items-center justify-center font-thin"
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

