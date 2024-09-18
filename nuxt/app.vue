<script setup>
const modalStore = useModalStore()
</script>

<template>
  <div>
    <FlashMessage v-if="modalStore.flash"
                  :description="modalStore.flash.description"
                  :type="modalStore.flash.type"/>
    <NuxtLayout>
      <NuxtPage/>
    </NuxtLayout>
  </div>
</template>