<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    portfolios: { type: Array, default: () => [] },
})

const subsidiaries = [
    { name: 'Raya Konstruksi', sector: 'Construction', tagline: 'Building Indonesia\'s infrastructure with precision and integrity.' },
    { name: 'ASRAYA', sector: 'Infrastructure', tagline: 'Delivering large-scale infrastructure projects across the archipelago.' },
    { name: 'SWADAYARAYA', sector: 'Engineering', tagline: 'Engineering solutions that power industrial advancement.' },
    { name: 'RAPID', sector: 'Development', tagline: 'Accelerating development with agile project execution.' },
    { name: 'prospero', sector: 'Investment', tagline: 'Strategic investment vehicles for long-term wealth creation.' },
    { name: 'pekerjakita.', sector: 'HR Platform', tagline: 'Connecting Indonesia\'s workforce with opportunity.' },
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
             HERO
        ============================================================ -->
        <section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <img
                    src="/images/page/simon.jpg"
                    alt="Portfolio"
                    class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>

            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">
                        Azure Group — Our Companies
                    </p>
                    <h1
                        class="fade-up d-200 font-bold text-white leading-[1.0] uppercase"
                        style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);"
                    >
                        Port<br><span class="text-[#f15a29]">folio</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        Each subsidiary makes significant contributions to its respective industry, driven by our commitment to sustainable industrial growth.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             CONTEXT — Dark editorial intro
        ============================================================ -->
        <section class="bg-[#141617] py-24 lg:py-36">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-24 items-start">
                    <div class="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em]">Our Subsidiaries</span>
                        </div>
                        <div class="overflow-hidden rounded-2xl">
                            <img
                                src="/images/page/home/section2.jpg"
                                alt="Portfolio"
                                class="clip-reveal w-full object-cover h-[260px] hover:scale-105 transition-transform duration-700"
                            >
                        </div>
                    </div>

                    <div>
                        <h2
                            class="fade-up d-100 font-bold text-white leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(24px,3vw,40px);"
                        >
                            Majority stakeholders shape direction.
                            Minority stakeholders protect rights.
                            <em class="not-italic text-[#f15a29]">Together, they build lasting companies.</em>
                        </h2>
                        <p class="fade-up d-200 mt-8 text-white/60 leading-relaxed" style="font-size:15px;">
                            In the realm of corporate ownership, understanding the difference between majority and minority stakeholders is key to grasping how control, decision-making authority, and financial interests are distributed — and how we as a holding company orchestrate that balance across our portfolio.
                        </p>

                        <!-- Stat strip -->
                        <div class="fade-up d-300 mt-10 grid grid-cols-3 gap-px bg-white/10 rounded-2xl overflow-hidden">
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-[#f15a29] text-3xl" style="font-family:'Saira',sans-serif;">6+</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Companies</p>
                            </div>
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-white text-3xl" style="font-family:'Saira',sans-serif;">6+</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Years</p>
                            </div>
                            <div class="bg-[#1a1b1c] px-6 py-7 text-center">
                                <p class="font-bold text-white text-3xl" style="font-family:'Saira',sans-serif;">IDN</p>
                                <p class="text-white/40 text-xs uppercase tracking-widest mt-1">Market</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================
             SUBSIDIARIES — Rich card grid
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-24 lg:py-36">
            <div class="section-container">

                <div class="fade-up flex items-center gap-4 mb-16">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Subsidiaries</span>
                </div>

                <!-- Dynamic from DB -->
                <div v-if="portfolios.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <Link
                        v-for="(p, i) in portfolios"
                        :key="p.id"
                        :href="route('portfolio.show', p.slug)"
                        class="fade-up group relative flex flex-col items-center justify-center bg-white border border-gray-100 rounded-2xl p-8 aspect-square shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                        :style="`animation-delay:${100 + i * 50}ms`"
                    >
                        <!-- Sector badge -->
                        <span class="absolute top-3 right-3 text-[9px] font-bold uppercase tracking-wider text-[#f15a29] bg-[#f15a29]/10 px-2 py-1 rounded-full">
                            {{ p.sector }}
                        </span>

                        <!-- Logo image -->
                        <div class="w-full flex items-center justify-center" style="height:80px;">
                            <img
                                v-if="p.logo_url"
                                :src="p.logo_url"
                                :alt="p.name"
                                class="max-h-full max-w-full object-contain transition-all duration-300 group-hover:scale-105"
                            >
                            <!-- Fallback: company initial -->
                            <span
                                v-else
                                class="font-bold text-[#141617]/20 group-hover:text-[#f15a29]/30 transition-colors duration-300"
                                style="font-family:'Saira',sans-serif; font-size:clamp(40px,6vw,72px); line-height:1;"
                            >
                                {{ p.name.charAt(0) }}
                            </span>
                        </div>

                        <!-- Name -->
                        <p class="mt-4 text-center text-sm font-bold text-[#141617] group-hover:text-[#f15a29] transition-colors duration-300" style="font-family:'Saira',sans-serif;">
                            {{ p.name }}
                        </p>
                    </Link>
                </div>

                <!-- Static fallback -->
                <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div
                        v-for="(s, i) in subsidiaries"
                        :key="i"
                        class="fade-up group relative flex flex-col items-center justify-center bg-white border border-gray-100 rounded-2xl p-8 aspect-square shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-default"
                        :style="`animation-delay:${100 + i * 50}ms`"
                    >
                        <span class="absolute top-3 right-3 text-[9px] font-bold uppercase tracking-wider text-[#f15a29] bg-[#f15a29]/10 px-2 py-1 rounded-full">
                            {{ s.sector }}
                        </span>
                        <span
                            class="font-bold text-[#141617]/20 group-hover:text-[#f15a29]/30 transition-colors duration-300"
                            style="font-family:'Saira',sans-serif; font-size:clamp(40px,6vw,72px); line-height:1;"
                        >
                            {{ s.name.charAt(0) }}
                        </span>
                        <p class="mt-4 text-center text-sm font-bold text-[#141617] group-hover:text-[#f15a29] transition-colors duration-300" style="font-family:'Saira',sans-serif;">
                            {{ s.name }}
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </div>
</template>
