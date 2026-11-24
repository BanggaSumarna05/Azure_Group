<script setup>
import { ref, computed, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    posts: { type: Object, default: () => ({ data: [], meta: {} }) },
    categories: { type: Array, default: () => [] },
    activeCategory: { type: String, default: null },
})

/* ── State ── */
const allPosts  = ref([...(props.posts?.data ?? [])])
const meta      = ref(props.posts?.meta ?? {})
const isLoading = ref(false)

/* Sync saat props berubah (misal filter kategori berubah) */
watch(() => props.posts, (val) => {
    allPosts.value = [...(val?.data ?? [])]
    meta.value     = val?.meta ?? {}
}, { deep: true })

const hasMore = computed(() => (meta.value.current_page ?? 1) < (meta.value.last_page ?? 1))

/* ── Load More handler ── */
function loadMore() {
    if (isLoading.value || !hasMore.value) return

    isLoading.value = true
    const nextPage  = (meta.value.current_page ?? 1) + 1
    const params    = { page: nextPage }
    if (props.activeCategory) params.category = props.activeCategory

    router.get(route('blog.index'), params, {
        preserveState:  true,
        preserveScroll: true,
        only:           ['posts'],
        onSuccess: (page) => {
            const newData  = page.props.posts?.data ?? []
            allPosts.value = [...allPosts.value, ...newData]
            meta.value     = page.props.posts?.meta ?? meta.value
        },
        onFinish: () => { isLoading.value = false },
    })
}
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

@keyframes spin { to { transform: rotate(360deg); } }
.spin { animation: spin 0.7s linear infinite; display: inline-block; }
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- ============================================================
             HERO
        ============================================================ -->
        <section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <img
                    src="/images/page/home/section2.jpg"
                    alt="Blog"
                    class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>

            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">
                        Azure Group — Insights
                    </p>
                    <h1
                        class="fade-up d-200 font-bold text-white leading-[1.0] uppercase"
                        style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);"
                    >
                        News <br> <span class="text-[#f15a29]">&amp; Events</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        Knowledge, analysis, and the latest trends — supporting your journey toward informed decisions in asset management and investment.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             BLOG GRID
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-16 lg:py-24">
            <div class="section-container">

                <div class="fade-up flex items-center gap-4 mb-10">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">All Posts</span>
                </div>

                <!-- Grid Posts -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <Link
                        v-for="(blog, i) in allPosts"
                        :key="blog.id"
                        :href="blog.slug ? route('blog.show', blog.slug) : '#'"
                        class="fade-up bg-white group overflow-hidden rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 block"
                        :style="`animation-delay:${(i % 5) * 40}ms`"
                    >
                        <!-- Thumbnail -->
                        <div class="overflow-hidden aspect-[4/3] bg-gray-100">
                            <img
                                v-if="blog.cover_url"
                                :src="blog.cover_url"
                                :alt="blog.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >
                            <div v-else class="w-full h-full bg-gradient-to-br from-[#141617] to-[#2a2b2c] flex items-center justify-center">
                                <svg class="h-8 w-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-3">
                            <p class="text-[#f15a29] text-[9px] font-bold uppercase tracking-widest mb-1">{{ blog.published_at }}</p>
                            <h3
                                class="font-bold text-[#141617] leading-snug group-hover:text-[#f15a29] transition-colors duration-300 line-clamp-2"
                                style="font-size:12px; font-family:'Saira',sans-serif;"
                            >
                                {{ blog.title }}
                            </h3>
                        </div>
                    </Link>
                </div>

                <!-- Load More Button -->
                <div v-if="hasMore" class="mt-12 text-center">
                    <button
                        id="load-more-btn"
                        @click="loadMore"
                        :disabled="isLoading"
                        class="group inline-flex items-center gap-3 font-bold text-sm uppercase tracking-wider border-2 px-10 py-3 rounded-full transition-all duration-300"
                        :class="isLoading
                            ? 'border-gray-300 text-gray-400 cursor-not-allowed opacity-70'
                            : 'text-[#141617] border-[#141617] hover:bg-[#141617] hover:text-white cursor-pointer'"
                    >
                        <!-- Spinner -->
                        <svg v-if="isLoading" class="spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <span>{{ isLoading ? 'Memuat...' : 'Load More Posts' }}</span>
                        <svg v-if="!isLoading" class="h-4 w-4 group-hover:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>

                <!-- Semua post sudah ditampilkan -->
                <div v-else-if="allPosts.length > 0 && meta.last_page > 1" class="mt-12 text-center">
                    <p class="text-sm text-gray-400 uppercase tracking-widest font-semibold">— Semua artikel telah ditampilkan —</p>
                </div>

            </div>
        </section>

    </div>
</template>
