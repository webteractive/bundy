<template>
  <div class="login flex items-center bg-gray-100 border p-4 rounded-full">
    <div class="p-4">
      <h1 class="mb-4 text-2xl text-center">Sign In</h1>

      <field
        icon="@"
        type="text"
        class="mb-4"
      />

      <field
        icon="P"
        type="password"
        class="mb-4"
      />

      <div class="flex justify-center">
        <btn
          label="Login"
          class="bg-blue-500 text-white border-blue-600 border-b-2 rounded hover:bg-blue-600 hover:border-blue-700"
        />
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.login {
  width: 320px;
  height: 320px;
}
</style>

