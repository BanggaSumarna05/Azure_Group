<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Badge from '@/Components/ui/Badge.vue'
import Button from '@/Components/ui/Button.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    portfolio: {
        type: Object,
        required: true,
    },
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
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- ============================================================
             HERO
        ============================================================ -->
        <section class="relative h-[70vh] min-h-[500px] flex items-end overflow-hidden">
            <img
                v-if="portfolio.cover_url"
                :src="portfolio.cover_url"
                :alt="portfolio.name"
                class="absolute inset-0 h-full w-full object-cover"
            >
            <div
                v-else
                class="absolute inset-0 bg-[#141617]"
                style="background-image: radial-gradient(circle at 30% 50%, rgba(241,90,41,0.12) 0%, transparent 60%);"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/50 to-transparent"></div>

            <div class="relative z-10 w-full section-container pb-16 lg:pb-24">
                <Link :href="route('portfolio.index')" class="fade-up mb-6 inline-flex items-center gap-2 text-white/50 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Portfolio
                </Link>

                <div class="flex items-center gap-3 mb-5">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <Badge type="brand">{{ portfolio.sector }}</Badge>
                </div>

                <h1
                    class="fade-up d-100 font-bold text-white leading-tight uppercase"
                    style="font-family:'Saira',sans-serif; font-size:clamp(40px,6vw,80px);"
                >
                    {{ portfolio.name }}
                </h1>

                <p v-if="portfolio.tagline" class="fade-up d-200 mt-5 text-white/70 max-w-2xl leading-relaxed" style="font-size:16px;">
                    {{ portfolio.tagline }}
                </p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             MAIN CONTENT
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-24 lg:py-32">
            <div class="section-container">
                <div class="grid lg:grid-cols-[2fr_1fr] gap-12 lg:gap-20 items-start">

                    <!-- Article -->
                    <div class="bg-white p-10 lg:p-14 rounded-2xl border border-gray-100 shadow-sm">
                        <div v-if="portfolio.logo_url" class="mb-10">
                            <img :src="portfolio.logo_url" :alt="portfolio.name" class="h-16 object-contain">
                        </div>
                        <div class="prose-azure" v-html="portfolio.description" />
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:sticky lg:top-32 space-y-4">
                        <div class="bg-[#141617] rounded-2xl p-8">
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-4">Company</p>
                            <h3 class="text-white font-bold text-xl mb-1" style="font-family:'Saira',sans-serif;">{{ portfolio.name }}</h3>
                            <p v-if="portfolio.sector" class="text-white/40 text-sm">{{ portfolio.sector }}</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a
                                v-if="portfolio.website_url"
                                :href="portfolio.website_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="w-full inline-flex items-center justify-center gap-2 font-bold text-sm uppercase tracking-wider text-white bg-[#f15a29] px-6 py-3.5 rounded-full hover:bg-[#d94e22] transition-colors duration-300"
                            >
                                Visit Website
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <Link
                                :href="route('portfolio.index')"
                                class="w-full inline-flex items-center justify-center gap-2 font-bold text-sm uppercase tracking-wider text-[#141617] border-2 border-[#141617] px-6 py-3.5 rounded-full hover:bg-[#141617] hover:text-white transition-all duration-300"
                            >
                                All Portfolio
                            </Link>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
</template>
