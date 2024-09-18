<script setup>
import SearchBar from "~/components/SearchBar.vue";
const authStore = useAuthStore()
</script>

<template>
<div class="flex flex-col w-full md:w-11/12 m-auto">
  <div class="flex h-16 justify-between items-center">
    <div class="flex justify-center md:justify-start items-center basis-2/3">
      <NuxtLink class="hidden md:flex" to="/">
        <img class="object-cover h-16 ml-0.5" src="~/assets/icons/logo3.png" alt="logo">
      </NuxtLink>
      <SearchBar class="w-11/12 md:w-1/2 ml-4"/>
    </div>
    <div class="basis-1/3 flex justify-end mr-3">
      <NuxtLink v-if="!authStore.auth" to="/auth/login" class="flex items-center w-28 px-2 py-1 border rounded hover:bg-slate-500 text-white">
        <img src="~/assets/icons/profile.png" alt="profile icon">
        <p class="ml-2">Sign Up</p>
      </NuxtLink>
      <NuxtLink v-else @click="authStore.logout" class="flex items-center w-28 px-2 py-1 border rounded hover:bg-slate-500 cursor-pointer text-white">
        <img src="~/assets/icons/profile.png" alt="profile icon">
        <p class="ml-2">Log Out</p>
      </NuxtLink>
    </div>
  </div>
  <div>
    <nav>
      <ul class="ml-2.5 md:ml-0 text-white">
        <NuxtLink to="/movies" class="pl-2">Movies</NuxtLink>
        <NuxtLink to="/actors" class="pl-2">Actors</NuxtLink>
      </ul>
    </nav>
  </div>
</div>
</template>