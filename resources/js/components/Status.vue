<template>
  <bundy v-slot="{ off, late, normal, earlyBird }">
    <h2
      :class="{
        'text-red-700 font-bold text-xl tracking-wide': late,
        'text-green-500 text-xl': earlyBird,
        'italic text-base w-full md:w-1/2': off || normal,
      }"
      class="font-thin leading-tight"
    >
      {{ textStatus({ off, late, earlyBird }) }}
    </h2>
  </bundy>
</template>

<script>
export default {
  computed: {
    quote () {
      return BUNDY.quote
    }
  },

  methods: {
    status ({ off, late }) {
      let state = 'text-green-500'

      if (off) {
        state = 'text-indigo-100'
      }

      if (! off && late) {
        state = 'text-red-100'
      }

      return state
    },

    textStatus ({ off, late, earlyBird }) {
      if (off) {
        return this.quote
      }

      if (late) {
        return `Boo, you're late!`
      }

      if (earlyBird) {
        return 'Excellent job, youre so early today. Keep this up!'
      }

      return this.quote
    }
  }
}
</script>

