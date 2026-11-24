<script setup>
import { onMounted, onUnmounted, ref } from 'vue'
import { ChevronUpIcon } from '@heroicons/vue/24/outline'

const visible = ref(false)

function handleScroll() {
    visible.value = window.scrollY > 400
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
    handleScroll()
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <button
        v-show="visible"
        type="button"
        aria-label="Back to top"
        class="fixed bottom-6 right-6 z-40 flex h-10 w-10 items-center justify-center border border-white/20 bg-ink text-white transition-colors hover:border-brand hover:text-brand"
        @click="scrollToTop"
    >
        <ChevronUpIcon class="h-5 w-5" />
    </button>
</template>
