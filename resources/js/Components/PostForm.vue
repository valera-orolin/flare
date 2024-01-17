<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm} from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import 'emoji-picker-element';
 
defineProps(['posts']);

const form = useForm({
    message: '',
    image: null,
    visibility: 'public'
});

const previewImage = ref(null)

const handleFileUpload = (event) => {
    form.image = event.target.files[0];
    previewImage.value = URL.createObjectURL(form.image);
};

let submitForm = () => {
    let formData = new FormData();
    formData.append('message', form.message);
    if (form.image) {
        formData.append('image', form.image);
    }
    formData.append('visibility', form.visibility);

    axios.post(route('posts.store'), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
    }).then(() => {
        form.message = '';
        form.image = null;
        form.visibility = 'public';
        previewImage.value = null;
    }).catch(error => {
        console.error(error);
    });
};

const triggerFileInput = () => {
    const fileInput = document.getElementById('post-media');
    fileInput.click();
};

const showEmojiPicker = ref(false);

const addEmoji = (event) => {
    form.message += event.detail.unicode;
};

let handleClickOutside;
onMounted(() => {
    handleClickOutside = (event) => {
        const dropdownMenu = document.querySelector('.emoji-picker');
        if (dropdownMenu && !dropdownMenu.contains(event.target)) {
            showEmojiPicker.value = false;
        }
    };
    document.addEventListener('click', handleClickOutside);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>
 
<template>
    <!-- Post writing area -->
    <div class="w-full bg-blue-100 rounded-lg p-6 space-y-2">
        <form @submit.prevent="submitForm">
            <textarea id="post-area" maxlength="350"
                v-model="form.message"
                class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="4"
                placeholder="What's up??">
            </textarea>
            <img :src="previewImage" v-if="previewImage" />
            <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center mt-1">
                <div class="flex items-center space-x-8">
                    <div>
                        <input type="file" id="post-media" class="hidden" accept="image/*" @change="handleFileUpload">
                        <font-awesome-icon :icon="['fas', 'image']" class="fas fa-image text-gray-500 cursor-pointer transition-all duration-200 lg:hover:text-black" @click="triggerFileInput"/>
                    </div>
                    <div
                        class="flex items-center text-gray-500 space-x-2 transition-all duration-200 lg:hover:text-black">
                        <font-awesome-icon :icon="['fas', 'globe']" id="globe-icon" />
                        <font-awesome-icon :icon="['fas', 'users']" class="hidden" id="users-icon" />
                        <select v-model="form.visibility" class="text-gray-500 bg-transparent border-none focus:outline-none">
                            <option value="public">Public</option>
                            <option value="only_friends">Only friends</option>
                        </select>
                    </div>
                    <div class="relative inline-block z-10 emoji-picker">
                        <font-awesome-icon :icon="['fas', 'smile']" class="fas fa-smile text-gray-500 transition-all duration-200 cursor:pointer lg:hover:text-black" @click="showEmojiPicker = !showEmojiPicker" />
                        <emoji-picker v-show="showEmojiPicker" @emoji-click="addEmoji"
                            class="absolute left-[-250px] scale-75 transform top-full mt-1 shadow-2xl md:left-0 md:scale-100"></emoji-picker>
                    </div>
                </div>
                <PrimaryButton>Publish post</PrimaryButton>
            </div>
        </form>
    </div>
</template>