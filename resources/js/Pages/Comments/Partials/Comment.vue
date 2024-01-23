<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
 
dayjs.extend(relativeTime);

defineProps(['comment']);
</script>

<template>
    <div class="w-full rounded-lg p-6 space-y-2 bg-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 group">
                <img v-if="comment.user.avatar" class="w-12 h-12 rounded-full object-cover object-center" :src="comment.user.avatar" alt="Avatar">
                <img v-else class="w-12 h-12 rounded-full object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
                <div class="flex flex-col overflow-hidden">
                    <a href="#" class="text-base flex flex-col space-x-1 md:flex-row">
                        <div class="font-bold max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap lg:group-hover:underline">{{ comment.user.name }}</div>
                        <div class="text-gray-500 hidden md:block">•</div>
                        <div class="text-gray-500 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap hidden md:block">{{ comment.user.user_id }}</div>
                    </a>
                    <div class="text-sm text-gray-500">{{ dayjs(comment.created_at).fromNow() }}</div>
                </div>
            </div>
        </div>
        {{ comment.message }}
    </div>
</template>