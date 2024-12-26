<template>
  <div class="min-h-screen p-8" style="display: flex;">
    <!-- Форма для заполнения данных -->
    <div class="flex-1 pr-4">
      <div class="flex justify-between">
        <h2 class="text-2xl font-semibold mb-6">Введите данные для резюме</h2>
      </div>
      <ResumeComponent @submit="handleFormSubmit" />
      <!-- <ResumeComponent v-model:profession="resumeData.profession"
                      v-model:city="resumeData.city"
                      v-model:photoUrl="resumeData.photoUrl"
                      v-model:fullName="resumeData.fullName"
                      v-model:phone="resumeData.phone"
                      v-model:email="resumeData.email"
                      v-model:birthDate="resumeData.birthDate"
                      v-model:desiredSalary="resumeData.desiredSalary"
                      v-model:skills="resumeData.skills"
                      v-model:about="resumeData.about"
                      v-model:educationList="resumeData.educationList" /> -->
    </div>
    <!-- Шаблон резюме -->
    <div class="flex-1 pl-4 mt-12">
      <ResumeForm
        :university="resumeData.university"
        :isApply="resumeData.isApply"
        :photoUrl="resumeData.photoUrl"
        :phone="resumeData.phone"
        :profession="resumeData.profession"
        :city="resumeData.city"
        :fullName="resumeData.fullName"
        :email="resumeData.email"
        :birthDate="resumeData.birthDate"
        :education="resumeData.education"
        :desiredSalary="resumeData.desiredSalary"
        :skills="resumeData.skills"
        :about="resumeData.about"
        :stateUnivesity="resumeData.selectedUniversity"
        :faculty="resumeData.faculty"
        :spec="resumeData.spec"
        :year_finish="resumeData.year_finish"
        :isUniversity="resumeData.isUniversity"
        :educationLabel="resumeData.educationLabel"
        :additionalEducation="resumeData.additionalEducation"
        :educationList="resumeData.educationList"
        class="bg-white p-6 rounded-lg shadow-md"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Button from '@/components/ui/button/Button.vue'

import { useRouter, useRoute } from 'vue-router'
import ResumeForm from '../components/FormStudy.vue'

import ResumeComponent from '@/components/ResumeComponent.vue'

// Инициализация resumeData с начальными значениями
const resumeData = ref({
  university: '',
  isApply: false,
  photoUrl: '',
  phone: '',
  profession: '',
  city: '',
  fullName: '',
  email: '',
  birthDate: '',
  education: '',
  desiredSalary: '',
  skills: '',
  about: '',
  selectedUniversity: '',
  faculty: '',
  spec: '',
  year_finish: '',
  isUniversity: false,
  educationLabel: '',
  additionalEducation: '',
  educationList: []
})

const isSubmitted = ref(false)
const handleFormSubmit = (formData) => {
  resumeData.value = { ...formData }
  isSubmitted.value = true
}

const transformResumeData = (data) => {
  return {
    name: data.fullName,
    profession: data.profession,
    status: "Новый",
    photo: data.photoUrl,
    city: data.city,
    phone: data.phone,
    email: data.email,
    birthDate: data.birthDate,
    education: '',
    desiredSalary: Number(data.desiredSalary),
    skills: data.additionalEducation,
    about: data.about,
    additionalEducation: [],
    educationList: data.educationList
  }
}

// Роутинг

// по кнопке применить отправляем данные на сервер
watch(isSubmitted, async (newValue) => {
  console.log(newValue)

  const transformedData = transformResumeData(resumeData.value)

  const response = await fetch('http://localhost:8080/api/cv/add', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(transformedData)
  })

  const data = await response.json()

  console.log(data)
})

console.log(isSubmitted.value)

const router = useRouter()

const goToMain = () => {
  router.push('/')
}
</script>

<style lang="scss" scoped></style>