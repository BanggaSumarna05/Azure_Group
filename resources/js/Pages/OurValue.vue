<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const values = [
    {
        title: 'Integrity',
        description: 'We conduct business with honesty, transparency, and ethical standards in every decision we make.',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
    },
    {
        title: 'Excellence',
        description: 'We pursue the highest standards in everything we do, continuously improving and innovating.',
        icon: 'M13 10V3L4 14h7v7l9-11h-7z'
    },
    {
        title: 'Partnership',
        description: 'We build lasting relationships based on mutual trust, respect, and shared success.',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
    },
    {
        title: 'Sustainability',
        description: 'We invest with a long-term perspective, creating value that benefits communities and the environment.',
        icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    },
]
</script>

<template>
    <div>
        <!-- Page Hero -->
        <section
            class="relative flex items-end overflow-hidden pt-20"
            style="min-height: 340px; background-color: #141617;"
        >
            <div
                class="absolute inset-0"
                style="
                    background-image: radial-gradient(circle at 30% 50%, rgba(241,90,41,0.12) 0%, transparent 60%),
                                      radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%);
                "
            />
            <div class="section-container relative z-10 pb-16 pt-10">
                <p class="text-xs font-medium uppercase tracking-[0.2em]" style="color: #f15a29;">
                    Company
                </p>
                <h1
                    class="mt-3 font-semibold text-white"
                    style="font-family: 'Saira', sans-serif; font-size: clamp(32px, 5vw, 52px); letter-spacing: -0.72px; line-height: 1.1;"
                >
                    Our Value
                </h1>
                <p class="mt-3 max-w-xl" style="color: rgba(255,255,255,0.6); font-size: 15px; line-height: 1.7;">
                    The core principles that guide our investments, partnerships, and operations.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <section style="background-color: #f2f3f5; padding: 80px 0;">
            <div class="section-container">
                <div class="mb-12 text-center">
                    <div class="mb-6 h-[3px] w-10 mx-auto" style="background: #f15a29;" />
                    <h2
                        class="font-semibold"
                        style="font-size: 24px; color: #141617; letter-spacing: -0.36px; line-height: 28.8px;"
                    >
                        Guiding Principles
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        v-for="(value, index) in values"
                        :key="value.title"
                        class="p-8 transition-transform duration-300 hover:-translate-y-1"
                        style="background: #ffffff; border: 1px solid #dddddd; border-radius: 4px; box-shadow: rgba(19, 21, 22, 0.04) 0px 2px 8px;"
                        @mouseenter="$event.currentTarget.style.boxShadow = 'rgba(19, 21, 22, 0.1) 10px 10px 25px 5px'"
                        @mouseleave="$event.currentTarget.style.boxShadow = 'rgba(19, 21, 22, 0.04) 0px 2px 8px'"
                    >
                        <div
                            class="mb-6 flex h-14 w-14 items-center justify-center"
                            style="background: rgba(241, 90, 41, 0.1); border-radius: 4px; color: #f15a29;"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="value.icon" />
                            </svg>
                        </div>
                        <h3 class="font-semibold" style="font-size: 20px; color: #141617;">
                            {{ value.title }}
                        </h3>
                        <p class="mt-4" style="color: #666666; line-height: 1.7; font-size: 15px;">
                            {{ value.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
