<script setup>
const actorStore = useActorStore()
const columns = [
  { key: 'name', label: 'Name' },
  { key: 'country', label: 'Country' },
  { key: 'birthday', label: 'Birthday'}
]

const fetchActors = async (page) => {
  await actorStore.getActors(page)
}
actorStore.getActors()
</script>

<template>
  <div class="flex flex-col justify-center items-center h-full mt-16">
    <div class="basis-2/12 w-3/4 py-4 flex flex-col md:flex-row items-center justify-end">
      <NuxtLink to="/actors/new-actor" class="flex justify-end">
        <button class="bg-slate-200 font-bold hover:bg-slate-400 px-2 py-1 rounded">ADD ACTOR</button>
      </NuxtLink>
    </div>
    <div class="basis-10/12 w-11/12 mt-4 md:w-3/4">
      <DataTable
          :items="actorStore.actors"
          :columns="columns"
          :fetchData="fetchActors"
          linkPrefix="/actors/profile/"
      />
    </div>
  </div>
</template>