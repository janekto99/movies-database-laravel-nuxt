<script setup>
const movieStore = useMovieStore()
const modalStore = useModalStore()
const imageUrl = useRuntimeConfig().public.imageUrl
const baseUrl = useRuntimeConfig().public.baseUrl
const route = useRoute()

const movieId = route.params.id

const {data} = await useAsyncData('movie-data', async () => {
  const [movie, rating, userRating, initialReviews] = await Promise.all([
    movieStore.getMovieById(movieId),
    $fetch(`${baseUrl}/ratings/movies/${movieId}`),
    $fetch(`${baseUrl}/ratings/user/${movieId}`, {
      credentials: "include",
      headers: useRequestHeaders(['cookie'])
    }),
    $fetch(`${baseUrl}/reviews/movies/${movieId}`)
  ])
  return {movie, rating, userRating, reviews: initialReviews}
})

const movie = computed(() => data.value?.movie)
const rating = computed(() => data.value?.rating)
const userRating = computed(() => data.value?.userRating)
const reviews = ref(data.value?.reviews || [])

const isDescriptionExpanded = ref(false)

const toggleDescription = () => {
  isDescriptionExpanded.value = !isDescriptionExpanded.value
}

const truncatedDescription = computed(() => {
  if (!movie.value?.description) return ''
  return isDescriptionExpanded.value ? movie.value.description : movie.value.description.slice(0, 200) + (movie.value.description.length > 200 ? '...' : '')
})

const fetchReviews = async (page) => {
  modalStore.switchLoading()
  try {
    reviews.value = await $fetch(`${baseUrl}/reviews/movies/${movieId}?page=${page}`)
  } catch {

  } finally {
    modalStore.switchLoading()
  }

}
</script>

<template>
  <div class="w-11/12 md:w-3/4 m-auto mt-16">
    <div class="md:hidden flex flex-col items-center bg-slate-900 p-4 rounded-lg mb-4">
      <Rating :userRate="userRating" class="mb-2" />
      <p class="text-5xl font-bold text-white">{{ rating }}%</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="order-2 md:order-1 min-h-64 flex flex-col bg-slate-300 p-4 md:p-6 rounded-lg shadow-lg col-span-4 md:col-span-3">
        <div class="flex flex-col md:flex-row">
          <div class="hidden md:block md:w-1/3">
            <img v-if="movie.wallpaper_path && movie.wallpaper_path.includes('wallpaper')" class="object-cover h-64 w-64 rounded-lg" :src="imageUrl + movie.wallpaper_path" alt="">
            <img v-else class="object-cover h-64 w-64 rounded-lg" :src="movie.wallpaper_path" alt="">
          </div>
          <div class="md:w-2/3">
            <h2 class="text-3xl font-bold mb-4">{{ movie.name }}</h2>
            <div class="text-lg font-semibold mb-2">
              <p>{{ movie.genre.name }} / {{ movie.country.name }} / {{ movie.year }}</p>
            </div>
            <div class="flex flex-wrap items-center mb-4">
              <span class="font-semibold mr-2">Actors:</span>
              <div class="flex flex-wrap">
                <nuxt-link
                    v-for="(actor, index) in movie.actors"
                    :key="actor.id"
                    :to="'/actors/profile/' + actor.id"
                    class="text-blue-600 hover:underline mr-1"
                >
                  {{ actor.name }}<span v-if="index < movie.actors.length - 1">,</span>
                </nuxt-link>
              </div>
            </div>
            <p class="mb-2">{{ truncatedDescription }}</p>
            <button
                @click="toggleDescription"
                v-if="movie.description.length > 200"
                class="text-blue-500 hover:underline focus:outline-none"
            >
              {{ isDescriptionExpanded ? 'Hide' : 'Show more' }}
            </button>
          </div>
        </div>
      </div>
      <div class="order-1 md:order-2 hidden md:flex flex-col items-center bg-slate-900 p-4 rounded-lg col-span-4 md:col-span-1">
        <Rating :userRate="userRating" class="basis-1/5 mb-2" />
        <p class="basis-4/5 flex items-center text-5xl font-bold text-white">{{ rating }}%</p>
      </div>
      <div class="order-3 col-span-4 md:col-span-3">
        <ReviewsBar :reviews="reviews"/>
        <div class="flex justify-end mb-2 mt-2">
          <Pagination :pages="reviews" :fetchData="fetchReviews"/>
        </div>
      </div>
    </div>
  </div>
</template>


