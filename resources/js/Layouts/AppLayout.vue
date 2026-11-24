<script setup>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
</script>

<template>
    <div class="min-h-screen bg-white">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-white focus:px-4 focus:py-2">
            Skip to main content
        </a>
        <Navbar />
        <main id="main-content">
            <slot />
        </main>
        <Footer />
    </div>
</template>
