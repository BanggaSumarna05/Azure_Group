<script setup>
const props = defineProps({
    src: {
        type: String,
        default: '',
    },
    poster: {
        type: String,
        default: '/images/hero-fallback.svg',
    },
})
</script>

<template>
    <div class="absolute inset-0 overflow-hidden">
        <video
            v-if="src"
            :src="src"
            :poster="poster"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            class="absolute inset-0 h-full w-full object-cover"
        />
        <img
            v-else
            :src="poster || '/images/hero-fallback.svg'"
            alt="Azure Group"
            class="absolute inset-0 h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-azure-dark/60" />
    </div>
</template>
