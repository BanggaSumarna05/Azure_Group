<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href: {
        type: String,
        required: true,
    },
    light: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <Link
        :href="href"
        :class="[
            'inline-flex items-center gap-1 text-base font-semibold transition-colors hover:text-brand',
            light ? 'text-white hover:text-brand' : 'text-ink',
        ]"
    >
        Discover More
        <span aria-hidden="true">&gt;</span>
    </Link>
</template>
