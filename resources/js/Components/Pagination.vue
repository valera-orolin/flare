<script setup>
const props = defineProps(['items']);

const changePage = (url) => {
    window.history.replaceState({}, '', url);
    location.reload();
}
</script>

<template>
    <div v-if="items.last_page > 1" class="flex items-center justify-center space-x-4">
        <button :disabled="!items.prev_page_url" @click="changePage(items.first_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-up']" /></button>
        <button :disabled="!items.prev_page_url" @click="changePage(items.prev_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-left']" /></button>
        <button :disabled="!items.next_page_url" @click="changePage(items.next_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-right']" /></button>
    </div>
</template>