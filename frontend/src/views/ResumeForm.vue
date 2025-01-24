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
      <FormStudy
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
import FormStudy from '../components/FormStudy.vue'
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
  resumeData.value = { ...formData };
  saveResume(formData); // Вызываем метод для сохранения данных
}

const saveResume = (data) => {
  const educations = data.educationList.map(edu => {
    let eduLevel = null;
    if (edu.educationLevel === "school") eduLevel = 'Среднее';
    else if (edu.educationLevel === 'colledge') eduLevel = 'Среднее специальное';
    else if (edu.educationLevel === 'not_university') eduLevel = 'Неоконченное высшее';
    else if (edu.educationLevel === 'university') eduLevel = 'Высшее';

    return {
      level: { value: eduLevel },
      place: edu.stateUnivesity,
      faculty: edu.faculty,
      specialty: edu.specialization,
      endYear: parseInt(edu.year_finish)
    };
  });

  const payload = {
    name: data.fullName,
    profession: data.profession,
    city: data.city,
    phone: data.phone,
    email: data.email,
    birthday: data.birthDate,
    salary: parseFloat(data.desiredSalary),
    skills: data.skills,
    about: data.about,
    photo: data.photoUrl,
    status: { value: data.status },
    educations: educations
  };

  // Отправляем данные на бэкенд
  fetch('/api/cv/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(payload)
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Ошибка при сохранении данных');
      }
      return response.json();
    })
    .then((result) => {
      router.push('/')
    })
    .catch((error) => {
      console.error('Ошибка при отправке данных:', error);
    });
};
</script>

<style lang="scss" scoped></style>