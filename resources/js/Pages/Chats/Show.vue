<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from './Partials/Message.vue';
import MessageForm from './Partials/MessageForm.vue';
import BackButton from '@/Components/BackButton.vue';
import { onMounted, ref, nextTick, watchEffect } from 'vue';

const props = defineProps(['messages', 'chat']);

let messages = ref(props.messages);

const scrollDown = async () => {
    await nextTick();
    window.scrollTo(0,document.body.scrollHeight);
};

onMounted(async () => {
    scrollDown();
    var channel = window.Echo.channel(`chat.${props.chat.id}`);
    channel.listen('.message-sent', function(data) {
        console.log(data.message.content);
        messages.value.push(data.message);
    });
});

const addNewMessage = (message) => {
    messages.value.push(message);
};
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <div class="sticky z-20 top-16 left-0 bg-white py-4">
                <BackButton />
            </div>

            <div class="flex justify-center">
                <button @click="scrollDown" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400 disabled:opacity-50"><font-awesome-icon :icon="['fas', 'arrow-down']" /></button>
            </div>
            
            <Message v-for="message in messages"
                :key="message.id"
                :message="message" />

            <MessageForm 
                @message-created="addNewMessage" 
                :chat="chat" />
        </div>
    </AuthenticatedLayout>
</template>