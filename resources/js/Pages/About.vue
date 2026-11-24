<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const page = usePage()
const settings = computed(() => page.props.settings ?? {})
</script>

<style scoped>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes lineGrow {
    from { width: 0; }
    to   { width: 100%; }
}

.fade-up { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
.d-100  { animation-delay: 100ms; }
.d-200  { animation-delay: 200ms; }
.d-300  { animation-delay: 300ms; }
.d-400  { animation-delay: 400ms; }
.d-500  { animation-delay: 500ms; }

.line-grow { animation: lineGrow 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

/* Clip reveal for hero image */
@keyframes clipReveal {
    from { clip-path: inset(0 100% 0 0); }
    to   { clip-path: inset(0 0% 0 0); }
}
.clip-reveal { animation: clipReveal 1.2s cubic-bezier(0.77, 0, 0.175, 1) 0.2s forwards; clip-path: inset(0 100% 0 0); }

.mission-item { transition: transform 0.3s ease; }
.mission-item:hover { transform: translateX(8px); }

.value-card { transition: background-color 0.3s ease, color 0.3s ease; }
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- ============================================================
             HERO — Full bleed, editorial
        ============================================================ -->
        <section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
            <!-- Background image -->
            <div class="absolute inset-0">
                <img
                    src="/images/page/home/section2.jpg"
                    alt="Azure Group"
                    class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100"
                >
                <!-- Gradient: dark at bottom, lighter at top -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>

            <!-- Hero text — bottom aligned, editorial -->
            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">
                        Azure Group — Who We Are
                    </p>
                    <h1
                        class="fade-up d-200 font-bold text-white leading-[1.0] uppercase"
                        style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);"
                    >
                        About<br><span class="text-[#f15a29]">Us</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        A  company built on conviction — scaling Indonesia's most impactful
                        industrial and infrastructure ventures for the long term.
                    </p>
                </div>
            </div>

            <!-- Bottom rule -->
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             INTRO STATEMENT — Large editorial quote
        ============================================================ -->
        <section class="bg-[#141617] py-24 lg:py-36">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-24 items-start">
                    <!-- Left: label -->
                    <div class="fade-up">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em]">Our Story</span>
                        </div>
                        <div class="overflow-hidden rounded-2xl">
                            <img
                                src="/images/page/about/cropped-FA_LOGO_AZURE-INVESTAMA-02-512x441.png"
                                alt="Azure Group Leadership"
                                class="clip-reveal w-full object-cover h-[280px] lg:h-[340px] hover:scale-105 transition-transform duration-700"
                            >
                        </div>
                    </div>

                    <!-- Right: editorial copy -->
                    <div>
                        <blockquote
                            class="fade-up d-200 font-bold text-white leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(26px,3.5vw,44px);"
                        >
                            "Supporting our subsidiaries is only the beginning of our community loop business journey."
                        </blockquote>

                        <div class="fade-up d-300 mt-10 space-y-5 text-white/60 leading-relaxed" style="font-size:15px;">
                            <p>
                                As a  company, we accelerate the growth of portfolio companies by
                                integrating professional project management capabilities — ensuring delivery
                                on schedule, within budget, and to the highest quality standards.
                            </p>
                            <p>
                                This strengthens trust with clients and drives sustainable transformation
                                across every industry we serve.
                            </p>
                        </div>

                        <!-- Key stat strip -->
                        <div class="fade-up d-400 mt-12 grid grid-cols-3 gap-px bg-white/10 rounded-2xl overflow-hidden">
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-white text-3xl" style="font-family:'Saira',sans-serif;">6+</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Years</p>
                            </div>
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-[#f15a29] text-3xl" style="font-family:'Saira',sans-serif;">5+</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Portfolio</p>
                            </div>
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-white text-3xl" style="font-family:'Saira',sans-serif;">IDN</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Focus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================
             AZURE GROUP DESCRIPTION
        ============================================================ -->
        <section class="py-24 lg:py-32 bg-white">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-12 lg:gap-24 items-start">
                    <!-- Left: title -->
                    <div class="fade-up">
                        <h2
                            class="font-bold text-[#141617] uppercase leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(28px,3vw,40px);"
                        >
                            AZURE<br><span class="text-[#f15a29]">GROUP</span>
                        </h2>
                        <div class="mt-5 h-1 w-12 bg-[#f15a29] rounded-full"></div>
                    </div>
                    <!-- Right: body -->
                    <p class="fade-up d-100 text-[#555] leading-loose" style="font-size:clamp(15px,1.5vw,17px);">
                        As a  company, we focus on accelerating the growth of our portfolio companies
                        by integrating professional in-house project management capabilities. This ensures that
                        projects are delivered on schedule, within budget, and to the highest quality standards
                        — strengthening trust with clients and driving sustainable transformation in the
                        industries we serve.
                    </p>
                </div>
            </div>
        </section>

        <!-- ============================================================
             VISION — Full-width, stark
        ============================================================ -->
        <section class="py-24 lg:py-36 bg-white border-b border-gray-100">
            <div class="section-container">
                <!-- Label -->
                <div class="fade-up flex items-center gap-4 mb-16">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Vision</span>
                </div>

                <!-- Large vision text -->
                <h2
                    class="fade-up d-100 font-bold text-[#141617] leading-tight max-w-5xl"
                    style="font-family:'Saira',sans-serif; font-size:clamp(28px,4vw,52px);"
                >
                    To become Indonesia's leading
                    construction-focused industrial  group,
                    driving national development through
                    <em class="not-italic text-[#f15a29]">sustainable infrastructure growth</em>
                    and long-term value creation.
                </h2>
            </div>
        </section>

        <!-- ============================================================
             MISSION — Numbered list, asymmetric
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-24 lg:py-36">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-32 items-start">

                    <!-- Left sticky label block -->
                    <div class="lg:sticky lg:top-32">
                        <div class="fade-up flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Mission</span>
                        </div>
                        <h2
                            class="fade-up d-100 font-bold text-[#141617] leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(32px,3.5vw,48px);"
                        >
                            What We're<br>Here To Do
                        </h2>
                        <div class="fade-up d-200 mt-6 h-px bg-gray-300 w-full"></div>
                    </div>

                    <!-- Right: numbered missions -->
                    <div class="space-y-0 divide-y divide-gray-200">
                        <div
                            v-for="(item, i) in [
                                { num: '01', title: 'Champion Strategic Investments', body: 'Identify and support construction and infrastructure investments that accelerate Indonesia\'s industrial advancement and regional connectivity.' },
                                { num: '02', title: 'Build Trust & Alliances', body: 'Foster inclusive growth and form enduring alliances with partners and stakeholders that contribute to national progress.' },
                                { num: '03', title: 'Elevate Operational Excellence', body: 'Deliver resource-efficient, timely, and high-quality project execution across all portfolio companies.' },
                                { num: '04', title: 'Empower Our People', body: 'Cultivate a values-driven culture grounded in integrity, collaboration, and innovation — empowering teams as catalysts for transformation.' },
                            ]"
                            :key="i"
                            class="mission-item fade-up group py-10 flex items-start gap-8 cursor-default"
                            :style="`animation-delay:${100 + i * 80}ms`"
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
             OUR VALUES CTA — Dark, full-bleed image
        ============================================================ -->
        <section class="relative overflow-hidden min-h-[60vh] flex items-center">
            <!-- Background -->
            <div class="absolute inset-0">
                <img
                    src="/images/page/about/our-value.png"
                    alt="Our Values"
                    class="w-full h-full object-cover"
                >
                <div class="absolute inset-0 bg-[#141617]/80"></div>
            </div>

            <div class="relative z-10 section-container py-24 lg:py-36">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="fade-up flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Our Values</span>
                        </div>
                        <h2
                            class="fade-up d-100 font-bold text-white leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(32px,4vw,52px);"
                        >
                            Principles That<br>Drive Everything
                        </h2>
                    </div>
                    <div>
                        <p class="fade-up d-200 text-white/60 leading-relaxed text-[16px] mb-10">
                            By maintaining a steadfast commitment to excellence, we integrate these principles
                            into every facet of our operations — ensuring fulfillment of our promises and the
                            long-term success of our partnerships.
                        </p>

                        <!-- Value tags -->
                        <div class="fade-up d-300 flex flex-wrap gap-3 mb-10">
                            <span v-for="v in ['Strategic Investment','Operational Excellence','Integrity','Innovation','Partnership','Nation-Building']" :key="v"
                                class="border border-white/20 text-white/70 text-xs font-semibold uppercase tracking-wider px-4 py-2 rounded-full hover:border-[#f15a29] hover:text-[#f15a29] transition-colors duration-300 cursor-default"
                            >{{ v }}</span>
                        </div>

                        <div class="fade-up d-400">
                            <Link
                                :href="route('about.our-value')"
                                class="group inline-flex items-center gap-3 font-bold text-sm uppercase tracking-wider text-white border-2 border-white px-8 py-3.5 rounded-full hover:bg-[#f15a29] hover:border-[#f15a29] transition-all duration-300"
                            >
                                Explore Our Values
                                <svg class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>
