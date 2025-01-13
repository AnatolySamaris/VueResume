<template>
  <div class="grid grid-cols-1 gap-4">
    <!-- Поле для статуса -->
    <Select v-model="modelValue.status">
      <SelectTrigger>
        <SelectValue placeholder="" />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectItem class="text-blue-600" value="Новый"> Новый </SelectItem>
          <SelectItem class="text-orange-600" value="Назначено собеседование"> Назначено собеседование </SelectItem>
          <SelectItem class="text-green-600" value="Принят"> Принят </SelectItem>
          <SelectItem class="text-red-600" value="Отказ"> Отказ </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>

    <!-- Поле для ввода ФИО -->
    <input
      v-model="modelValue.fullName"
      type="text"
      placeholder="ФИО"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода профессии -->
    <input
      v-model="modelValue.profession"
      type="text"
      placeholder="Профессия"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода ссылки на фото -->
    <input
      v-model="modelValue.photoUrl"
      type="text"
      placeholder="Ссылка на фото"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для поиска города -->
    <!-- <VueSingleSelect
      v-model="modelValue.city"
      :options="cities"
      option-label="title"
      placeholder="Введите город"
      @search="onInputCity"
      @select="handleSelectCity"
    /> -->

    <vue-single-select
      v-model="selectedCity"
      :options="cities"
      option-label="title"
      placeholder="Введите город"
      @input="onInputCity"
      @change="handleSelectCity"
    />

    <!-- Поле для ввода телефона -->
    <input
      v-model="modelValue.phone"
      type="text"
      placeholder="Телефон"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода email -->
    <input
      v-model="modelValue.email"
      type="email"
      placeholder="Email"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для выбора даты рождения -->
    <input
      v-model="modelValue.birthDate"
      type="date"
      placeholder="Дата рождения"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода желаемой зарплаты -->
    <input
      v-model="modelValue.desiredSalary"
      type="text"
      placeholder="Желаемая зарплата"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для ввода ключевых навыков -->
    <textarea
      v-model="modelValue.skills"
      placeholder="Ключевые навыки"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>

    <!-- Поле для ввода информации о себе -->
    <textarea
      v-model="modelValue.about"
      placeholder="О себе"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>

    <!-- Поля для ввода образования -->
    <div v-for="(edu, index) in modelValue.educationList" :key="index" class="flex flex-col gap-4 mt-4">
      <Select v-model="edu.educationLevel">
        <SelectTrigger>
          <SelectValue placeholder="Образование" />
        </SelectTrigger>
        <SelectContent>
          <SelectGroup>
            <SelectLabel>Варианты уровней образования</SelectLabel>
            <SelectItem value="school"> Среднее </SelectItem>
            <SelectItem value="colledge"> Среднее специальное </SelectItem>
            <SelectItem value="not_university"> Неоконченное высшее </SelectItem>
            <SelectItem value="university"> Высшее </SelectItem>
          </SelectGroup>
        </SelectContent>
      </Select>

      <div
        v-if="
          edu.educationLevel === 'university' ||
          edu.educationLevel === 'not_university' ||
          edu.educationLevel === 'colledge'
        "
        class="flex flex-col gap-4"
      >
        <div class="relative flex flex-col">
          <input
            v-model="edu.stateUnivesity"
            type="text"
            placeholder="Учебное заведение"
            class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
            @input="fetchUniversities(index)"
          />
          <select
            @change="handleSelectUniversity(index, $event)"
            v-if="edu.isVisibleUniversities"
            size="5"
            class="absolute z-10 mt-1 w-full border border-gray-300 p-3 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
          >
            <option v-if="edu.universities.length === 0" disabled>Ничего не найдено</option>
            <option v-for="univers in edu.universities" :key="univers.id" :value="univers">
              {{ univers.title }}
            </option>
          </select>
        </div>
        <input
          v-model="edu.faculty"
          type="text"
          placeholder="Факультет"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
        />
        <input
          v-model="edu.specialization"
          type="text"
          placeholder="Специализация"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
        />
        <input
          v-model="edu.year_finish"
          type="text"
          placeholder="Год окончания"
          class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
        />
      </div>

      <button
        @click="removeEducationBlock(index)"
        class="bg-red-500 text-white px-4 py-2 rounded mt-2"
      >
        Удалить образование
      </button>
    </div>

    <button @click="addEducationBlock" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
      Добавить образование
    </button>

    <!-- Кнопка для применения данных -->
    <button @click="applyData" class="bg-green-500 text-white px-4 py-2 rounded mt-4">
      Применить
    </button>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import VueSingleSelect from "vue-single-select";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue
} from '@/components/ui/select'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update:modelValue', 'submit'])

// Логика для добавления и удаления образования
const addEducationBlock = () => {
  props.modelValue.educationList.push({
    educationLevel: '',
    stateUnivesity: '',
    faculty: '',
    specialization: '',
    year_finish: '',
    universities: [],
    isVisibleUniversities: false
  })
}

const removeEducationBlock = (index) => {
  props.modelValue.educationList.splice(index, 1)
}

// Логика для применения данных
const applyData = () => {
  emit('submit', props.modelValue)
}

// Логика для поиска городов
const searchQuery = ref('')
const cities = ref([])
const selectedCity = ref('')

const onInputCity = (query) => {
  // console.log('ONE')
  if (query) {
    console.log(query.data)
    if (query.data !== null) searchQuery.value += query.data
    else searchQuery.value = searchQuery.value.slice(0, -1)
  } else {
    searchQuery.value = ""
  }
  fetchCities()
}

const fetchCities = () => {
  const params = new URLSearchParams({
    v: '5.81',
    country_id: '1',
    region_id: '0',
    offset: '0',
    need_all: '0',
    count: '10',
    q: searchQuery.value
    // q: modelValue.city
  })

  fetch(`api/method/database.getCities?${params}`, { headers })
    .then((response) => response.json())
    .then((data) => {
      cities.value = data.response.items
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
    })
}

const handleSelectCity = (event) => {
  console.log('TWO')
  console.log(event)
  console.log(event.target.value)
  console.log(selectedCity.value)
  props.modelValue.city = event.target.value
}

// Логика для поиска университетов
const headers = { Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}` }

// Обработка выбора университета
const handleSelectUniversity = (index, event) => {
  const selectedUniversity = JSON.parse(event.target.value)
  props.modelValue.educationList[index].stateUnivesity = selectedUniversity.title
  props.modelValue.educationList[index].isVisibleUniversities = false
}
</script>

<style scoped></style>