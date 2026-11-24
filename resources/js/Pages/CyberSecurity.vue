<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })
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
                    Information
                </p>
                <h1
                    class="mt-3 font-semibold text-white"
                    style="font-family: 'Saira', sans-serif; font-size: clamp(32px, 5vw, 52px); letter-spacing: -0.72px; line-height: 1.1;"
                >
                    Cyber Security
                </h1>
                <p class="mt-3 max-w-xl" style="color: rgba(255,255,255,0.6); font-size: 15px; line-height: 1.7;">
                    Our commitment to protecting information assets and ensuring robust security practices.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <section style="background-color: #f2f3f5; padding: 80px 0; min-height: 50vh;">
            <div class="section-container max-w-3xl">
                <div class="prose-azure">
                    <p>
                        Azure Investama Group is committed to protecting the confidentiality, integrity, and availability of information assets across our organization and portfolio companies.
                    </p>
                    <p>
                        We implement industry-standard security practices including access controls, encryption, regular security assessments, and employee awareness training to safeguard against cyber threats.
                    </p>
                    <p>
                        If you discover a security vulnerability or have concerns about our information security practices, please contact us at
                        <a href="mailto:marketing@azureinvestama.com" style="color: #f15a29; text-decoration: underline;">marketing@azureinvestama.com</a>.
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
