<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm dark:text-slate-950 font-bold">
            {{ message }}
        </p>
    </div>
</template>
