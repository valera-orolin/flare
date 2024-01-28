<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const props = defineProps(['message']);
</script>

<template>
    <div class="flex flex-col space-y-2 justify-self-end">
        <div class="p-6 max-w-sm bg-blue-100 rounded-tl-xl rounded-tr-xl rounded-bl-xl flex items-center self-end">
            <p class="text-gray-500">{{ message.content }}</p>
        </div>
        <div class="text-gray-500 self-end">18:08</div>
    </div>
</template>