<script setup>
import Pagination from "~/components/Pagination.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true
  },
  columns: {
    type: Array,
    required: true
  },
  linkPrefix: {
    type: String,
    default: ''
  },
  fetchData: {
    type: Function,
    required: true
  },
})
const handlePageChange = async (page) => {
  await props.fetchData(page)
}

const getValue = (item, key, nested) => {
  if (nested) {
    const keys = nested.split('.')
    return keys.reduce((obj, k) => obj && obj[k], item[key])
  }
  return item[key]
}
</script>

<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th
            v-for="column in columns"
            :key="column.key"
            scope="col"
            :class="['px-6 py-3', column.class]"
        >
          {{ column.label }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="item in items.data"
          :key="item.id"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
      >
        <td
            v-for="column in columns"
            :key="column.key"
            :class="['px-6 py-4', column.class]"
        >
          <div v-if="column.key === columns[0].key && linkPrefix">
            <nuxt-link
                :to="linkPrefix + item.id"
                class="font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ getValue(item, column.key, column.nested) }}
            </nuxt-link>
          </div>
          <div v-else>
            {{ getValue(item, column.key, column.nested) }}
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <div class="flex justify-end mt-2">
      <Pagination :pages="props.items" :fetchData="handlePageChange"/>
    </div>
  </div>
</template>