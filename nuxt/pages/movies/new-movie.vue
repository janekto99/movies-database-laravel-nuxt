<script setup>
const movieStore = useMovieStore()
const authStore = useAuthStore()
const actorStore = useActorStore()
const modalStore = useModalStore()

const baseUrl = useRuntimeConfig().public.baseUrl

let movie = reactive({
  name: '',
  year: '',
  genre_id: '',
  country_id: '',
  description: '',
  actors: []
})

let image = ref()
const errors = ref([])
const tagInputRef = ref(null)
const handleImage = (event) => {
  image = event.target.files[0]
}

const {data: filters} = await useAsyncData(
    'filters',
    () => movieStore.getFilters()
)

await actorStore.getActors()

const updateSelectedActors = (selectedActors) => {
  movie.actors = selectedActors
}

const onTagsCleared = () => {
  movie.actors = []
}

const createMovie = async () => {
  await authStore.getCsrfToken()
  useModalStore().switchLoading()
  const form = new FormData()
  form.append('file', image)
  form.append('name', movie.name)
  form.append('year', movie.year)
  form.append('genre_id', movie.genre_id)
  form.append('country_id', movie.country_id)
  form.append('description', movie.description)
  movie.actors.forEach((actor, index) => {
    form.append(`actors[${index}]`, actor.id)
  })
  try {
    await $fetch(`${baseUrl}/movies`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value,
      },
      body: form
    })
    modalStore.showFlashMessage('success', 'Movie has been stored!')
    movie = {
      name: '',
      year: '',
      genre_id: '',
      country_id: '',
      description: '',
      actors: []
    }
    image.value = null
    errors.value = []
    tagInputRef.value.clearTags()
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
        <h2 class="text-2xl">Add movie</h2>
      </div>
      <div class="basis-8/12 flex flex-col items-center justify-center">

        <div class="flex flex-col">
          <label for="">Name</label>
          <input v-model="movie.name" type="text" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0" required>
          <p v-if="errors.name" class="text-red-300 text-xs">{{ errors.name[0] }}</p>
        </div>

        <div class="flex flex-col">
          <TagInput ref="tagInputRef"
                    :data-fetch="actorStore.actors.data"
                    @update:selectedTags="updateSelectedActors"
                    @tags-cleared="onTagsCleared"
          />
          <p v-if="errors.actors" class="text-red-300 text-xs">{{ errors.actors[0] }}</p>
        </div>

        <div class="flex flex-col">
          <label for="">Year</label>
          <select v-model="movie.year" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-pointer pl-2 focus-within:placeholder:opacity-0" name="" id="">
            <option v-for="year in filters.years" :key="year" :value="year">{{ year }}</option>
          </select>
          <p v-if="errors.year" class="text-red-300 text-xs">{{ errors.year[0] }}</p>
        </div>

        <div class="flex flex-col">
          <label for="">Genre</label>
          <select v-model="movie.genre_id" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-pointer pl-2 focus-within:placeholder:opacity-0" name="" id="">
            <option v-for="genre in filters.genres" :key="genre" :value="genre.id">{{ genre.name }}</option>
          </select>
          <p v-if="errors.genre_id" class="text-red-300 text-xs">{{ errors.genre_id[0] }}</p>
        </div>

        <div class="flex flex-col">
          <label for="">Country</label>
          <select v-model="movie.country_id" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-pointer pl-2 focus-within:placeholder:opacity-0" name="" id="">
            <option v-for="country in filters.countries" :key="country" :value="country.id">{{ country.name }}</option>
          </select>
          <p v-if="errors.country_id" class="text-red-300 text-xs">{{ errors.country_id[0] }}</p>
        </div>

        <div class="flex flex-col">
          <label for="movie-description">Description</label>
          <textarea
              v-model="movie.description"
              id="movie-description"
              class="h-24 w-64 bg-slate-700 rounded outline-0 text-white placeholder:pl-2 placeholder-white cursor-text p-2 focus-within:placeholder:opacity-0 resize-none"
              required
          ></textarea>
          <p v-if="errors.description" class="text-red-300 text-xs">{{ errors.description[0] }}</p>
        </div>

        <div class="flex flex-col">
          <label for="wallpaper">Wallpaper</label>
          <input
              id="wallpaper"
              @change="handleImage"
              type="file"
              class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
            placeholder:pl-2 placeholder-white cursor-pointer focus-within:placeholder:opacity-0 file:mr-4 file:py-1 file:px-4
            file:border-0 file:text-sm file:font-semibold
            file:bg-slate-600 file:text-white hover:file:bg-slate-500"
          >
          <p v-if="errors.file" class="text-red-300 text-xs">{{ errors.file[0] }}</p>
        </div>

        <button @click="createMovie"
                class="my-6 w-24 px-2 py-1 border rounded hover:bg-slate-500"
                type="submit">Add
        </button>

      </div>
    </div>
  </div>
</template>