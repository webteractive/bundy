<template>
  <modal @close="$emit('close')">
    <div class="bg-white w-screen h-screen md:w-600 md:h-auto relative z-20 shadow">
      <ct>File Uploader</ct>
      <div
        ref="dropzone"
        class="mx-4 my-3 border-dashed rounded bg-gray-100 border-4 cursor-pointer hover:bg-gray-200 hover:border-gray-400 h-128"
      >

      </div>
    </div>
  </modal>
</template>

<script>
import Dropzone from 'dropzone'

export default {
  created () {
    this.dropzone = null
  },

  mounted () {
    this.dropzone = new Dropzone(this.$refs.dropzone, {
      maxFileSize: 5,
      url: this.$http.route('profile.media.store').url()
    })
  }
}
</script>
