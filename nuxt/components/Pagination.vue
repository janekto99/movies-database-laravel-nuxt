<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  pages: {
    type: Object,
    required: true,
  },
  fetchData: {
    type: Function,
    default: null
  }
})

const currentPage = ref(props.pages.current_page)
const totalPages = ref(props.pages.last_page)

watch(() => props.pages.current_page, (newPage) => {
  currentPage.value = newPage
})

watch(() => props.pages.last_page, (newTotalPages) => {
  totalPages.value = newTotalPages
})

const isActivePage = (page) => {
  return page === currentPage.value
}

const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    props.fetchData(page)
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    changePage(currentPage.value + 1)
  }
}

const previousPage = () => {
  if (currentPage.value > 1) {
    changePage(currentPage.value - 1)
  }
}
const range = (start, end) => Array.from({ length: end - start + 1 }, (_, i) => i + start)

const paginatedPages = computed(() => {
  const delta = 2
  const start = Math.max(currentPage.value - delta, 1)
  const end = Math.min(currentPage.value + delta, totalPages.value)

  if (start === 1) {
    return range(1, Math.min(5, totalPages.value))
  }
  if (end === totalPages.value) {
    return range(Math.max(totalPages.value - 4, 1), totalPages.value)
  }

  return range(start, end)
})
</script>

<template>
  <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between" aria-label="Table navigation">
    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
      <li @click.prevent="previousPage">
        <a href=""
           class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
      </li>

      <!-- Display paginated pages -->
      <li v-for="page in paginatedPages" :key="page">
        <a href="#"
           @click.prevent="changePage(page)"
           :class="[
            'flex items-center justify-center px-3 h-8 leading-tight border',
            isActivePage(page)
            ? 'text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
            : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
           ]"
        >{{ page }}</a>
      </li>

      <li @click.prevent="nextPage">
        <a href="#"
           class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
      </li>
    </ul>
  </nav>
</template>
