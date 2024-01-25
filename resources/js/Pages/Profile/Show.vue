<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from './Partials/ProfileHeader.vue';
import Post from '../Posts/Partials/Post.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
 
const props = defineProps(['posts', 'user']);

const posts = ref(props.posts);
const user = ref(props.user);

const updatePost = (updatedPost) => {
    const index = posts.value.data.findIndex(post => post.id === updatedPost.id);
    if (index !== -1) {
        posts.value.data.splice(index, 1, updatedPost);
    }
}
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <ProfileHeader :user="user" />

            <Post
                @post-updated="updatePost"
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <Pagination :posts="posts" />
        </div>
    </AuthenticatedLayout>
</template>