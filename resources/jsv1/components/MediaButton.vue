<template>
  <div class="flex items-center justify-center">
    <button 
      @click="$emit('click')"
      type="button"
      class="text-2xl opacity-100"
    >
      <fa icon="image" />
    </button>
  </div>
</template>
