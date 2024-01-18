<script setup>
const props = defineProps(['posts']);

const changePage = (url) => {
    window.location.href = url;
}
</script>

<template>
    <div v-if="posts.last_page > 1">
        <button :disabled="!posts.prev_page_url"  @click="changePage(posts.prev_page_url)">Previous</button>
        <span>Page {{ posts.current_page }} of {{ posts.last_page }}</span>
        <button :disabled="!posts.next_page_url"  @click="changePage(posts.next_page_url)">Next</button>
    </div>
</template>