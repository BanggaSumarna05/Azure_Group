<script setup>
import { ref, onMounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Badge from '@/Components/ui/Badge.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const props = defineProps({
    career:           { type: Object, required: true },
    recaptchaSiteKey: { type: String, default: '' },
})

const page = usePage()

// ── reCAPTCHA v2 ─────────────────────────────────────────────────────────
const recaptchaToken  = ref('')
const recaptchaError  = ref('')
const recaptchaWidget = ref(null)

function onRecaptchaVerified(token) { recaptchaToken.value = token; recaptchaError.value = '' }
function onRecaptchaExpired()       { recaptchaToken.value = '' }
function resetRecaptcha() {
    recaptchaToken.value = ''
    if (window.grecaptcha && recaptchaWidget.value?._widgetId !== undefined) {
        window.grecaptcha.reset(recaptchaWidget.value._widgetId)
    }
}

function renderRecaptcha() {
    if (!props.recaptchaSiteKey || !window.grecaptcha || !recaptchaWidget.value) return
    if (recaptchaWidget.value.childElementCount > 0) return
    const widgetId = window.grecaptcha.render(recaptchaWidget.value, {
        sitekey:  props.recaptchaSiteKey,
        callback: onRecaptchaVerified,
        'expired-callback': onRecaptchaExpired,
        theme: 'dark',
    })
    recaptchaWidget.value._widgetId = widgetId
}

onMounted(() => {
    if (!props.recaptchaSiteKey) return
    if (window.grecaptcha?.render) {
        renderRecaptcha()
    } else {
        if (!document.getElementById('recaptcha-script')) {
            const script = document.createElement('script')
            script.id    = 'recaptcha-script'
            script.src   = 'https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit'
            script.async = true; script.defer = true
            document.head.appendChild(script)
        }
        window.onRecaptchaLoad = () => renderRecaptcha()
    }
})

// ── Form ──────────────────────────────────────────────────────────────────
const form = useForm({
    name:      '',
    email:     '',
    phone:     '',
    message:   '',
    cv:        null,
    _hp_field: '',
})

function onFileChange(event) {
    const file = event.target.files[0]
    if (!file) return
    if (file.type !== 'application/pdf') { alert('Only PDF files are accepted.'); event.target.value = ''; return }
    if (file.size > 5 * 1024 * 1024)    { alert('File size must be under 5 MB.'); event.target.value = ''; return }
    form.cv = file
}

function formatType(type) { return type.replace('-', ' ') }

async function submit() {
    if (props.recaptchaSiteKey && !recaptchaToken.value) {
        recaptchaError.value = 'Please complete the reCAPTCHA verification.'
        return
    }
    form.transform(data => ({ ...data, recaptcha_token: recaptchaToken.value }))
        .post(route('career.apply', props.career.id), {
            forceFormData: true,
            onSuccess: () => { form.reset(); resetRecaptcha() },
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
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- ============================================================
             HERO
        ============================================================ -->
        <section class="relative h-[60vh] min-h-[450px] flex items-end overflow-hidden bg-[#141617]">
            <div
                class="absolute inset-0"
                style="background-image: radial-gradient(circle at 20% 60%, rgba(241,90,41,0.1) 0%, transparent 55%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.03) 0%, transparent 50%);"
            ></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-transparent to-transparent"></div>

            <div class="relative z-10 w-full section-container pb-16 lg:pb-20">
                <Link
                    :href="route('career.index')"
                    class="fade-up mb-8 inline-flex items-center gap-2 text-white/40 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors"
                >
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    All Positions
                </Link>

                <div class="flex items-center gap-3 mb-4">
                    <div class="h-px w-10 bg-[#f15a29]"></div>
                    <Badge type="type">{{ formatType(career.type) }}</Badge>
                </div>

                <h1
                    class="fade-up d-100 font-bold text-white leading-tight uppercase"
                    style="font-family:'Saira',sans-serif; font-size:clamp(32px,4.5vw,60px);"
                >
                    {{ career.title }}
                </h1>

                <div class="fade-up d-200 mt-6 flex flex-wrap items-center gap-x-8 gap-y-3 text-white/50 text-sm font-medium">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#f15a29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        {{ career.department }}
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#f15a29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ career.location }}
                    </span>
                    <span v-if="career.deadline" class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#f15a29]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Deadline: <span class="text-white ml-1">{{ career.deadline }}</span>
                    </span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- ============================================================
             CONTENT
        ============================================================ -->
        <section class="bg-[#f5f5f7] py-20 lg:py-28">
            <div class="section-container">
                <div class="grid lg:grid-cols-[2fr_1fr] gap-12 lg:gap-16 items-start">

                    <!-- Job description -->
                    <div class="bg-white rounded-2xl p-10 lg:p-14 border border-gray-100 shadow-sm">
                        <h2 class="font-bold text-[#141617] text-xl mb-8" style="font-family:'Saira',sans-serif;">Job Description</h2>
                        <div class="prose-azure" v-html="career.description" />
                    </div>

                    <!-- Application form -->
                    <div class="lg:sticky lg:top-28">
                        <div class="bg-[#141617] rounded-2xl p-8">
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em] mb-2">Apply Now</p>
                            <h3 class="font-bold text-white text-xl mb-6" style="font-family:'Saira',sans-serif;">
                                Apply for this Role
                            </h3>

                            <div
                                v-if="page.props.flash?.success"
                                class="mb-6 rounded-xl px-4 py-3 text-sm font-medium bg-green-500/10 text-green-400 border border-green-500/20"
                            >
                                {{ page.props.flash.success }}
                            </div>

                            <form class="space-y-4" @submit.prevent="submit">

                                <!-- Honeypot -->
                                <div aria-hidden="true" style="position:absolute; left:-9999px; top:-9999px; opacity:0; pointer-events:none;">
                                    <input v-model="form._hp_field" type="text" name="_hp_field" autocomplete="off" tabindex="-1">
                                </div>

                                <!-- reCAPTCHA error -->
                                <div v-if="form.errors.recaptcha" class="rounded-xl px-4 py-3 text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                    {{ form.errors.recaptcha }}
                                </div>

                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Full Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{ 'border-red-500': form.errors.name }"
                                    >
                                    <p v-if="form.errors.name" class="mt-1 text-red-400 text-xs">{{ form.errors.name }}</p>
                                </div>

                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{ 'border-red-500': form.errors.email }"
                                    >
                                    <p v-if="form.errors.email" class="mt-1 text-red-400 text-xs">{{ form.errors.email }}</p>
                                </div>

                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Phone</label>
                                    <input
                                        v-model="form.phone"
                                        type="text"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{ 'border-red-500': form.errors.phone }"
                                    >
                                    <p v-if="form.errors.phone" class="mt-1 text-red-400 text-xs">{{ form.errors.phone }}</p>
                                </div>

                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Resume / CV (PDF, max 5MB)</label>
                                    <div class="border-2 border-dashed border-white/10 rounded-xl p-6 text-center hover:border-[#f15a29]/50 transition-colors cursor-pointer group" :class="{ 'border-red-500': form.errors.cv }">
                                        <svg class="mx-auto h-7 w-7 text-white/20 group-hover:text-[#f15a29] transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        <input type="file" accept=".pdf" class="hidden" @change="onFileChange" id="cv-upload">
                                        <label for="cv-upload" class="text-white/30 group-hover:text-white/60 text-xs cursor-pointer transition-colors">
                                            {{ form.cv ? form.cv.name : 'Click or drag PDF here' }}
                                        </label>
                                    </div>
                                    <p v-if="form.errors.cv" class="mt-1 text-red-400 text-xs">{{ form.errors.cv }}</p>
                                </div>

                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Cover Letter (Optional)</label>
                                    <textarea
                                        v-model="form.message"
                                        rows="3"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm resize-none"
                                        :class="{ 'border-red-500': form.errors.message }"
                                    />
                                    <p v-if="form.errors.message" class="mt-1 text-red-400 text-xs">{{ form.errors.message }}</p>
                                </div>

                                <!-- reCAPTCHA v2 Checkbox -->
                                <div v-if="recaptchaSiteKey">
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Security Verification *</label>
                                    <div ref="recaptchaWidget" class="rounded-xl overflow-hidden"></div>
                                    <p v-if="recaptchaError" class="mt-1.5 text-red-400 text-xs">{{ recaptchaError }}</p>
                                </div>

                                <button
                                    type="submit"
                                    :disabled="form.processing || (!!recaptchaSiteKey && !recaptchaToken)"
                                    class="w-full font-bold text-sm uppercase tracking-wider text-white bg-[#f15a29] px-6 py-4 rounded-xl hover:bg-[#d94e22] transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-2"
                                >
                                    {{ form.processing ? 'Submitting...' : 'Submit Application' }}
                                    <svg v-if="!form.processing" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
</template>
