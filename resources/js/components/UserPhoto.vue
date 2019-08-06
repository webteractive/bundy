<template>
  <div
    :class="[
      `w-${dimension.size[0]}`,
      `h-${dimension.size[1]}`,
      `bg-gray-500`,
      {
        'rounded-full': rounded
      }
    ]"
    class="flex items-center justify-center"
  >
    <img
      :src="photo" 
      :alt="initials"
      v-if="photo"
      class="uppercase tracking-wide text-white"
    />
    <template v-else>
      <span
        v-for="letter in initials"
        :key="letter"
        v-text="letter"
        class="uppercase tracking-wide text-white"
      />
    </template>
    <slot name="extra" />
  </div>
</template>

<script>
export default {
  props: {
    size: {
      default: 'small'
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

    dimension () {
      const sizes = [
        {name: 'small', size: [32, 32]},
        {name: 'smaller', size: [16, 16]},
        {name: 'smallest', size: [8, 8]}
      ]

      return sizes.find(size => size.name === this.size)
    },
    
    initials () {
      return this.user.name.getInitials()
    },

    photo () {
      if (typeof this.user.photo === 'undefined' || this.user.photo === null) {
        return null
      }

      return this.user.photo[this.size]
    }
  }
}
</script>

