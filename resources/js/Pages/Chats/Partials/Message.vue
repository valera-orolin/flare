<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3'
import { format, isToday } from 'date-fns'
import relativeTime from 'dayjs/plugin/relativeTime';

const props = defineProps(['message']);

const { props: pageProps } = usePage();

const isCurrentUsersPage = ref(false);

onMounted(() => {
    isCurrentUsersPage.value = props.message.user.id == pageProps.auth.user.id;
});

const formatDate = (date) => {
    if (isToday(new Date(date))) {
      return format(new Date(date), 'HH:mm')
    } else {
      return format(new Date(date), 'dd/MM/yyyy HH:mm')
    }
  }
</script>

<template>
    <div v-if="isCurrentUsersPage" class="flex flex-col space-y-1 justify-self-end">
        <div class="text-gray-500 self-end">You</div>
        <div class="px-6 py-4 max-w-sm bg-blue-100 rounded-tl-xl rounded-tr-xl rounded-bl-xl flex items-center self-end">
            <p class="text-gray-500">{{ message.content }}</p>
        </div>
        <div class="text-gray-500 self-end">{{ formatDate(message.created_at) }}</div>
    </div>

    <div v-else class="flex flex-col space-y-1 justify-start items-start">
        <div class="text-gray-500">{{ message.user.name }}</div>
        <div class="px-6 py-4 max-w-sm bg-gray-100 rounded-tl-xl rounded-tr-xl rounded-br-xl inline-flex items-start">
            <p class="text-gray-500">{{ message.content }}</p>
        </div>
        <div class="text-gray-500">{{ formatDate(message.created_at) }}</div>
    </div>
</template>