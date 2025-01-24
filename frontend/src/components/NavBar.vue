<template>
  <div class="flex justify-start ml-4 mt-4">
    <div class="flex flex-wrap gap-4">
      <button @click="route.push('/')" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
        Главная страница
      </button>
      <button @click="route.push('/new')" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
        Новое резюме
      </button>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const route = useRouter()
</script>

<style lang="scss" scoped></style>