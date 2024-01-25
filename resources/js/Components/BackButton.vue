<script setup>
const goBack = () => window.history.back();
</script>
 
<template>
    <button  @click="goBack" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400"><font-awesome-icon :icon="['fas', 'arrow-left']" /></button>
</template>