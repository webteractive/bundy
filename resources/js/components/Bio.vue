<template>
  <p v-html="theBio" />
</template>

<script>
export default {
  props: {
    bio: {
      required: true
    }
  },

  computed: {
    theBio () {
      let bio = this.bio
      bio = bio.replace(/`.+`/gm, '<code class="font-mono text-sm bg-gray-100">$&</code>')
      bio = bio.replace(/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/gm, '<a href="$&" target="_blank" class="text-blue-500 hover:underline">$&</a>')

      return bio
    }
  }
}
</script>

