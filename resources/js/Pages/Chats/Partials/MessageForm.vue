<script setup>
import { useForm} from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount  } from 'vue';
import 'emoji-picker-element';

const props = defineProps(['chat']);

const emit = defineEmits(['message-created']);
 
const form = useForm({
    content: '',
});

const showEmojiPicker = ref(false);

const addEmoji = (event) => {
    form.content += event.detail.unicode;
};

const toggleEmojiPicker = (event) => {
    event.stopPropagation();
    showEmojiPicker.value = !showEmojiPicker.value;
};

let handleClickOutside;
onMounted(() => {
    handleClickOutside = (event) => {
        const emojiPicker = document.querySelector('.emoji-picker');
        if (emojiPicker && !emojiPicker.contains(event.target)) {
            showEmojiPicker.value = false;
        }
    };
    document.addEventListener('click', handleClickOutside);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

let submitForm = () => {
    let formData = new FormData();
    formData.append('content', form.content);

    axios.post(route('messages.store', props.chat.id), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
    }).then((response) => {
        form.reset()
        emit('message-created', response.data)
    }).catch(error => {
        console.error(error);
    });
};
</script>

<template>
    <div class="sticky bottom-0 z-20 pb-6 bg-white">
        <div class="w-full bg-gray-100 rounded-lg p-6 space-y-2">
            <!--
            <form @submit.prevent="form.post(route('messages.store', chat.id), { onSuccess: () => form.reset() })">-->
            <form @submit.prevent="submitForm">
                <textarea id="post-area" maxlength="1000" v-model="form.content"
                    class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="1"
                    placeholder="Type a comment..."></textarea>

                <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center mt-1">
                    <div class="flex items-center space-x-8">
                        <div class="relative inline-block z-10 emoji-picker">
                            <font-awesome-icon :icon="['fas', 'smile']" class="fas fa-smile text-gray-500 transition-all duration-200 cursor:pointer lg:hover:text-black" @click="toggleEmojiPicker" />
                            <emoji-picker v-show="showEmojiPicker" @emoji-click="addEmoji"
                                class="absolute left-[-50px] scale-75 transform top-full mt-1 shadow-2xl md:left-0 md:scale-100"></emoji-picker>
                        </div>
                    </div>
                    <button
                        class="self-end mt-2 rounded-full text-white bg-black py-2 px-4 transition-all duration-200 lg:mt-0 lg:hover:bg-gray-500"
                        type="submit">Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>