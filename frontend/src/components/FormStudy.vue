<template>
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center space-x-4 mb-4">
      <!-- <img :src="photoUrl" alt="Фото" class="w-24 h-24 rounded-full object-cover" /> -->
      <img :src="photoUrl || '/incognito-image.png'" alt="Фото" class="w-24 h-24 rounded-lg object-cover" />
      <div>
        <h1 class="text-3xl font-bold">{{ fullName || "ФИО" }}</h1>
        <p class="text-gray-600">{{ profession || "Профессия" }}</p>
      </div>
    </div>
    <div class="mb-4">
      <p class="text-gray-700"><strong>Город:</strong> {{ city || "Город" }}</p>
      <p class="text-gray-700"><strong>Телефон:</strong> {{ phone || "XXX XXX XX XX" }}</p>
      <p class="text-gray-700"><strong>Email:</strong> {{ email || "your-email@mail.com" }}</p>
      <p class="text-gray-700"><strong>Дата рождения:</strong> {{ formatDate(birthDate) || "01.01.2000"}}</p>

      <div v-for="(edu, index) in educationList" :key="index" class="flex flex-col pl-4">
        <h1 class="text-red-600">
          <strong> Образование №{{ index + 1 }}</strong>
        </h1>
        <p class="text-gray-700 pl-4">
          <strong>Образование:</strong>
          {{ edu.educationLevel === 'colledge' ? 'Среднее специальное' : ''
          }}{{ edu.educationLevel === 'not_university' ? 'Неоконченное высшее' : ''
          }}{{ edu.educationLevel === 'university' ? 'Высшее' : '' }}
          {{ edu.educationLevel === 'school' ? 'Школа' : '' }}
        </p>

        <div v-if="edu.educationLevel !== 'school'" class="flex flex-col gap-2 pt-2 pl-4">
          <p class="text-gray-600"><strong>Учебное заведение:</strong> {{ edu.stateUnivesity }}</p>
          <p class="text-gray-600"><strong>Факультет:</strong> {{ edu.faculty }}</p>
          <p class="text-gray-600"><strong>Специализация:</strong> {{ edu.specialization }}</p>
          <p class="text-gray-600"><strong>Год окончания:</strong> {{ edu.year_finish }}</p>
        </div>
      </div>

      <!-- <div v-for="(edu, index) in additionalEducation" :key="index" class="flex flex-col pt-2">
        <p class="text-gray-600">
          <strong>Ссылка на {{ index + 1 }} доп образование:</strong> {{ edu.link }}
        </p>
      </div> -->
      <p class="text-gray-700 mt-2"><strong>Желаемая зарплата:</strong> {{ formatSalary(desiredSalary) || "10 000" }}</p>
    </div>
    <div class="mb-4">
      <h2 class="text-xl font-semibold mb-2">Ключевые навыки</h2>
      <p class="text-gray-700">{{ skills || "Навык1, Навык2, Навык3, ..." }}</p>
    </div>
    <div>
      <h2 class="text-xl font-semibold mb-2">О себе</h2>
      <p class="text-gray-700">{{ about || "Более подробная информация о кандидате" }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  photoUrl: String,
  stateUnivesity: String,
  faculty: String,
  spec: String,
  year_finish: String,
  fullName: String,
  profession: String,
  city: String,
  phone: String,
  email: String,
  birthDate: String,
  educationLabel: String,
  education: String,
  desiredSalary: String,
  skills: String,
  about: String,
  additionalEducation: Array,
  university: String,
  educationList: Array
})

// Функция для форматирования даты
const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, '0'); // Добавляем ведущий ноль, если нужно
  const month = String(date.getMonth() + 1).padStart(2, '0'); // Месяцы начинаются с 0
  const year = date.getFullYear();
  return `${day}.${month}.${year}`; // Возвращаем дату в формате dd.mm.yyyy
}

// Функция для форматирования зарплаты
const formatSalary = (salary) => {
  if (!salary) return '';

  const salaryString = String(salary);

  // Определяем разделитель: точка или запятая
  const separator = salaryString.includes(',') ? ',' : '.';

  // Разделяем число на целую и дробную части
  const [integerPart, fractionalPart] = salaryString.split(separator);

  // Форматируем целую часть
  const formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

  return fractionalPart ? `${formattedIntegerPart}${separator}${fractionalPart}` : formattedIntegerPart;
}
</script>

<style lang="scss" scoped></style>
