<template>
  <page-layout>
    <template slot="content">
      <ct>Home</ct>
      <div>
        <card />
        <card
          v-for="item in 10"
          :key="item"
        />
      </div>
    </template>
  </page-layout>
</template>
