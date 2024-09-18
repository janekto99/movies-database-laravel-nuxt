<script setup>
import {useAuthStore} from "~/stores/auth.js";

const authStore = useAuthStore()
const auth = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

onBeforeMount(() => {
  authStore.errors = []
})
</script>

<template>
  <div class="flex justify-center items-center text-white h-full mt-16">
    <LoadingPage/>
    <div class="flex flex-col w-full md:w-2/5 px-20 bg-slate-800 rounded">
      <div class="basis-2/12 py-8 flex justify-center items-center">
        <h2 class="text-2xl">Sign up</h2>
      </div>
      <div class="basis-8/12 flex flex-col items-center justify-center">
        <div class="flex flex-col">
          <label for="">Username</label>
          <input v-model="auth.name" type="text" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0" required>
          <p v-if="authStore.errors.name" class="text-red-300 text-xs">{{ authStore.errors.name[0] }}</p>
        </div>
        <div class="flex flex-col">
          <label for="">Email</label>
          <input v-model="auth.email" type="text" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0" required>
          <p v-if="authStore.errors.email" class="text-red-300 text-xs">{{ authStore.errors.email[0] }}</p>
        </div>
        <div class="flex flex-col">
          <label for="">Password</label>
          <input v-model="auth.password" type="password" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0" required>
          <p v-if="authStore.errors.password" class="text-red-300 text-xs">{{ authStore.errors.password[1] }}</p>
        </div>
        <div class="flex flex-col">
          <label for="">Confirm password</label>
          <input v-model="auth.password_confirmation" type="password" class="h-6 w-64 bg-slate-700 rounded outline-0 text-white
          placeholder:pl-2 placeholder-white cursor-text pl-2 focus-within:placeholder:opacity-0" required>
          <p v-if="authStore.errors.password" class="text-red-300 text-xs">{{ authStore.errors.password[0] }}</p>
        </div>
        <button @click="authStore.register(auth)" class="my-6 w-24 px-2 py-1 border rounded hover:bg-slate-500"
                type="submit">Register
        </button>
      </div>
      <div class="basis-2/12 flex flex-col items-center py-2">
        <NuxtLink to="/auth/login">
          <p>Already registered?</p>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>