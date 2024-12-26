<template>
  <div class="flex justify-start ml-4 mt-4">
    <div class="flex flex-wrap gap-4">
      <h1 @click="route.push('/')" class="text-purple-700 cursor-pointer hover:text-red-700">
        Главная страница
      </h1>
      <h1 @click="route.push('/new')" class="text-purple-700 cursor-pointer hover:text-red-700">
        Новое резюме
      </h1>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRouter()
</script>

<style lang="scss" scoped></style>
