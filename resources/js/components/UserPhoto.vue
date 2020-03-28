<template>
  <div
    :class="[
      `w-${dimension.size[0]}`,
      `h-${dimension.size[1]}`,
      bgColor,
      {
        'rounded-full': rounded
      }
    ]"
    class="flex items-center justify-center text-white"
  >
    <img
      :src="photo" 
      :alt="initials"
      v-if="photo"
      class="uppercase tracking-wide"
    />
    <template v-else>
      <span
        v-for="letter in initials"
        :key="letter"
        v-text="letter"
        class="uppercase tracking-wide"
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
    },

    bgColor: {
      type: String,
      default: 'bg-gray-500'
    }
  },

  computed: {

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

