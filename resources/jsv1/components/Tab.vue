<template>
  <div class="relative">
    <div class="flex border-b border-gray-400">
      <router-link
        v-for="[tab, label] in tabs"
        :key="tab"
        :to="`/${tab}`"
        v-text="label"
        tag="button"
        active-class="border-blue-500 text-blue-500"
        class="capitalize py-4 outline-none flex-1 font-bold border-b-2 border-transparent text-gray-700 hover:bg-gray-100 hover:text-blue-500 focus:outline-none"
      />
    </div>
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    tabs: {
      type: Array,
      default: () => ([])
    }
  }
}
</script>
