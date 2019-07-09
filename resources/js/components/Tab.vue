<template>
  <div class="relative">
    <div class="flex border-b border-gray-400">
      <button
        v-for="tab in tabs"
        :key="tab"
        :class="{
          'border-blue-500 text-blue-500': isActive(tab),
          'border-transparent text-gray-700 hover:bg-gray-100 hover:text-blue-500': ! isActive(tab)
        }"
        v-text="tab"
        @click.prevent="setActive(tab)"
        class="capitalize py-4 outline-none flex-1 font-bold border-b-2 focus:outline-none"
      />
    </div>

    <slot
      :active="active"
    />
  </div>
</template>

<script>
export default {
  props: {
    tabs: {
      type: Array,
      default: () => ([])
    },

    tab: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      active: this.tab
    }
  },

  methods: {
    isActive (tab) {
      return this.active === tab
    },

    setActive (tab) {
      this.active = tab
    }
  }
}
</script>
