<script setup>
const movieStore = useMovieStore()
const authStore = useAuthStore()
const modalStore = useModalStore()

const baseUrl = useRuntimeConfig().public.baseUrl

const {data: filters} = await useAsyncData(
    'filters',
    () => movieStore.getFilters()
)

const errors = ref([])

let actor = reactive({
  name: '',
  country_id: null,
  birthday: '',
  description: '',
})

const createActor = async () => {
  await authStore.getCsrfToken()
  useModalStore().switchLoading()
  try {
    await $fetch(`${baseUrl}/actors`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value,
      },
      body: actor
    })
    modalStore.showFlashMessage('success', 'Actor has been stored!')
    actor = {
      name: '',
      country_id: null,
      birthday: '',
      description: '',
    }
    errors.value = []
  } catch (error) {
    errors.value = error.response._data.errors
  } finally {
    useModalStore().switchLoading()
  }
}

</script>

<template>
  <div class="flex justify-center items-center text-white mt-8">
    <LoadingPage/>
    <div class="flex flex-col px-20 bg-slate-800 rounded">
      <div class="basis-2/12 py-8 flex justify-center items-center">
        <h2 class="text-2xl">Add actor</h2>
      </div>
      <div class="basis-8/12 flex flex-col items-center justify-center">
        <div class="flex flex-col">
          <label for="actor-name">Name</label>
          <input
              id="actor-name"
              v-model="actor.name"
              type="text"
              class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
            placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0"
              required
          >
          <p v-if="errors.name" class="text-red-300 text-xs">{{ errors.name[0] }}</p>
        </div>
        <div class="flex flex-col mt-4">
          <label for="actor-country">Country</label>
          <select
              id="actor-country"
              v-model="actor.country_id"
              class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
            placeholder:pl-2 placeholder-white cursor-pointer pl-2 focus-within:placeholder:opacity-0"
              required
          >
            <option v-for="country in filters.countries" :key="country.id" :value="country.id">
              {{ country.name }}
            </option>
          </select>
          <p v-if="errors.country_id" class="text-red-300 text-xs">{{ errors.country_id[0] }}</p>
        </div>
        <div class="flex flex-col mt-4">
          <label for="actor-birthday">Birthday</label>
          <input
              id="actor-birthday"
              v-model="actor.birthday"
              type="text"
              class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
            placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0"
              required
          >
          <p v-if="errors.birthday" class="text-red-300 text-xs">{{ errors.birthday[0] }}</p>
        </div>
        <div class="flex flex-col mt-4">
          <label for="actor-description">Description</label>
          <textarea
              id="actor-description"
              v-model="actor.description"
              class="h-24 w-64 bg-slate-700 rounded outline-0 text-white
            placeholder:pl-2 placeholder-white cursor-text p-2 focus-within:placeholder:opacity-0 resize-none"
              required
          ></textarea>
          <p v-if="errors.description" class="text-red-300 text-xs">{{ errors.description[0] }}</p>
        </div>
        <button
            @click="createActor"
            class="my-6 w-24 px-2 py-1 border rounded hover:bg-slate-500"
            type="submit"
        >
          Add
        </button>
      </div>
    </div>
  </div>
</template>