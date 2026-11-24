<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: '',
    },
    image: {
        type: String,
        required: true,
    },
    video: {
        type: String,
        default: '',
    },
    size: {
        type: String,
        default: 'lg',
        validator: (val) => ['lg', 'md'].includes(val),
    },
    overlay: {
        type: String,
        default: 'default',
        validator: (val) => ['default', 'heavy', 'light'].includes(val),
    },
})

const sizeClasses = {
    lg: 'min-h-screen',
    md: 'min-h-[55vh] md:min-h-[60vh]',
}

const overlayClasses = {
    default: 'hero-overlay',
    heavy: 'hero-overlay-heavy',
    light: 'bg-ink/35 absolute inset-0',
}
</script>

<template>
    <section
        :class="[
            'relative flex items-center justify-center pt-20',
            sizeClasses[size],
        ]"
    >
        <div class="absolute inset-0 overflow-hidden">
            <video
                v-if="video"
                :src="video"
                :poster="image"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                class="absolute inset-0 h-full w-full object-cover"
            />
            <img
                v-else
                :src="image"
                :alt="title"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <div :class="overlayClasses[overlay]" />
        </div>

        <div class="section-container relative z-10 py-16 text-center text-white">
            <h1 class="heading-display">{{ title }}</h1>
            <p v-if="subtitle" class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-white/90 md:text-lg">
                {{ subtitle }}
            </p>
        </div>
    </section>
</template>
