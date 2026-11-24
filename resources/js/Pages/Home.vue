<script setup>
import { computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Footer from '@/Components/Footer.vue'

defineOptions({ layout: AppLayout })

const page = usePage()
const settings = computed(() => page.props.settings ?? {})

onMounted(() => {
    // Schema.org
    const script = document.createElement('script')
    script.type = 'application/ld+json'
    script.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name: 'Azure Investama Group',
        url: 'https://azuregroup.co.id',
        logo: 'https://azuregroup.co.id/images/logo&tagline/Azure-Investama-New-Logo_Square.png',
        contactPoint: {
            '@type': 'ContactPoint',
            telephone: '+6281932099898',
            contactType: 'customer service',
        },
        sameAs: [
            'https://www.instagram.com/azureinvestamagrup/',
            'https://www.linkedin.com/company/azure-investama',
        ],
    })
    document.head.appendChild(script)
})
</script>

<style scoped>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}
.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
</style>

<template>
    <!--
        Home: full-page sections.
        Snap proximity = lebih smooth, tidak terlalu keras seperti mandatory.
    -->
    <div
        class="home-snap-wrapper"
        style="position:fixed; inset:0; overflow-y:scroll; overflow-x:hidden; background:#141617; scroll-snap-type:y proximity;"
    >
        <!-- ============================================
             SECTION 1 — Hero
        ============================================ -->
        <section
            id="section-1"
            class="snap-center relative flex h-screen w-full items-center justify-center overflow-hidden"
        >
            <div class="absolute inset-0">
                <video
                    poster="/images/hero-fallback.jpg"
                    autoplay muted loop playsinline
                    preload="auto"
                    class="h-full w-full object-cover"
                >
                    <source src="/images/page/home/video-hero1.webm" type="video/webm">
                    <source src="/images/page/home/video-hero1-compressed.mp4" type="video/mp4">
                </video>
            </div>
            <div class="relative z-10 px-6 text-center text-white mt-16">
                <h1
                    class="animate-fade-in-up font-bold uppercase tracking-wide !text-white"
                    style="font-family:'Saira',sans-serif; font-size:clamp(40px,6vw,64px); line-height:1.1;"
                >
                    Azure Investama
                </h1>
                <p
                    class="animate-fade-in-up delay-100 mx-auto mt-4 max-w-2xl font-medium !text-white"
                    style="font-size:clamp(16px,2vw,20px);"
                >
                    A Trusted Holding Partner for High-Impact Industrial Ventures.
                </p>
            </div>
            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="h-6 w-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </section>

        <!-- ============================================
             SECTION 2 — Advancing Strategic Industries
        ============================================ -->
        <section
            id="section-2"
            class="snap-center relative flex h-screen w-full items-center overflow-hidden"
        >
            <div class="absolute inset-0">
                <img src="/images/page/home/section2.jpg" alt="Strategic Industries" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-black/45"></div>
            </div>
            <div class="section-container relative z-10 w-full text-white">
                <div class="max-w-3xl">
                    <h2
                        class="animate-fade-in-up font-bold !text-white"
                        style="font-family:'Saira',sans-serif; font-size:clamp(36px,5vw,56px); line-height:1.2;"
                    >
                        Advancing <span style="color:#f15a29;">Strategic Industries</span> in<br>Indonesia.
                    </h2>
                    <p
                        class="animate-fade-in-up delay-100 mt-6 font-medium !text-white"
                        style="font-size:16px; line-height:1.7;"
                    >
                        Holding company committed to nurturing and scaling transformative industrial and infrastructure
                        ventures, serving as a long-term strategic partner for businesses that drive national progress and
                        sustainable development across Indonesia.
                    </p>
                    <div class="animate-fade-in-up delay-200 mt-10">
                        <Link :href="route('about.index')" class="group inline-flex items-center text-sm lg:text-base font-bold text-[#141617] transition-all duration-300 bg-white border-2 border-white px-8 py-3.5 rounded-full hover:bg-[#f15a29] hover:border-[#f15a29] hover:text-white shadow-lg">
                            <span>Discover More</span>
                            <svg class="ml-3 h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================
             SECTION 3 — 6 Years of Building Impact
        ============================================ -->
        <section
            id="section-3"
            class="snap-center relative flex h-screen w-full items-center justify-center overflow-hidden"
        >
            <div class="absolute inset-0">
                <video src="/images/page/home/section3.mp4" autoplay muted loop playsinline class="h-full w-full object-cover"></video>
                <div class="absolute inset-0 bg-black/35"></div>
            </div>
            <div class="section-container relative z-10 text-center text-white">
                <h2
                    class="animate-fade-in-up font-bold !text-white"
                    style="font-family:'Saira',sans-serif; font-size:clamp(32px,4vw,48px); line-height:1.2;"
                >
                    6 Years of <span style="color:#f15a29;">Dedication</span>.<br>
                    <span style="color:#f15a29;">6 Years</span> of Building Impact.
                </h2>
                <div class="animate-fade-in-up delay-100 mx-auto mt-10 max-w-5xl space-y-6 text-[15px] font-medium leading-relaxed">
                    <p class="!text-white">
                        Azure Investama has supported the growth of construction and engineering ventures through strategic funding, guidance, and long-term partnership. We have worked alongside founders, innovators, and industry leaders to accelerate projects with meaningful impact — driven by discipline, insight, and a commitment to sustainable development.
                    </p>
                    <p class="!text-white">
                        Azure Investama remains dedicated to empowering visionary companies, enabling scalable progress, and shaping a stronger, more resilient future for the built-environment sector.
                    </p>
                </div>
                <p class="animate-fade-in-up delay-200 mt-12 text-base font-bold uppercase tracking-widest !text-white">
                    INVESTING TODAY, TRANSFORMING TOMORROW
                </p>
            </div>
        </section>

        <!-- ============================================
             SECTION 4 — Forming Partnerships
        ============================================ -->
        <section
            id="section-4"
            class="snap-center relative flex h-screen w-full items-center overflow-hidden"
        >
            <div class="absolute inset-0">
                <img src="/images/page/home/section4.jpeg" alt="Orange Building" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-black/45"></div>
            </div>
            <div class="section-container relative z-10 w-full text-white">
                <div class="max-w-3xl">
                    <h2
                        class="animate-fade-in-up font-bold !text-white"
                        style="font-family:'Saira',sans-serif; font-size:clamp(32px,4vw,48px); line-height:1.2;"
                    >
                        Forming <span style="color:#f15a29;">partnerships</span> built on trust.
                    </h2>
                    <p
                        class="animate-fade-in-up delay-100 mt-6 font-medium !text-white/90"
                        style="font-size:16px; line-height:1.7;"
                    >
                        We forge long-term relationships grounded in integrity. We stand alongside visionary founders through every phase of growth — supporting not just capital needs, but strategic progress.
                    </p>
                    <div class="animate-fade-in-up delay-200 mt-10">
                        <Link :href="route('portfolio.index')" class="group inline-flex items-center text-sm lg:text-base font-bold text-[#141617] transition-all duration-300 bg-white border-2 border-white px-8 py-3.5 rounded-full hover:bg-[#f15a29] hover:border-[#f15a29] hover:text-white shadow-lg">
                            <span>Discover More</span>
                            <svg class="ml-3 h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================
             SECTION 5 — Footer
        ============================================ -->
        <section id="section-5" class="snap-center w-full">
            <Footer />
        </section>
    </div>
</template>
