<template>
  <div class="min-h-screen p-8" style="display: flex;">
    <!-- Форма для редактирования данных -->
    <div class="flex-1 pr-4">
      <div class="flex justify-between">
        <h2 class="text-2xl font-semibold mb-6">Редактировать резюме</h2>
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
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import ResumeComponent from '@/components/ResumeForm.vue';
import FormStudy from '@/components/ResumeTemplate.vue';

const route = useRoute();
const router = useRouter();

const resumeData = ref({
  status: '',
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
});

const selectedCityId = ref(0);
const isDataLoaded = ref(false);

// Загрузка данных резюме по ID
onMounted(async () => {
  const itemId = route.params.id;
  try {
    const response = await fetch(`/api/cv/${itemId}`);
    if (!response.ok) {
      throw new Error('Резюме не найдено');
    }
    const data = await response.json();

    // Инициализация данных резюме
    resumeData.value = {
      status: data.status.value,
      photoUrl: data.photo,
      fullName: data.name,
      profession: data.profession,
      city: data.city,
      phone: data.phone,
      email: data.email,
      birthDate: data.birthday,
      desiredSalary: data.salary,
      skills: data.skills,
      about: data.about,
      educationList: data.educations.map(edu => ({
        educationLevel: edu.level.value === 'Среднее' ? 'school' :
                       edu.level.value === 'Среднее специальное' ? 'colledge' :
                       edu.level.value === 'Неоконченное высшее' ? 'not_university' :
                       'university',
        stateUnivesity: edu.place,
        faculty: edu.faculty,
        specialization: edu.specialty,
        year_finish: edu.endYear
      }))
    };

    // Инициализация selectedCityId
    if (resumeData.value.city) {
      const params = new URLSearchParams({
        v: '5.81',
        country_id: '1',
        region_id: '0',
        offset: '0',
        need_all: '0',
        count: '10',
        q: resumeData.value.city
      });

      const cityResponse = await fetch(`/vkapi/method/database.getCities?${params}`, {
        headers: {
          Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}`
        }
      });

      if (!cityResponse.ok) {
        throw new Error('Ошибка при загрузке городов');
      }

      const cityData = await cityResponse.json();
      if (cityData.response.items.length > 0) {
        selectedCityId.value = cityData.response.items[0].id;
      }
    }

    isDataLoaded.value = true;
  } catch (error) {
    console.error('Ошибка при загрузке резюме:', error);
    router.push('/error');
  }
});



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
  const itemId = route.params.id;
  fetch(`/api/cv/${itemId}/edit`, {
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