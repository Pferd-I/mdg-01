<template>
    <transition name="slide-fade">
        <div
            v-if="visible"
            class="fixed top-5 right-5 z-50 min-w-[250px] px-4 py-3 rounded-lg text-white shadow-lg"
            :class="bgColor"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    message: { type: String, default: null },
    type: { type: String, default: 'success' },
    duration: { type: Number, default: 3000 }
})

const visible = ref(false)

const bgColor = props.type === 'success'
    ? 'bg-green-600'
    : 'bg-red-600'

watch(
    () => props.message,
    (msg) => {
        if (msg) {
            visible.value = true
            setTimeout(() => {
                visible.value = false
            }, props.duration)
        }
    },
    { immediate: true }
)
</script>

<style>
.slide-fade-enter-active {
    transition: all .4s ease;
}
.slide-fade-leave-active {
    transition: all .4s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
</style>
