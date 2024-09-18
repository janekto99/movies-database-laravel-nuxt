<script setup>
import moment from "moment";

const props = defineProps({
  review: {
    type: String,
    required: true
  },
  user: {
    required: true
  },
  date: {
    required: true
  },
})

</script>

<template>
  <div class="bg-white p-4 mb-4 rounded-lg shadow-lg border border-gray-300 transition-transform transform">
    <div class="flex justify-between items-center text-sm text-gray-600">
      <span class="font-semibold text-gray-900">{{ props.user.name }}</span>
      <span>{{ moment(props.date).format("DD-MM-YYYY") }}</span>
    </div>
    <div class="mt-2 text-gray-900">
      <p class="whitespace-pre-line">{{ props.review }}</p>
    </div>
  </div>
</template>