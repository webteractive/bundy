<template>
  <div class="field">
    <slot name="label">
      <label
        v-if="label"
        :for="name"
        class="label font-bold"
      >
        <span v-text="label" />
        <span
          v-if="required"
          v-text="`*`"
          class="text-red-500"
        />
      </label>
    </slot>

    <slot name="instruction">
      <p
        v-if="instruction"
        v-html="instruction"
        class="text-xs mb-1 italic text-gray-700"
      />
    </slot>

    <div class="relative">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true
    },

    instruction: {
      type: String,
      default: null
    }
  }
}
</script>