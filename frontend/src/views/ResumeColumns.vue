<template>
  <div class="flex">
    <div
      v-if="sceneStore.showStatus === 'loading'"
      class="flex items-center justify-center mt-32"
      role="status"
    >
      <svg
        aria-hidden="true"
        class="inline w-24 h-24 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
        viewBox="0 0 100 101"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
          fill="currentColor"
        />
        <path
          d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
          fill="currentFill"
        />
      </svg>
      <span class="sr-only">Загрузка...</span>
    </div>

    <div
      class="flex flex-wrap gap-4 h-[600px] mt-6"
      v-else-if="sceneStore.showStatus === 'complete'"
    >
      <div v-for="(status, index) in sceneStore.statusList" :key="index" class="col-3">
        <h3><strong>{{ status }} ({{ sceneStore.statusCount[status] || 0 }})</strong></h3>
        <draggable
          class="list-group"
          v-model="sceneStore.resume[status]"
          group="people"
          @change="sceneStore.updateStatus"
          itemKey="id"
        >
          <template #item="{ element }">
            <div 
              class="list-group-item cursor-pointer" 
              :class="{
                '!bg-blue-300': element.status.value === 'Новый',
                '!bg-orange-300': element.status.value === 'Назначено собеседование',
                '!bg-green-300': element.status.value === 'Принят',
                '!bg-red-300': element.status.value === 'Отказ'
              }"
              @click="goToEditPage(element.id)"
            >
              <div class="flex items-center justify-center">
                <img :src="element.photo || '/incognito-image.png'" class="h-36 w-36 rounded-lg" />
              </div>
              <div class="text-xl"><strong>{{ element.profession }}</strong></div>
              <div class="text-lg">{{ element.name }}, {{ calculateAge(element.birthday) }}</div>
            </div>
          </template>
        </draggable>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useSceneStore } from '@/stores/sceneStore'
import draggable from 'vuedraggable'

export default {
  name: 'two-lists',
  components: {
    draggable
  },
  setup() {
    const sceneStore = useSceneStore()
    const router = useRouter()

    onMounted(() => {
      sceneStore.fetchCandidates()
    })

    const calculateAge = (birthday) => {
      const birthDate = new Date(birthday)
      const today = new Date()
      let age = today.getFullYear() - birthDate.getFullYear()
      const monthDifference = today.getMonth() - birthDate.getMonth()
      if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--
      }
      return age
    }

    const goToEditPage = (id) => {
      router.push(`/edit/${id}`)
    }

    return {
      sceneStore,
      calculateAge,
      goToEditPage
    }
  }
}
</script>

<style scoped>
.list-group {
  border: 1px solid #ccc;
  padding: 10px;
  min-width: 300px;
}
.list-group-item {
  padding: 5px;
  border: 1px solid #007bff;
  margin: 5px 0;
  border-radius: 4px;
  background-color: #f8f9fa;
}

img {
  object-fit: cover;
}
</style>