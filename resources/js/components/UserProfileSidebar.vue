<template>
  <div class="bg-white mb-3">
    <ct>Account Info</ct>
    <div class="py-4">
      <ul>
        <li
          v-for="item in menu"
          :key="item"
          v-text="item"
          class="px-4 py-2 capitalize cursor-pointer hover:bg-blue-100 hover:text-blue-600"
        />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    menu () {
      return [
        'media',
        'profile',
        'schedules',
        'account',
        'devices'
      ]
    }
  }
}
</script>

