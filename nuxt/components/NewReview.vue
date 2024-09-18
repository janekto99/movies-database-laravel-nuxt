<script setup>
const baseUrl = useRuntimeConfig().public.baseUrl
const modalStore = useModalStore()
const authStore = useAuthStore()
const route = useRoute()
const movieId = route.params.id

const data = reactive({
  movie_id: movieId,
  review: ''
})

const emit = defineEmits(['send-data'])

const storeReviews = async () => {
  await authStore.getCsrfToken()
  useModalStore().switchLoading()
  try {
    const review = await $fetch(`${baseUrl}/reviews`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value,
      },
      body: data
    })
    emit('send-data', review)
    modalStore.switchReview()
    modalStore.showFlashMessage('success', 'Review has been stored!')
  } catch {

  } finally {
    useModalStore().switchLoading()
  }
}
</script>

<template>
  <div class="fixed inset-0 bg-slate-700 bg-opacity-70 flex items-center justify-center z-50">
    <div class="bg-slate-900 w-11/12 md:w-1/3 max-w-lg rounded-lg shadow-lg overflow-hidden">
      <div class="flex justify-between items-center bg-slate-800 p-4 border-b border-slate-700">
        <span class="text-white text-lg font-bold">NEW REVIEW</span>
        <img
            @click="modalStore.switchReview"
            class="h-8 w-8 cursor-pointer hover:opacity-75 transition-opacity"
            src="~/assets/icons/cross3.png"
            alt="Close icon"
        />
      </div>
      <div class="p-4">
        <textarea
            v-model="data.review"
            class="w-full h-32 p-2 border border-slate-600 rounded-lg bg-slate-800 text-white outline-none resize-none placeholder:text-slate-400"
            id="review"
            placeholder="Write your review here..."
        ></textarea>
      </div>
      <div class="flex justify-end p-4 border-t border-slate-700 bg-slate-800">
        <button
            @click="storeReviews"
            class="bg-slate-600 text-white px-4 py-2 rounded-lg hover:bg-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-400 transition-colors"
        >
          Add
        </button>
      </div>
    </div>
  </div>
</template>
