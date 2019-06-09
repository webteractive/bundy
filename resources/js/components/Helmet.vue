<template>
  <bundy v-slot="{ off, late, normal, time, formatter }">
    <div
      :class="{
        'bg-gray-300 border-gray-400 ': normal,
        'bg-black border-black text-white': off,
        'bg-red-700 border-red-800 text-white': late,
      }"
      class="w-full border-b-1"
    >
      <div class="container mx-auto">
        <div class="flex items-center">
          <logo class="w-1/2" />
          <div class="w-1/2 text-right text-xs">
            <span v-text="formatter('dddd, MMMM DD, YYYY, hh:MM A')" />
            <logout />
          </div>
        </div>
      </div>
    </div>
  </bundy>
</template>
