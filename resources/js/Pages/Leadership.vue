<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    leaders: { type: Array, default: () => [] },
})
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
                    src="/images/page/leadership/AIG-RKAP-2025.jpg"
                    alt="Leadership"
                    class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>

            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">
                        Azure Group — The Team
                    </p>
                    <h1
                        class="fade-up d-200 font-bold text-white leading-[1.0] uppercase"
                        style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);"
                    >
                        Leader<br><span class="text-[#f15a29]">ship</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        Empower capable leaders and uphold transparency to deliver trusted, innovative investment solutions.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             INTRO — Dark section with editorial copy
        ============================================================ -->
        <section class="bg-[#141617] py-24 lg:py-36">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-24 items-center">
                    <div class="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em]">The People</span>
                        </div>
                        <div class="overflow-hidden rounded-2xl">
                            <img
                                src="/images/page/leadership/leader.png"
                                alt="Leadership"
                                class="clip-reveal w-full object-cover h-[260px] hover:scale-105 transition-transform duration-700"
                            >
                        </div>
                    </div>
                    <div>
                        <h2
                            class="fade-up d-100 font-bold text-white leading-tight"
                            style="font-family:'Saira',sans-serif; font-size:clamp(26px,3.5vw,44px);"
                        >
                            Here are some of the people who
                            <em class="not-italic text-[#f15a29]">bring things to life.</em>
                        </h2>
                        <p class="fade-up d-200 mt-8 text-white/60 leading-relaxed" style="font-size:15px;">
                            Our leadership blends expertise and innovation — experienced professionals offering valuable insights and fresh perspectives that drive creativity in every project we undertake.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================================
             LEADERS GRID
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-24 lg:py-36">
            <div class="section-container">

                <div class="fade-up flex items-center gap-4 mb-16">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Our Leaders</span>
                </div>

                <!-- Dynamic leaders from DB -->
                <div v-if="leaders.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200">
                    <div
                        v-for="(leader, i) in leaders"
                        :key="leader.id"
                        class="fade-up bg-white group overflow-hidden"
                        :style="`animation-delay:${100 + i * 70}ms`"
                    >
                        <!-- Photo -->
                        <div class="overflow-hidden aspect-[4/5] bg-gray-100">
                            <img
                                v-if="leader.photo_url"
                                :src="leader.photo_url"
                                :alt="leader.name"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            >
                            <div v-else class="w-full h-full flex items-center justify-center bg-[#f5f5f7]">
                                <svg class="h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="p-8 border-t border-gray-100">
                            <h3 class="font-bold text-[#141617] text-lg group-hover:text-[#f15a29] transition-colors duration-300" style="font-family:'Saira',sans-serif;">
                                {{ leader.name }}
                            </h3>
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mt-1">{{ leader.position }}</p>
                            <p v-if="leader.bio" class="text-[#666] text-[14px] leading-relaxed mt-3">{{ leader.bio }}</p>
                            <a
                                v-if="leader.linkedin_url"
                                :href="leader.linkedin_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-[#0077b5] hover:text-[#f15a29] transition-colors uppercase tracking-wider"
                            >
                                LinkedIn
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fallback placeholder when no data -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200">
                    <div
                        v-for="i in 3"
                        :key="i"
                        class="fade-up bg-white group overflow-hidden"
                        :style="`animation-delay:${100 + i * 70}ms`"
                    >
                        <div class="overflow-hidden aspect-[4/5] bg-gray-100 flex items-center justify-center">
                            <svg class="h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="p-8 border-t border-gray-100">
                            <h3 class="font-bold text-[#141617] text-lg" style="font-family:'Saira',sans-serif;">
                                Executive Name
                            </h3>
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mt-1">Position Title</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</template>
