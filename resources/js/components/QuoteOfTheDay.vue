<template>
  <card :content="content">
    <span
      v-text="`Quote of the Day`"
      slot="extra"
      class="absolute top-0 right-4 text-xs italic bg-gray-300 text-gray-600 rounded-b px-2"
    />
  </card>
</template>

<script>
export default {
  computed: {
    content () {
      const date = new Date()
      const [message, name] = BUNDY.quote.split(' - ')

      return {
        name,
        date: new Date(date.setHours(7)),
        message,
        username: null,
        author: { name },
        hasProfile: false,
      }
    }
  }
}
</script>
