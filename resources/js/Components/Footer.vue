<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const settings = computed(() => page.props.settings ?? {})

const socialLinks = computed(() => {
    const links = []

    if (settings.value.instagram_url) {
        links.push({
            label: 'Instagram',
            url: settings.value.instagram_url,
        })
    }

    if (settings.value.linkedin_url) {
        links.push({
            label: 'LinkedIn',
            url: settings.value.linkedin_url,
        })
    }

    if (settings.value.company_phone) {
        links.push({
            label: 'WhatsApp',
            url: `https://wa.me/${settings.value.company_phone.replace(/[^0-9]/g, '')}`,
        })
    }

    if (settings.value.company_email) {
        links.push({
            label: 'Email',
            url: `mailto:${settings.value.company_email}`,
        })
    }

    return links
})

const companyAddress = computed(
    () => settings.value.company_address ?? 'Talavera Office Park, 15th Floor, South Jakarta 12430',
)
</script>

<template>
    <footer class="bg-[#0A0A0A] border-t border-[#E8470A]/25 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-10">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">

                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="text-white text-2xl font-extrabold tracking-tight mb-3">
                        ∧ Azure
                    </div>
                    <p class="text-white/35 text-sm leading-relaxed mb-6 max-w-[200px]">
                        A Trusted Holding Partner for High-Impact Industrial Ventures in Indonesia.
                    </p>
                    <div class="flex gap-2">
                        <a
                            v-for="link in socialLinks"
                            :key="link.label"
                            :href="link.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            :aria-label="link.label"
                            class="w-9 h-9 border border-white/10 flex items-center justify-center text-white/40 hover:border-[#E8470A]/50 hover:text-[#E8470A] transition-colors duration-200"
                        >
                            <!-- Instagram -->
                            <svg
                                v-if="link.label === 'Instagram'"
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2" />
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="2" />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2" />
                            </svg>
                            <!-- LinkedIn -->
                            <svg
                                v-else-if="link.label === 'LinkedIn'"
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                            <!-- WhatsApp -->
                            <svg
                                v-else-if="link.label === 'WhatsApp'"
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <!-- Email -->
                            <svg
                                v-else
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div>
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-[3px] mb-5">Navigasi</p>
                    <nav class="flex flex-col gap-3">
                        <Link :href="route('home')" class="text-white/55 hover:text-white text-sm transition-colors">Home</Link>
                        <Link :href="route('about.index')" class="text-white/55 hover:text-white text-sm transition-colors">About Us</Link>
                        <Link :href="route('portfolio.index')" class="text-white/55 hover:text-white text-sm transition-colors">Portfolio</Link>
                        <Link :href="route('leadership')" class="text-white/55 hover:text-white text-sm transition-colors">Leadership</Link>
                        <Link :href="route('career.index')" class="text-[#E8470A] hover:text-[#c93d08] text-sm transition-colors font-medium">Career →</Link>
                        <Link :href="route('blog.index')" class="text-white/55 hover:text-white text-sm transition-colors">Blog</Link>
                    </nav>
                </div>

                <!-- Informasi -->
                <div>
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-[3px] mb-5">Informasi</p>
                    <nav class="flex flex-col gap-3">
                        <Link :href="route('cybersecurity')" class="text-white/55 hover:text-white text-sm transition-colors">
                            Cyber Security Information
                        </Link>
                    </nav>
                </div>

                <!-- Lokasi -->
                <div>
                    <p class="text-white/30 text-[10px] font-bold uppercase tracking-[3px] mb-5">Lokasi</p>
                    <a
                        v-if="settings.maps_url"
                        :href="settings.maps_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block border border-white/8 bg-[#111111] p-4 hover:border-white/15 transition-colors duration-200 group"
                    >
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-[#E8470A] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-white/70 text-xs font-medium group-hover:text-white transition-colors">
                                    {{ companyAddress }}
                                </p>
                                <p class="text-[#E8470A] text-[10px] mt-1 uppercase tracking-wider">View on Maps →</p>
                            </div>
                        </div>
                    </a>
                    <div
                        v-else
                        class="border border-white/8 bg-[#111111] p-4"
                    >
                        <p class="text-white/70 text-xs font-medium">{{ companyAddress }}</p>
                    </div>
                </div>

            </div>

            <div class="border-t border-white/8 pt-6">
                <p class="text-white/20 text-xs">
                    © {{ new Date().getFullYear() }} Azure Investama Group. All Rights Reserved.
                </p>
            </div>

        </div>
    </footer>
</template>
