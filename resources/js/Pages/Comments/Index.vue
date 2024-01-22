<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '../Posts/Partials/Post.vue';
import Comment from './Partials/Comment.vue';
import CommentForm from './Partials/CommentForm.vue';

const props = defineProps(['post', 'comments']);

const goBack = () => window.history.back();
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <button  @click="goBack" class="px-4 py-2 text-white bg-blue-300 rounded hover:bg-blue-400"><font-awesome-icon :icon="['fas', 'arrow-left']" /></button>

            <Post :post="post" />

            <Comment v-for="comment in comments"
                :key="comment.id"
                :comment="comment" />

            <CommentForm :post="post" />

        </div>
    </AuthenticatedLayout>
</template>