<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const page = usePage()
const settings = computed(() => page.props.settings ?? {})

const values = [
    {
        num: '01',
        title: 'Strategic Investment',
        body: 'We identify and grow impactful businesses through focused capital allocation and long-term planning that creates sustainable returns.',
        dark: true,
    },
    {
        num: '02',
        title: 'Operational Excellence',
        body: 'We foster performance-driven management across our portfolio companies, ensuring execution is always efficient and high-quality.',
        dark: false,
    },
    {
        num: '03',
        title: 'Nation-Building Commitment',
        body: 'We prioritize projects that contribute to Indonesia\'s industrial and infrastructure development, placing national progress at our core.',
        dark: true,
    },
    {
        num: '04',
        title: 'Innovation & Agility',
        body: 'We adapt and innovate to stay ahead in an evolving industrial landscape, embracing change as an opportunity rather than a challenge.',
        dark: false,
    },
    {
        num: '05',
        title: 'Integrity & Transparency',
        body: 'We uphold the highest standards of corporate governance and accountability — internally and in every external partnership we form.',
        dark: true,
    },
    {
        num: '06',
        title: 'Partnership & Collaboration',
        body: 'We grow through trusted alliances with stakeholders, investors, and institutions, believing that shared success creates lasting impact.',
        dark: false,
    },
    {
        num: '07',
        title: 'Synergistic Value Creation',
        body: 'We unlock cross-portfolio synergy to maximize long-term value, connecting our subsidiaries to multiply the impact of every initiative.',
        dark: true,
    },
]
</script>

<style scoped>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
.d-100 { animation-delay: 100ms; }
.d-200 { animation-delay: 200ms; }
.d-300 { animation-delay: 300ms; }

@keyframes clipReveal {
    from { clip-path: inset(0 100% 0 0); }
    to   { clip-path: inset(0 0% 0 0); }
}
.clip-reveal { animation: clipReveal 1.2s cubic-bezier(0.77, 0, 0.175, 1) 0.2s forwards; clip-path: inset(0 100% 0 0); }
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- ============================================================
             HERO — Bottom-aligned editorial
        ============================================================ -->
        <section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <img
                    src="/images/page/about/our-value.png"
                    alt="Our Values"
                    class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>

            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">
                        Azure Group — Our Values
                    </p>
                    <h1
                        class="fade-up d-200 font-bold text-white leading-[1.0] uppercase"
                        style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);"
                    >
                        Our<br><span class="text-[#f15a29]">Values</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        We continuously strive to exceed expectations and achieve superior results — guided by principles embedded in every decision we make.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             INTRO STATEMENT
        ============================================================ -->
        <section class="bg-[#141617] py-24 lg:py-32">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-24 items-center">
                    <div class="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em]">What We Stand For</span>
                        </div>
                        <div class="overflow-hidden rounded-2xl">
                            <img
                                src="/images/page/tagline.png"
                                alt="Values"
                                class="clip-reveal w-full object-cover h-[260px] hover:scale-105 transition-transform duration-700"
                            >
                        </div>
                    </div>
                    <blockquote
                        class="fade-up d-200 font-bold text-white leading-tight"
                        style="font-family:'Saira',sans-serif; font-size:clamp(22px,3vw,40px);"
                    >
                        "By maintaining a steadfast commitment to excellence, we integrate these principles into every facet of our operations — ensuring fulfillment of our promises and the long-term success of our partnerships."
                    </blockquote>
                </div>
            </div>
        </section>

        <!-- ============================================================
             VALUES — Numbered list, same style as Mission in About
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-24 lg:py-36">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-32 items-start">

                    <!-- Left sticky label -->
                    <div class="lg:sticky lg:top-32">
                        <div class="fade-up flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Our Values</span>
                        </div>
                        <h2
                            class="fade-up d-100 font-bold text-[#141617] leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(32px,3.5vw,48px);"
                        >
                            Principles<br>That Guide Us
                        </h2>
                        <div class="fade-up d-200 mt-6 h-px bg-gray-300 w-full"></div>
                    </div>

                    <!-- Right: numbered values -->
                    <div class="space-y-0 divide-y divide-gray-200">
                        <div
                            v-for="(item, i) in values"
                            :key="i"
                            class="fade-up group py-10 flex items-start gap-8 cursor-default transition-transform duration-300 hover:translate-x-2"
                            :style="`animation-delay:${100 + i * 70}ms`"
                        >
                            <span class="text-[#f15a29] font-bold text-sm font-mono pt-1 flex-shrink-0 w-8">{{ item.num }}</span>
                            <div>
                                <h3 class="font-bold text-[#141617] text-lg mb-3 group-hover:text-[#f15a29] transition-colors duration-300" style="font-family:'Saira',sans-serif;">
                                    {{ item.title }}
                                </h3>
                                <p class="text-[#666] leading-relaxed text-[15px]">{{ item.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================
             BACK CTA
        ============================================================ -->
        <section class="bg-[#141617] py-20">
            <div class="section-container text-center">
                <p class="fade-up text-white/40 text-xs font-bold uppercase tracking-[0.3em] mb-6">Continue Exploring</p>
                <Link
                    :href="route('about.index')"
                    class="fade-up d-100 group inline-flex items-center gap-3 font-bold text-sm uppercase tracking-wider text-white border-2 border-white/30 px-8 py-3.5 rounded-full hover:bg-[#f15a29] hover:border-[#f15a29] transition-all duration-300"
                >
                    Back to About Us
                    <svg class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </Link>
            </div>
        </section>

    </div>
</template>
