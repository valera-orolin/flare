<script setup>
const props = defineProps(['posts']);

const changePage = (url) => {
    window.location.href = url;
}
</script>

<template>
    <div v-if="posts.last_page > 1" class="flex items-center justify-center space-x-4">
        <button :disabled="!posts.prev_page_url" @click="changePage(posts.first_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-up']" /></button>
        <button :disabled="!posts.prev_page_url" @click="changePage(posts.prev_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-left']" /></button>
        <button :disabled="!posts.next_page_url" @click="changePage(posts.next_page_url)" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50 disabled:cursor-not-allowed"><font-awesome-icon :icon="['fas', 'arrow-right']" /></button>
    </div>
</template>