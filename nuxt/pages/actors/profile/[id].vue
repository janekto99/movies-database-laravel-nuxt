<script setup>
const actorStore = useActorStore()
const route = useRoute()
const actorId = route.params.id

const {data: actor} = await useAsyncData(
    'actor',
    () => actorStore.getActorById(actorId)
)
</script>

<template>
  <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300 max-w-sm mx-auto mt-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ actor.name }}</h2>

    <div class="text-gray-600 mb-4">
      <span class="font-semibold">Country:</span> {{ actor.country.name }}
    </div>

    <div class="text-gray-600 mb-4">
      <span class="font-semibold">Birthday:</span> {{ actor.birthday }}
    </div>

    <p class="text-gray-800 leading-relaxed">
      {{ actor.description }}
    </p>
  </div>
</template>