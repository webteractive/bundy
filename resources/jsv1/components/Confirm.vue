<template>
  <modal disable-close-button>
    <div class="bg-white w-screen h-screen md:w-500 md:h-auto relative z-20 shadow">
      <ct>{{ title }}</ct>

      <div class="px-4 py-3 border-b">

      </div>

      <div class="px-4 py-3">
        <the-button
          label="Confirm"
          type="info"
        />

        <the-button
          label="Cancel"
        />
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'Confirm Action'
    }
  }
}
</script>