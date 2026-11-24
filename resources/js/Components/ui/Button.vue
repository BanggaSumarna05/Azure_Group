<script setup>
const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator: (val) => ['primary', 'outline', 'ghost', 'ghost-white', 'ghost-dark'].includes(val),
    },
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: 'md',
        validator: (val) => ['sm', 'md', 'lg'].includes(val),
    },
})

const baseClasses = 'inline-flex items-center justify-center font-semibold uppercase tracking-[0.05em] transition-all duration-300 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50'

const variantStyles = {
    /* Default CTA — brand orange */
    primary: {
        backgroundColor: '#f15a29',
        color: '#ffffff',
        border: 'none',
        borderRadius: '4px',
    },
    /* Outline — brand orange border */
    outline: {
        backgroundColor: 'transparent',
        color: '#f15a29',
        border: '2px solid #f15a29',
        borderRadius: '4px',
    },
    /* Ghost — transparent white text (for dark backgrounds) */
    ghost: {
        backgroundColor: 'transparent',
        color: '#ffffff',
        border: '2px solid rgba(255,255,255,0.5)',
        borderRadius: '4px',
    },
    /* Ghost white — alias of ghost */
    'ghost-white': {
        backgroundColor: 'transparent',
        color: '#ffffff',
        border: '2px solid rgba(255,255,255,0.5)',
        borderRadius: '4px',
    },
    /* Ghost dark — transparent dark text */
    'ghost-dark': {
        backgroundColor: 'transparent',
        color: '#141617',
        border: '2px solid #141617',
        borderRadius: '4px',
    },
}

const sizeStyles = {
    sm: { padding: '8px 20px', fontSize: '12px' },
    md: { padding: '11px 28px', fontSize: '13px' },
    lg: { padding: '14px 36px', fontSize: '14px' },
}

const computedStyle = {
    ...variantStyles[props.variant],
    ...sizeStyles[props.size],
    cursor: props.disabled ? 'not-allowed' : 'pointer',
    opacity: props.disabled ? '0.5' : '1',
}
</script>

<template>
    <component
        :is="href ? 'a' : 'button'"
        :href="href"
        :type="href ? undefined : type"
        :disabled="disabled"
        :class="baseClasses"
        :style="computedStyle"
        @mouseenter="!disabled && ($el.style.opacity = '0.88', $el.style.transform = 'translateY(-1px)')"
        @mouseleave="!disabled && ($el.style.opacity = '1', $el.style.transform = 'translateY(0)')"
    >
        <slot />
    </component>
</template>
