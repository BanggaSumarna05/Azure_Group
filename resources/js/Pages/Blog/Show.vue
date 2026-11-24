<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Badge from '@/Components/ui/Badge.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    related: {
        type: Array,
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
            <!-- Background: cover image atau dark fallback -->
            <div class="absolute inset-0 bg-[#141617]"></div>
            <img
                v-if="post.cover_url"
                :src="post.cover_url"
                :alt="post.title"
                class="absolute inset-0 h-full w-full object-cover z-[1]"
                @error="(e) => e.target.style.display='none'"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/40 to-transparent z-[2]"></div>

            <div class="relative z-[3] w-full section-container pb-16 lg:pb-24">
                <!-- Breadcrumb -->
                <nav class="fade-up mb-6 flex items-center gap-2 text-white/40 text-xs font-bold uppercase tracking-widest">
                    <Link :href="route('home')" class="hover:text-white transition-colors">Home</Link>
                    <span>/</span>
                    <Link :href="route('blog.index')" class="hover:text-white transition-colors">Blog</Link>
                    <span>/</span>
                    <span class="text-white/70">Article</span>
                </nav>

                <div class="flex items-center gap-3 mb-5">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <Badge v-if="post.category" type="brand">{{ post.category.name }}</Badge>
                </div>

                <h1
                    class="fade-up d-100 font-bold text-white leading-tight"
                    style="font-family:'Saira',sans-serif; font-size:clamp(28px,4.5vw,56px); max-width:900px;"
                >
                    {{ post.title }}
                </h1>

                <div class="fade-up d-200 mt-6 flex items-center gap-4 text-white/50 text-sm font-medium tracking-wide">
                    <span>{{ post.published_at }}</span>
                    <span v-if="post.author" class="flex items-center gap-2">
                        <span class="h-1 w-1 rounded-full bg-[#f15a29]"></span>
                        {{ post.author.name }}
                    </span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             ARTICLE BODY
        ============================================================ -->
        <section class="bg-white py-20 lg:py-28">
            <div class="section-container">
                <div class="grid lg:grid-cols-[2fr_1fr] gap-16 lg:gap-24 items-start">

                    <!-- Article -->
                    <article class="prose-azure">
                        <div v-html="post.body" />

                        <div class="mt-16 pt-8 border-t border-gray-100">
                            <Link
                                :href="route('blog.index')"
                                class="group inline-flex items-center gap-2 font-bold text-sm uppercase tracking-wider text-[#141617] hover:text-[#f15a29] transition-colors"
                            >
                                <svg class="h-4 w-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Back to Blog
                            </Link>
                        </div>
                    </article>

                    <!-- Sidebar -->
                    <aside class="lg:sticky lg:top-32 space-y-4">
                        <div class="bg-[#141617] rounded-2xl p-8">
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-4">Publication</p>
                            <p class="text-white font-bold">{{ post.published_at }}</p>
                            <p v-if="post.author" class="text-white/40 text-sm mt-2">{{ post.author.name }}</p>
                        </div>
                        <div v-if="post.category" class="bg-[#f5f5f7] rounded-2xl p-8">
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-3">Category</p>
                            <p class="font-bold text-[#141617]">{{ post.category.name }}</p>
                        </div>
                    </aside>

                </div>
            </div>
        </section>

        <!-- ============================================================
             RELATED ARTICLES
        ============================================================ -->
        <section v-if="related.length > 0" class="bg-[#f5f5f7] py-24 lg:py-32">
            <div class="section-container">

                <div class="flex items-center gap-4 mb-12">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Related Articles</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-px bg-gray-200">
                    <Link
                        v-for="item in related"
                        :key="item.id"
                        :href="route('blog.show', item.slug)"
                        class="bg-white group overflow-hidden block"
                    >
                        <div class="overflow-hidden aspect-[16/10]">
                            <img
                                :src="item.cover_url"
                                :alt="item.title"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            >
                        </div>
                        <div class="p-8 border-t border-gray-100">
                            <h3 class="font-bold text-[#141617] leading-snug group-hover:text-[#f15a29] transition-colors duration-300" style="font-family:'Saira',sans-serif; font-size:16px;">
                                {{ item.title }}
                            </h3>
                            <div class="mt-4 flex items-center gap-2 text-[#141617]/30 text-xs font-bold uppercase tracking-widest group-hover:text-[#f15a29] transition-colors duration-300">
                                Read More
                                <svg class="h-3 w-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </Link>
                </div>

            </div>
        </section>

    </div>
</template>
