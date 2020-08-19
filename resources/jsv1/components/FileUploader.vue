<template>
  <modal @close="close()">
    <div class="bg-white w-screen h-screen md:w-600 md:h-auto relative z-20 shadow">
      <ct>File Uploader</ct>
      <div class="px-4 py-3">
        <div
          :class="{
            'mb-2': loading
          }"
          class="h-16 flex items-center justify-center bg-blue-100"
        >
          <input
            :disabled="loading"
            @change="change"
            ref="file"
            type="file"
          />
        </div>
        <div v-if="loading" class="relative">
          <div :style="{'width': `${uploadProgress}%`}" class="inline-block h-3 bg-blue-500"></div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  props: {
    multiple: {
      type: Boolean,
      default: false
    },
    collection: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      uploadProgress: 0
    }
  },

  computed: {
    progress () {
      return {
        onUploadProgress: this.onUploadProgress
      }
    },

    loading () {
      return this.uploadProgress > 0 && this.uploadProgress < 100
    }
  },

  methods: {
    change ({ target: { files }}) {
      const data = new FormData()
      data.append('collection', this.collection)
      data.append('file', this.$refs.file.files[0])
      this.upload(data)
    },

    upload (payload) {
      this.$progress.start()
      this.$http.route('profile.media.store')
        .upload(payload, this.progress)
          .then(({ data: { user, message } }) => {
            this.$bus.emit('successful', { message })
            this.$store.dispatch('user/hydrate', user)
            this.$store.dispatch('profile/hydrate', user)
            this.$emit('uploaded')
            this.$progress.done()
            this.close()
          })
          .catch(error => {
            this.$progress.done()
            this.$emit('failed', error)
          })
    },

    onUploadProgress ({ loaded, total}) {
      this.uploadProgress = Math.round((loaded * 100) / total)
    },

    close () {
      this.$refs.file.files = null;
      this.$emit('close')
    }
  },

  mounted () {
    
  }
}
</script>
