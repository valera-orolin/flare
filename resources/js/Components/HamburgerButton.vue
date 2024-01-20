<script setup>
import { ref } from 'vue';

const emit = defineEmits(['update:isOpen']);

const isOpen = ref(false);

const toggleMenu = () => {
    isOpen.value = !isOpen.value;
    emit('update:isOpen', isOpen.value);
};
</script>

<template>
    <button 
        id="menu-btn" 
        class="block hamburger mt-2 mr-2 ml-auto focus:outline-none lg:hidden" 
        :class="{ open: isOpen }"
        @click="toggleMenu"
    >
        <span class="hamburger-top"></span>
        <span class="hamburger-middle"></span>
        <span class="hamburger-bottom"></span>
    </button>
</template>
