<template>
  <form class="w-full max-w-sm">
    <div class="relative flex items-center">
      <input
        type="text"
        placeholder="Search"
        aria-label="Search"
        :class="`
          appearance-none bg-gray-200 w-full text-gray-700 
          py-2 px-6 pl-10 leading-tight
          focus:outline-none focus:bg-gray-300
        `"
      >
      <span class="absolute left-0 top-0 bottom-0 w-10 text-gray-600 flex justify-center items-center">
        <fa icon="search" />
      </span>
    </div>
  </form>
</template>
