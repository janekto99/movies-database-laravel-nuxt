<script setup>
import {useMovieStore} from "~/stores/movies.js";
import {useModalStore} from "~/stores/modals.js";

const movieStore = useMovieStore()
const modalStore = useModalStore()

const columns = [
  { key: 'name', label: 'Name' },
  { key: 'genre', label: 'Genre', nested: 'name' },
  { key: 'year', label: 'Year' },
  { key: 'country', label: 'Country', nested: 'name', class: 'hidden md:table-cell' }
]

const fetchMovies = async (page) => {
  await movieStore.getMovies(page)
}
movieStore.getMovies(1)

const { data: filters } = await useAsyncData(
    'filters',
    () => movieStore.getFilters()
)
</script>

<template>
<div class="flex flex-col justify-center items-center h-full mt-16">
  <div class="flex justify-end w-3/4 py-4">
    <NuxtLink to="/movies/new-movie" class="flex justify-end">
      <button class="bg-slate-200 font-bold hover:bg-slate-400 px-2 py-1 rounded">ADD MOVIE</button>
    </NuxtLink>
  </div>
  <div class="basis-2/12">
    <div class=" flex flex-col md:flex-row items-center">
      <div class="relative h-10 w-72 min-w-[200px] mx-2 my-2">
        <select v-model="movieStore.setFilters.year"
                @change="movieStore.getMovies(1)"
                class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 font-sans text-sm font-normal text-white outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 empty:!bg-gray-900 focus:border-2 focus:border-white focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50">
          <option value=""></option>
          <option v-for="year in filters.years" :key="year" :value="year" class="text-black">{{ year }}</option>
        </select>
        <label
            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-white transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-white peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-white peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:border-white peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:border-white peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-white">
          Year
        </label>
      </div>

      <div class="relative h-10 w-72 min-w-[200px] mx-2 my-2">
        <select v-model="movieStore.setFilters.genre"
                @change="movieStore.getMovies(1)"
                class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 font-sans text-sm font-normal text-white outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 empty:!bg-gray-900 focus:border-2 focus:border-white focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50">
          <option value=""></option>
          <option v-for="genre in filters.genres" :key="genre.id" :value="genre.id" class="text-black">{{ genre.name }}</option>
        </select>
        <label
            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-white transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-white peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-white peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:border-white peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:border-white peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-white">
          Genre
        </label>
      </div>

      <div class="relative h-10 w-72 min-w-[200px] mx-2 my-2">
        <select v-model="movieStore.setFilters.country"
                @change="movieStore.getMovies(1)"
                class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 font-sans text-sm font-normal text-white outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 empty:!bg-gray-900 focus:border-2 focus:border-white focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50">
          <option value=""></option>
          <option v-for="country in filters.countries" :key="country.id" :value="country.id" class="text-black">{{ country.name }}</option>
        </select>
        <label
            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-white transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-white peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-white peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:border-white peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:border-white peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-white">
          Country
        </label>
      </div>
    </div>
  </div>
  <div class="basis-10/12 w-11/12 mt-4 md:w-3/4">
    <DataTable
        :items="movieStore.movies"
        :columns="columns"
        :fetchData="fetchMovies"
        linkPrefix="/movies/profile/"
    />
  </div>
</div>
</template>