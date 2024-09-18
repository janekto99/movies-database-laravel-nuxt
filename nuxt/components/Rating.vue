<script setup>
import {useAuthStore} from "~/stores/auth.js";

const props = defineProps({
  userRate: {
    required: true
  }
})

const authStore = useAuthStore()
const modalStore = useModalStore()
const baseUrl = useRuntimeConfig().public.baseUrl
const route = useRoute()
const movieId = route.params.id

const rating = ref(props.userRate | 0)
const setRating = async () => {
  if (authStore.auth) {
    const data = {
      movie_id: movieId,
      rating: rating.value
    }
    await $fetch(`${baseUrl}/ratings`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value,
      },
      body: data
    })
  }
  else {
    rating.value = 0
    modalStore.showFlashMessage('warning', 'You must be login!')
  }
}
</script>

<template>
  <div class="flex justify-center items-center">
    <div class="flex flex-row-reverse justify-end items-center py-2 md:py-0">
      <input v-model="rating" @change="setRating"
             id="hs-ratings-readonly-1" type="radio"
             class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
             name="hs-ratings-readonly" value="5" :checked="rating === 5">
      <label for="hs-ratings-readonly-1"
             class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
        <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
          <path
              d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
      </label>
      <input v-model="rating" @change="setRating"
             id="hs-ratings-readonly-2" type="radio"
             class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
             name="hs-ratings-readonly" value="4" :checked="rating === 4">
      <label for="hs-ratings-readonly-2"
             class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
        <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
          <path
              d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
      </label>
      <input v-model="rating" @change="setRating"
             id="hs-ratings-readonly-3" type="radio"
             class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
             name="hs-ratings-readonly" value="3" :checked="rating === 3">
      <label for="hs-ratings-readonly-3"
             class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
        <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
          <path
              d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
      </label>
      <input v-model="rating" @change="setRating"
             id="hs-ratings-readonly-4" type="radio"
             class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
             name="hs-ratings-readonly" value="2" :checked="rating === 2">
      <label for="hs-ratings-readonly-4"
             class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
        <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
          <path
              d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
      </label>
      <input v-model="rating" @change="setRating"
             id="hs-ratings-readonly-5" type="radio"
             class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0"
             name="hs-ratings-readonly" value="1" :checked="rating === 1">
      <label for="hs-ratings-readonly-5"
             class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
        <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             viewBox="0 0 16 16">
          <path
              d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
        </svg>
      </label>
    </div>
  </div>
</template>