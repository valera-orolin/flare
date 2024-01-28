<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from './Partials/Message.vue';
import MessageForm from './Partials/MessageForm.vue';
import BackButton from '@/Components/BackButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps(['messages']);
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <BackButton />
            
            <Message v-for="message in messages.data"
                :key="message.id"
                :message="message" />

            <Pagination :items="messages" />

            <MessageForm />
        </div>
    </AuthenticatedLayout>
</template>