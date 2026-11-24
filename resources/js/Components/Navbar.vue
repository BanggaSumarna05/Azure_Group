<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const isMenuOpen = ref(false)
const isScrolled = ref(false)
const isHovered = ref(false)
const isAboutOpen = ref(false)

const isHome = computed(() => route().current('home'))
const isSolidNav = computed(() => isHovered.value || (isScrolled.value && !isHome.value))

function isActive(routeName) {
    return route().current(routeName)
}

function navLinkClass(routeName, extra = '') {
    const active = isActive(routeName)
    const base = 'text-[13px] font-bold uppercase tracking-wider transition-colors'

    if (isSolidNav.value) {
        return [
            base,
            extra,
            active ? 'text-[#f15a29]' : 'text-[#141617] opacity-90 hover:opacity-100 hover:text-[#f15a29]',
        ]
    }

    return [
        base,
        extra,
        active ? 'text-[#f15a29]' : 'text-white opacity-90 hover:opacity-100 hover:text-white',
    ]
}

function aboutButtonClass() {
    const base = 'flex items-center gap-1 text-[13px] font-bold uppercase tracking-wider transition-colors'

    if (isSolidNav.value) {
        return [
            base,
            route().current('about.*') ? 'text-[#f15a29]' : 'text-[#141617] opacity-90 hover:opacity-100 hover:text-[#f15a29]',
        ]
    }

    return [
        base,
        route().current('about.*') ? 'text-[#f15a29]' : 'text-white opacity-90 hover:opacity-100 hover:text-white',
    ]
}

const navClasses = computed(() => {
    const classes = ['fixed inset-x-0 top-0 z-50 transition-all duration-300 rounded-b-2xl']

    if (isSolidNav.value) {
        classes.push('bg-white')
        if (isScrolled.value) {
            classes.push('shadow-[0_2px_12px_rgba(0,0,0,0.1)]')
        }
    } else {
        classes.push('bg-transparent')
        if (isScrolled.value) {
            classes.push('shadow-[0_4px_20px_rgba(0,0,0,0.25)]')
        }
    }

    return classes
})

function handleScroll() {
    isScrolled.value = window.scrollY > 60
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
    <nav
        :class="navClasses"
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false"
    >
        <div class="flex h-14 items-center justify-between px-4 lg:h-16 lg:px-8">

            <!-- Logo -->
            <Link
                :href="route('home')"
                class="flex shrink-0 items-center transition-opacity hover:opacity-80"
                aria-label="Home"
            >
                <img src="/images/page/logo.png" alt="Azure Group" class="h-10 w-auto object-contain lg:h-11">
            </Link>

            <!-- Centered Desktop Nav -->
            <div class="hidden flex-1 justify-center lg:flex">
                <div class="flex items-center gap-6">
                    <Link :href="route('home')" :class="navLinkClass('home')">
                        HOME
                    </Link>

                    <!-- About Dropdown -->
                    <div class="relative" @mouseenter="isAboutOpen = true" @mouseleave="isAboutOpen = false">
                        <button type="button" :class="aboutButtonClass()">
                            ABOUT US
                        </button>

                        <!-- Dropdown -->
                        <transition
                            enter-active-class="transition duration-150 ease-out"
                            enter-from-class="opacity-0 translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 translate-y-1"
                        >
                            <div
                                v-show="isAboutOpen"
                                class="absolute left-0 top-full mt-2 min-w-[180px] bg-white py-2"
                                style="border: 1px solid #eeeeee; border-radius: 4px; box-shadow: rgba(0,0,0,0.1) 4px 8px 20px 0px;"
                            >
                                <Link
                                    :href="route('about.index')"
                                    class="block px-5 py-2.5 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                                    @click="isAboutOpen = false"
                                >
                                    ABOUT US
                                </Link>
                                <Link
                                    :href="route('about.our-value')"
                                    class="block px-5 py-2.5 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                                    @click="isAboutOpen = false"
                                >
                                    OUR VALUE
                                </Link>
                            </div>
                        </transition>
                    </div>

                    <Link :href="route('portfolio.index')" :class="navLinkClass('portfolio.index')">
                        PORTFOLIO
                    </Link>

                    <Link :href="route('leadership')" :class="navLinkClass('leadership')">
                        LEADERSHIP
                    </Link>

                    <Link :href="route('career.index')" :class="navLinkClass('career.index')">
                        CAREER
                    </Link>

                    <Link :href="route('blog.index')" :class="navLinkClass('blog.index')">
                        BLOG
                    </Link>
                </div>
            </div>

            <!-- Right Tagline (Desktop only) -->
            <div class="hidden shrink-0 lg:block">
                <img
                    src="/images/page/tagline.png"
                    alt="Investing Today, Transforming Tomorrow"
                    :class="[
                        'h-8 w-auto object-contain lg:h-25 transition-all duration-300',
                        
                    ]"
                >
            </div>

            <!-- Mobile Toggle -->
            <button
                type="button"
                :class="[
                    'flex h-9 w-9 shrink-0 items-center justify-center lg:hidden transition-colors',
                    isSolidNav ? 'text-[#141617]' : 'text-white',
                ]"
                aria-label="Toggle menu"
                @click="isMenuOpen = !isMenuOpen"
            >
                <svg v-if="!isMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div
                v-show="isMenuOpen"
                class="border-t bg-white lg:hidden rounded-b-2xl"
                style="border-color: #eeeeee;"
            >
                <div class="section-container space-y-0 py-3 text-center">
                    <Link
                        :href="route('home')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        HOME
                    </Link>
                    <Link
                        :href="route('about.index')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        ABOUT US
                    </Link>
                    <Link
                        :href="route('about.our-value')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        OUR VALUE
                    </Link>
                    <Link
                        :href="route('portfolio.index')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        PORTFOLIO
                    </Link>
                    <Link
                        :href="route('leadership')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        LEADERSHIP
                    </Link>
                    <Link
                        :href="route('career.index')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        CAREER
                    </Link>
                    <Link
                        :href="route('blog.index')"
                        class="block py-3 text-[13px] font-bold uppercase tracking-wider text-[#141617] transition-colors hover:bg-gray-50 hover:text-[#f15a29]"
                        @click="isMenuOpen = false"
                    >
                        BLOG
                    </Link>
                </div>
            </div>
        </transition>
    </nav>
</template>
