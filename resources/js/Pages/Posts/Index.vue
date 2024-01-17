<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import PostForm from '@/Components/PostForm.vue';
 
defineProps(['posts']);
</script>
 
<template>
    <Head title="Posts" />
 
    <AuthenticatedLayout>
        <!-- Scrollable bottom -->
        <div class="my-4 space-y-4">

            <PostForm/>

            <Post
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
        </div>
    </AuthenticatedLayout>
</template>