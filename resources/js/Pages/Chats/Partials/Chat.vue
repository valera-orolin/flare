<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const props = defineProps(['chat']);
</script>

<template>
    <div class="w-full bg-gray-100 rounded-lg p-6 space-y-2 lg:hover:bg-gray-50 lg:hover:cursor-pointer">
        <Link :href="route('messages.index', chat.interlocutor.id)" class="flex items-center space-x-4">
            <img v-if="chat.interlocutor.avatar" class="w-12 h-12 rounded-full object-cover object-center" :src="chat.interlocutor.avatar" alt="Avatar">
            <img v-else class="w-12 h-12 rounded-full object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
            <div class="flex flex-col w-full">
                <div class="flex items-center justify-between space-x-1">
                    <a href="chat.html" class="text-base flex flex-col space-x-1 group md:flex-row">
                        <div class="font-bold max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap lg:group-hover:underline">{{ chat.interlocutor.name }}</div>
                        <div class="text-gray-500 hidden md:block">&#x2022;</div>
                        <div class="text-gray-500 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap hidden md:block">{{ chat.interlocutor.user_id }}</div>
                    </a>
                    <div class="text-base text-gray-500">{{ dayjs(chat.last_message.created_at).fromNow() }}</div>
                </div>
                <div class="flex items-center justify-between space-x-1">
                    <a href="message.html">
                        <div class="text-base text-gray-500 max-w-[200px] overflow-ellipsis line-clamp-1 md:max-w-[300px] lg:max-w-[400px]">{{ chat.last_message.content }}</div>
                    </a>
                    <div class="bg-gray-500 text-white text-xs rounded-full py-1 px-2">13</div>
                </div>
            </div>
        </Link>
    </div>
</template>