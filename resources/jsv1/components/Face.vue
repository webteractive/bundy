<template>
  <bundy v-slot="{ late, off, normal }">
    <div
      :class="{
        'bg-gray-200': normal,
        'bg-gray-900 text-white': off,
        'bg-red-100 text-black border-red-200': late,
      }"
      class="pt-6 pb-16 border-b sm:px-2 md:px-0"
    >
      <div class="container mx-auto">
        <h1 class="capitalize text-base font-thin leading-none tracking-wider mb-1">
          <span v-text="greeting" />
          <span class="font-bold" v-text="user.name" />
        </h1>
        <status class="w-1/2" />
      </div>
    </div>
  </bundy>
</template>

<script>
import Status from './Status'
import { mapGetters } from 'vuex'

export default {
  components: {
    Status
  },

  computed: {
    ...mapGetters({
      user: 'user/details'
    }),

    greeting () {
      const greets = [
        'Hi',
        'Hello',
        'Howdy',
        'Bonjour',
        `Kon'nichiwa`,
        'Marhabaan',
        'Hey',
        'Zup',
        'Hāi'
      ]

      return greets[Math.floor(Math.random() * greets.length)]
    }
  }
}
</script>

