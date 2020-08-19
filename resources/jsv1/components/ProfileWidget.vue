<template>
  <div class="bg-gray-100 pb-4 rounded shadow">
    <div class="h-32 bg-blue-500 rounded-t" />
    
    <div class="flex items-center justify-center h-32 -mt-16 mb-4">
      <div class="h-32 w-32 rounded-full bg-gray-400 shadow-inner" />
    </div>

    <h3 class="text-center text-2xl text-gray-700" v-text="user.name" />
    <p class="text-center text-base text-gray-500 mb-4">Position</p>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      user: 'user/details'
    })
  }
}
</script>

