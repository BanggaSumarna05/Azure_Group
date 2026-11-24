<template>
    <div
        class="bg-white transition-all duration-300 hover:-translate-y-1"
        style="border: 1px solid #dddddd; border-radius: 4px; box-shadow: rgba(19,21,22,0.04) 0px 2px 8px;"
        @mouseenter="$el.style.boxShadow = 'rgba(19,21,22,0.1) 10px 10px 25px 5px'"
        @mouseleave="$el.style.boxShadow = 'rgba(19,21,22,0.04) 0px 2px 8px'"
    >
        <slot />
    </div>
</template>
