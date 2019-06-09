<template>
  <bundy>
    <template v-slot="{ off, late, normal }">
      <div
        :class="{
          'bg-red-500': late,
          'bg-gray-900': off,
          'bg-gray-200': normal,
        }"
        class="absolute h-screen-50 w-full z-0 top-0 left-0 right-0"
      />
    </template>
  </bundy>
</template>
