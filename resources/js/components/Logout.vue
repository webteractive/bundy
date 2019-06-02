<template>
  <bundy>
    <button
      :title="`Logout ${user.name} at once!`"
      @click="logout()"
      type="button"
      class="mr-4 hover:underline hover:text-red-600"
    >
      Logout
    </button>
  </bundy>
</template>
