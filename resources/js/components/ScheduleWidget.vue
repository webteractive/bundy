<template>
  <bundy v-slot="{ late, off, today }">
    <div
      :class="{
        'bg-red-500 text-white border-red-600': late,
        'bg-blue-500 text-white border-blue-600': off,
      }"
      class="rounded p-3 flex items-center h-24"
    >
      <h3
        v-if="off"
        class="text-xl text-center leading-tight w-full"
      >
        Today is your Day Off
      </h3>

      <template v-else>
        <h3>Your Schedule Today is</h3>
        <h4></h4>
      </template>
    </div>
  </bundy>
</template>

