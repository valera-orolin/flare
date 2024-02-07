<script setup>
import { ref, onMounted } from 'vue';

let search = ref('');

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    search.value = urlParams.get('search') || '';
});
</script>

<template>
    <div class="sticky bottom-0 bg-white">
        <div class="w-full bg-blue-100 rounded-lg p-6">
            <form method="GET" action="/posts" class="flex items-center space-x-2">
                <input id="search-area" maxlength="1000" name="search" v-model="search"
                    class="w-full p-1 bg-transparent resize-none border-none focus:outline-none"
                    placeholder="Search posts...">
                <button
                    class="text-xl text-black py-2 px-4 transition-all duration-200 hover:text-gray-500"
                    type="submit"><font-awesome-icon :icon="['fas', 'magnifying-glass']" />
                </button>
            </form>
        </div>
    </div>
</template>