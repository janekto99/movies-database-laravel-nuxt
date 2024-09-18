<script setup>
const baseUrl = useRuntimeConfig().public.baseUrl
const imageUrl = useRuntimeConfig().public.imageUrl

const search = ref('')
const searchedMovies = ref([])
const getMovieByName = async () => {
  if (search.value.length >= 2) {
    searchedMovies.value = await $fetch(`${baseUrl}/movies/search/${search.value}`)
  }
}
const clearBar = () => {
  setTimeout(() => {
    search.value = ''
  }, 200)
}
</script>

<template>
  <div @focusout="clearBar">
    <div id="searchBar" class="relative flex items-center">
      <input v-model="search"
             @input="getMovieByName"
             class="h-8 w-full bg-slate-700 rounded outline-0 text-white
    placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0"
             type="text" placeholder="Search a movie..">
      <img class="absolute h-5 right-2" src="../assets/icons/magnif.png" alt="magnifier">
    </div>
    <div id="list" class="w-2/3 md:w-1/4 flex flex-col absolute bg-white text-black mt-1 rounded-sm z-50">
      <div v-for="movie in searchedMovies" :key="movie.id" class="border border-slate-900 cursor-pointer"
           v-show="search.length >= 2">
        <NuxtLink :to="'/movies/profile/' + movie.id"
                  class="flex justify-evenly hover:bg-slate-400">
          <div class="">
            {{ movie.name }}
          </div>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>