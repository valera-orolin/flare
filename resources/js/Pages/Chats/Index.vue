<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Chat from './Partials/Chat.vue';
import BackButton from '@/Components/BackButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps(['chats']);
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <BackButton />
            
            <Chat v-for="chat in chats.data"
                :key="chat.id"
                :chat="chat" />

            <Pagination :items="chats" />
        </div>
    </AuthenticatedLayout>
</template>