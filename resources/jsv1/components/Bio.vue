<template>
  <p class="leading-relaxed" v-html="theBio" />
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

      if (bio === null) {
        return ''
      }
      
      bio = bio.replace(/`.+`/gm, match => `<code class="font-mono py-1 px-2 text-sm bg-gray-200 shadow-inner">${match.substring(1, match.length - 1)}</code>`)
      bio = bio.replace(/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/gm, '<a href="$&" target="_blank" class="text-blue-500 hover:underline">$&</a>')

      return bio
    }
  }
}
</script>

