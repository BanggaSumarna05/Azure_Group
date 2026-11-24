<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'sector',
        validator: (val) => ['sector', 'type', 'status', 'brand'].includes(val),
    },
})

const styles = {
    /* Portfolio sector — subtle dark */
    sector: {
        display: 'inline-block',
        padding: '3px 10px',
        fontSize: '11px',
        fontWeight: '500',
        letterSpacing: '0.05em',
        textTransform: 'uppercase',
        background: 'rgba(20, 22, 23, 0.07)',
        color: '#141617',
        borderRadius: '4px',
    },
    /* Career type — brand orange tint */
    type: {
        display: 'inline-block',
        padding: '3px 10px',
        fontSize: '11px',
        fontWeight: '600',
        letterSpacing: '0.05em',
        textTransform: 'uppercase',
        background: 'rgba(241, 90, 41, 0.12)',
        color: '#d94d1f',
        borderRadius: '4px',
    },
    /* Status — green (published) */
    status: {
        display: 'inline-block',
        padding: '2px 10px',
        fontSize: '11px',
        fontWeight: '500',
        letterSpacing: '0.04em',
        textTransform: 'uppercase',
        background: 'rgba(40, 167, 69, 0.12)',
        color: '#1a7a30',
        borderRadius: '50px',
    },
    /* Brand highlight */
    brand: {
        display: 'inline-block',
        padding: '3px 12px',
        fontSize: '11px',
        fontWeight: '600',
        letterSpacing: '0.05em',
        textTransform: 'uppercase',
        background: '#f15a29',
        color: '#ffffff',
        borderRadius: '50px',
    },
}
</script>

<template>
    <span :style="styles[type]">
        <slot />
    </span>
</template>
