<template>
  <bundy v-slot="{ off, late, normal, earlyBird }">
    <h2
      :class="{
        'text-red-700': late,
        'text-black italic': off || normal,
        'text-green-500': earlyBird && normal,
      }"
      v-text="textStatus({ off, late, earlyBird })"
      class="font-thin leading-tight text-base w-full md:w-1/2"
    />
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
        return `Boo! You're late today.`
      }

      if (earlyBird) {
        return 'Excellent job, youre so early today. Keep this up!'
      }

      return this.quote
    }
  }
}
</script>

