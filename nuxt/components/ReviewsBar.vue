<script setup>
import Pagination from "~/components/Pagination.vue";

const props = defineProps({
  reviews: {
    required: true
  },
})
const modalStore = useModalStore()
const authStore = useAuthStore()

const isAuth = () => {
  authStore.auth ?
      modalStore.switchReview() :
      modalStore.showFlashMessage('warning', 'You must be login!')
}
</script>

<template>
  <div class="flex flex-col bg-white rounded-lg shadow-lg border border-gray-300 overflow-hidden">
    <NewReview v-if="modalStore.newReview" @send-data="data => props.reviews.data.unshift(data)" />
    <div class="flex items-center justify-between p-4 bg-gray-100 border-b border-gray-300">
      <span class="text-lg font-semibold text-gray-900">Reviews</span>
      <div
          class="flex items-center text-sm bg-gray-200 border border-gray-300 p-2 rounded-lg hover:bg-gray-300 cursor-pointer transition-colors"
          @click="isAuth"
      >
        <img class="object-cover h-5 mr-2" src="~/assets/icons/add.png" alt="Add icon" />
        <span class="text-gray-900">NEW REVIEW</span>
      </div>
    </div>
    <div class="p-4">
      <div v-for="review in reviews.data" :key="review.id" class="mb-4">
        <Review :review="review.review" :date="review.created_at" :user="review.user" />
      </div>
    </div>
  </div>
</template>