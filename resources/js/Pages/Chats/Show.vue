<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from './Partials/Message.vue';
import MessageForm from './Partials/MessageForm.vue';
import BackButton from '@/Components/BackButton.vue';
import Pagination from '@/Components/Pagination.vue';
import { onMounted, ref } from 'vue';

const props = defineProps(['messages', 'chat']);

let messages = ref(props.messages);

onMounted(() => {
    var channel = window.Echo.channel(`chat.${props.chat.id}`);
    channel.listen('.message-sent', function(data) {
        console.log(data.message.content);
        messages.value.data.push(data.message);
    });
});
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <BackButton />
            
            <Message v-for="message in messages.data"
                :key="message.id"
                :message="message" />

            <Pagination :items="messages" />

            <MessageForm :chat="chat" />
        </div>
    </AuthenticatedLayout>
</template>