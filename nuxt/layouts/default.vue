<script setup>

</script>

<template>
  <div class="flex flex-col min-h-screen bg-gradient-to-b from-slate-800 to-slate-500">
    <header class="basis-1/12">
      <Header/>
    </header>

    <div class="basis-10/12">
      <slot/>
    </div>

    <footer class="basis-1/12">

    </footer>
  </div>
</template>