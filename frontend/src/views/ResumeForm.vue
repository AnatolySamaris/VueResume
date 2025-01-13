<template>
  <div class="min-h-screen p-8" style="display: flex;">
    <!-- Форма для заполнения данных -->
    <div class="flex-1 pr-4">
      <div class="flex justify-between">
        <h2 class="text-2xl font-semibold mb-6">Введите данные для резюме</h2>
      </div>
      <ResumeComponent v-model="resumeData" @submit="handleFormSubmit" />
    </div>
    <!-- Шаблон резюме -->
    <div class="flex-1 pl-4 mt-12">
      <ResumeForm
        :photoUrl="resumeData.photoUrl"
        :fullName="resumeData.fullName"
        :profession="resumeData.profession"
        :city="resumeData.city"
        :phone="resumeData.phone"
        :email="resumeData.email"
        :birthDate="resumeData.birthDate"
        :desiredSalary="resumeData.desiredSalary"
        :skills="resumeData.skills"
        :about="resumeData.about"
        :educationList="resumeData.educationList"
        class="bg-white p-6 rounded-lg shadow-md"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ResumeForm from '../components/FormStudy.vue'
import ResumeComponent from '@/components/ResumeComponent.vue'

const resumeData = ref({
  status: 'Новый',
  photoUrl: '',
  fullName: '',
  profession: '',
  city: '',
  phone: '',
  email: '',
  birthDate: '',
  desiredSalary: '',
  skills: '',
  about: '',
  educationList: []
})

const handleFormSubmit = (formData) => {
  resumeData.value = { ...formData }
}
</script>

<style lang="scss" scoped></style>