<template>
  <bundy>
    <template v-slot="{ off, late, time }">
      <div
        :class="accentState({ off, late })"
        class="absolute h-screen-50 w-full z-0 top-0 left-0 right-0"
      />
    </template>
  </bundy>
</template>

<script>
export default {
  methods: {
    accentState ({ off, late }) {
      let state = 'bg-gray-900'

      if (off) {
        state = 'bg-indigo-800'
      }

      if (! off && late) {
        state = 'bg-red-800'
      }

      return state
    }
  }
}
</script>

