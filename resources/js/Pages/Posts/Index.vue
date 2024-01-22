<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from './Partials/Post.vue';
import PostForm from './Partials/PostForm.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
 
const props = defineProps(['posts']);

const posts = ref(props.posts);

const addNewPost = (newPost) => {
    posts.value.data.unshift(newPost);
};

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

            <PostForm @post-created="addNewPost"/>

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