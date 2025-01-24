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
      placeholder="ФИО*"
      @input="validateName"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="fullNameError" class="text-red-500 text-sm mt-1">{{ fullNameError }}</p>

    <!-- Поле для ввода профессии -->
    <input
      v-model="modelValue.profession"
      type="text"
      placeholder="Профессия*"
      @input="validateProfession"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="professionError" class="text-red-500 text-sm mt-1">{{ professionError }}</p>

    <!-- Поле для ввода ссылки на фото -->
    <input
      v-model="modelValue.photoUrl"
      type="text"
      placeholder="Ссылка на фото"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />

    <!-- Поле для поиска города -->
    <vue-single-select
      v-model="modelValue.city"
      :options="cities"
      option-label="title"
      placeholder="Введите город*"
      @input="onInputCity"
    />

    <!-- Поле для ввода телефона -->
    <input
      v-model="modelValue.phone"
      type="text"
      placeholder="Телефон*"
      ref="phoneInput"
      @input="validatePhone"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="phoneError" class="text-red-500 text-sm mt-1">{{ phoneError }}</p>

    <!-- Поле для ввода email -->
    <input
      v-model="modelValue.email"
      type="email"
      placeholder="Email*"
      @input="validateEmail"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="emailError" class="text-red-500 text-sm mt-1">{{ emailError }}</p>

    <!-- Поле для выбора даты рождения -->
    <input
      v-model="modelValue.birthDate"
      type="date"
      placeholder="Дата рождения*"
      @input="validateBirthDate"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="birthDateError" class="text-red-500 text-sm mt-1">{{ birthDateError }}</p>

    <!-- Поле для ввода желаемой зарплаты -->
    <input
      v-model="modelValue.desiredSalary"
      type="text"
      placeholder="Желаемая зарплата*"
      @input="validateDesiredSalary"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    />
    <p v-if="desiredSalaryError" class="text-red-500 text-sm mt-1">{{ desiredSalaryError }}</p>

    <!-- Поле для ввода ключевых навыков -->
    <textarea
      v-model="modelValue.skills"
      placeholder="Ключевые навыки*"
      @input="validateSkills"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>
    <p v-if="skillsError" class="text-red-500 text-sm mt-1">{{ skillsError }}</p>

    <!-- Поле для ввода информации о себе -->
    <textarea
      v-model="modelValue.about"
      placeholder="О себе*"
      @input="validateAbout"
      class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
    ></textarea>
    <p v-if="aboutError" class="text-red-500 text-sm mt-1">{{ aboutError }}</p>

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
        <div v-if="edu.educationLevel === 'university' || edu.educationLevel === 'not_university'">
          <vue-single-select
            v-model="edu.stateUnivesity"
            :options="univers"
            option-label="title"
            placeholder="Учебное заведение"
            @input="(query) => onInputUni(query, index)"
          />
        </div>
        <div v-if="edu.educationLevel === 'colledge'">
          <input
            v-model="edu.stateUnivesity"
            type="text"
            placeholder="Учебное заведение"
            class="border border-gray-300 p-3 rounded-lg shadow-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200 ease-in-out"
          />
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

    <!-- Кнопка для сохранения резюме -->
    <button @click="submitForm" class="bg-green-500 text-white px-4 py-2 rounded mt-4">
      Сохранить
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import VueSingleSelect from "vue-single-select"
import Inputmask from "inputmask";
import { useRouter } from 'vue-router';
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

const router = useRouter();

const phoneInput = ref(null)
onMounted(() => {
  const mask = new Inputmask('9999999999');
  mask.mask(phoneInput.value);
});

const fullNameError = ref('')
const professionError = ref('')
const phoneError = ref('')
const emailError = ref('')
const birthDateError = ref('')
const desiredSalaryError = ref('')
const skillsError = ref('')
const aboutError = ref('')

const validateName = () => {
  if (!props.modelValue.fullName) {
    fullNameError.value = 'Не введено ФИО'
  } else {
    fullNameError.value = ''
  }
}

const validateProfession = () => {
  if (!props.modelValue.profession) {
    professionError.value = 'Не введена профессия'
  } else {
    professionError.value = ''
  }
}

const validatePhone = () => {
  if (!props.modelValue.phone) {
    phoneError.value = 'Не введен номер телефона'
  } else {
    phoneError.value = ''
  }
}

const validateEmail = () => {
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(props.modelValue.email)) {
    emailError.value = 'Введите корректный email'
  } else if (!props.modelValue.email) {
    emailError.value = 'Не введен email'
  } else {
    emailError.value = ''
  }
}

const validateBirthDate = () => {
  if (!props.modelValue.birthDate) {
    birthDateError.value = 'Не выбрана дата рождения'
  } else {
    birthDateError.value = ''
  }
}

const validateDesiredSalary = () => {
  if (!props.modelValue.desiredSalary) {
    desiredSalaryError.value = 'Не введена желаемая зарплата'
  } else {
    desiredSalaryError.value = ''
  }
}

const validateSkills = () => {
  if (!props.modelValue.skills) {
    skillsError.value = 'Не введены навыки'
  } else {
    skillsError.value = ''
  }
}

const validateAbout = () => {
  if (!props.modelValue.about) {
    aboutError.value = 'Не введена информация о себе'
  } else {
    aboutError.value = ''
  }
}


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

// Логика для поиска городов
const searchQuery = ref('')
const cities = ref([])
var selectedCityId = 0;

const onInputCity = (query) => {
  if (query) {
    if (query.data !== null) {
      if (query.title) {
        props.modelValue.city = query.title
        selectedCityId = query.id
        return
      } else {
        searchQuery.value += query.data
        fetchCities()
      }
    } else searchQuery.value = searchQuery.value.slice(0, -1)
  } else {
    searchQuery.value = ""
    props.modelValue.city = ""
    selectedCityId = 0
  }
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
  })

  fetch(`/vkapi/method/database.getCities?${params}`, { headers })
  .then((response) => {
    if (!response.ok) {
      return response.text().then(text => {
        console.error('Ошибка:', text); // Логируем текст ответа
        throw new Error(`Ошибка: ${response.status} ${response.statusText}`);
      });
    }
    return response.json();
  })
  .then((data) => {
    cities.value = data.response.items;
  })
  .catch((error) => {
    console.error('Ошибка при получении данных:', error);
  });

}


// Логика для поиска университетов
const searchQueryUni = ref('')
const univers = ref([])

const onInputUni = (query, index) => {
  if (query) {
    if (query.data !== null) {
      if (query.title) {
        props.modelValue.educationList[index].stateUnivesity = query.title
        return
      } else {
        searchQueryUni.value += query.data
        fetchUniversities()
      }
    } else searchQueryUni.value = searchQueryUni.value.slice(0, -1)
  } else {
    searchQueryUni.value = ""
    props.modelValue.edu.stateUnivesity = ""
  }
}

const headers = { Authorization: `Bearer ${import.meta.env.VITE_KEY_NAME}` }

const fetchUniversities = () => {
  const params = new URLSearchParams({
    v: '5.81',
    q: searchQueryUni.value,
    city_id: selectedCityId,
    count: '10'
  })
  
  fetch(`/vkapi/method/database.getUniversities?${params}`, { headers })
    .then((response) => {
      if (!response.ok) {
        return response.text().then(text => {
          console.error('Ошибка:', text); // Логируем текст ответа
          throw new Error(`Ошибка: ${response.status} ${response.statusText}`);
        });
      }
      return response.json().then(data => {
        return data;
      });
    })
    .then((data) => {
      univers.value = data.response.items;
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error);
    });
}

const checkEmptyFields = () => {
  const requiredFields = {
    'ФИО': props.modelValue.fullName, 
    'Профессия': props.modelValue.profession, 
    'Телефон': props.modelValue.phone,
    'Email': props.modelValue.email, 
    'Дата рождения': props.modelValue.birthDate, 
    'Желаемая зарплата': props.modelValue.desiredSalary,
    'Город': props.modelValue.city, 
    'Навыки': props.modelValue.skills, 
    'О себе': props.modelValue.about
  }
  const emptyFields = [];
  Object.keys(requiredFields).forEach(key => {
    if (!requiredFields[key]) {
        emptyFields.push(key);
    }
  });
  if (emptyFields.length > 0) {
    alert('Заполните следующие поля:\n' + emptyFields.join(', '))
    return false;
  }
  return true;
}

const submitForm = () => {
  if (!checkEmptyFields()) return;
  emit('submit', props.modelValue); // Передаем данные в родительский компонент
}

</script>

<style scoped></style>