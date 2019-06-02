<template>
  <bundy v-slot="{ off, late }">
    <h2
      :class="status({ off, late })"
      v-text="textStatus({ off, late })"
      class="text-2xl font-thin leading-none w-full"
    />
  </bundy>
</template>

<script>
export default {
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

    textStatus ({ off, late }) {
      return `You're late again today`
    }
  }
}
</script>

