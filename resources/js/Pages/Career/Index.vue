<script setup>
import { ref, onMounted } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const page = usePage()

const props = defineProps({
    careers:          { type: Array,  default: () => [] },
    activeType:       { type: String, default: null },
    recaptchaSiteKey: { type: String, default: '' },
})

// ── reCAPTCHA v2 Checkbox ───────────────────────────────────────────────
const recaptchaToken  = ref('')
const recaptchaError  = ref('')
const recaptchaWidget = ref(null)

function onRecaptchaVerified(token) { recaptchaToken.value = token; recaptchaError.value = '' }
function onRecaptchaExpired()       { recaptchaToken.value = '' }

function resetRecaptcha() {
    recaptchaToken.value = ''
    recaptchaError.value = ''
    if (window.grecaptcha && recaptchaWidget.value?._widgetId !== undefined) {
        window.grecaptcha.reset(recaptchaWidget.value._widgetId)
    }
}

function renderRecaptcha() {
    if (!props.recaptchaSiteKey || !window.grecaptcha || !recaptchaWidget.value) return
    if (recaptchaWidget.value.childElementCount > 0) return
    const widgetId = window.grecaptcha.render(recaptchaWidget.value, {
        sitekey: props.recaptchaSiteKey,
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

// ── Application form ─────────────────────────────────────────────────────
const form = useForm({
    name:      '',
    email:     '',
    phone:     '',
    message:   '',
    cv:        null,
    _hp_field: '',
})

const cvFileName = ref('')
const cvError    = ref('')

function onCvChange(e) {
    const file = e.target.files[0]
    cvError.value = ''
    if (!file) return
    if (file.type !== 'application/pdf') { cvError.value = 'Only PDF files are accepted.'; e.target.value = ''; return }
    if (file.size > 5 * 1024 * 1024)    { cvError.value = 'File size must be under 5 MB.'; e.target.value = ''; return }
    form.cv = file
    cvFileName.value = file.name
}

async function submitForm() {
    if (props.recaptchaSiteKey && !recaptchaToken.value) {
        recaptchaError.value = 'Please complete the reCAPTCHA verification.'
        return
    }
    form.transform(data => ({ ...data, recaptcha_token: recaptchaToken.value }))
        .post(route('career.apply.general'), {
            forceFormData: true,
            onSuccess: () => { form.reset(); cvFileName.value = ''; resetRecaptcha() },
        })
}

// ── LinkedIn posts ────────────────────────────────────────────────────────
const linkedinPosts = [
    {
        id: 1, date: '19h • Edited',
        title: '[RECRUITMENT] — STRATEGIC BUSINESS ANALYST',
        body: 'Currently Azure are hiring Strategic Business Analyst for our internal need. Submit your CV to: recruitment@azureinvestama.com',
        image: '/images/page/home/section2.jpg',
        url: 'https://www.linkedin.com/company/azure-investama',
    },
    {
        id: 2, date: '2d • Edited',
        title: '[RECRUITMENT] — CORPORATE PLANNING OFFICER',
        body: 'Currently Azure are hiring Corporate Planning Officer for our internal need. Submit your CV to: recruitment@azureinvestama.com',
        image: '/images/page/home/section4.jpeg',
        url: 'https://www.linkedin.com/company/azure-investama',
    },
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
</style>

<template>
    <div class="bg-white selection:bg-[#f15a29] selection:text-white overflow-x-hidden">

        <!-- HERO -->
        <section class="relative h-screen min-h-[600px] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <img src="/images/page/home/section2.jpg" alt="Career" class="h-full w-full object-cover scale-105 transition-transform duration-[12s] hover:scale-100">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0e0f] via-[#141617]/60 to-transparent"></div>
            </div>
            <div class="relative z-10 w-full section-container pb-20 lg:pb-28">
                <div class="max-w-4xl">
                    <p class="fade-up d-100 text-[#f15a29] text-xs font-bold uppercase tracking-[0.3em] mb-5">Azure Group — Join Us</p>
                    <h1 class="fade-up d-200 font-bold text-white leading-[1.0] uppercase" style="font-family:'Saira',sans-serif; font-size:clamp(52px,8vw,110px);">
                        Ca<span class="text-[#f15a29]">reer</span>
                    </h1>
                    <p class="fade-up d-300 mt-6 text-white/70 leading-relaxed max-w-xl" style="font-size:16px;">
                        Join a dynamic network of professionals, empowered by purpose and driven to create meaningful change.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-px bg-white/10"></div>
        </section>

        <!-- INTRO -->
        <section class="bg-[#141617] py-24 lg:py-32">
            <div class="section-container">
                <div class="grid lg:grid-cols-[1fr_2fr] gap-16 lg:gap-24 items-center">
                    <div class="fade-up">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em]">Why Join Us</span>
                        </div>
                        <div class="grid grid-cols-1 gap-px bg-white/10 rounded-2xl overflow-hidden mt-2">
                            <div class="bg-[#1a1b1c] px-6 py-6"><p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-1">Culture</p><p class="text-white font-bold">Continuous Learning</p></div>
                            <div class="bg-[#1a1b1c] px-6 py-6"><p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-1">Growth</p><p class="text-white font-bold">Rapid & Meaningful</p></div>
                            <div class="bg-[#1a1b1c] px-6 py-6"><p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-1">Impact</p><p class="text-white font-bold">National Scale</p></div>
                        </div>
                    </div>
                    <div>
                        <h2 class="fade-up d-100 font-bold text-white leading-tight" style="font-family:'Saira',sans-serif; font-size:clamp(26px,3.5vw,44px);">
                            We embrace a culture of <em class="not-italic text-[#f15a29]">continuous learning</em> and rapid growth.
                        </h2>
                        <p class="fade-up d-200 mt-8 text-white/60 leading-relaxed" style="font-size:15px;">
                            Azure Group offers every role room for creativity, innovation, and impact. If you're driven to create meaningful change — both in your career and in society — we invite you to join our mission-focused team and grow with us.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- OPEN POSITIONS + FORM -->
        <section class="bg-[#f5f5f7] py-24 lg:py-32">
            <div class="section-container">
                <div class="grid lg:grid-cols-[3fr_2fr] gap-12 lg:gap-16 items-start">

                    <!-- Left: open positions -->
                    <div>
                        <div class="fade-up flex items-center gap-4 mb-10">
                            <div class="h-px w-10 bg-[#f15a29]"></div>
                            <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f15a29]">Open Positions</span>
                        </div>

                        <div v-if="careers.length > 0" class="space-y-px bg-gray-200">
                            <Link v-for="(career, i) in careers" :key="career.id" :href="route('career.show', career.id)"
                                class="fade-up bg-white group flex items-center justify-between p-8 hover:bg-[#141617] transition-colors duration-300 block"
                                :style="`animation-delay:${100 + i * 60}ms`">
                                <div>
                                    <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-2">{{ career.department }} · {{ career.type }}</p>
                                    <h3 class="font-bold text-[#141617] text-lg group-hover:text-white transition-colors duration-300" style="font-family:'Saira',sans-serif;">{{ career.title }}</h3>
                                    <p class="text-[#666] group-hover:text-white/40 text-sm mt-1 transition-colors duration-300">{{ career.location }}</p>
                                </div>
                                <svg class="h-5 w-5 text-[#141617]/20 group-hover:text-[#f15a29] group-hover:translate-x-1 transition-all duration-300 flex-shrink-0 ml-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </Link>
                        </div>

                        <div v-else class="space-y-px bg-gray-200">
                            <div v-for="(job, i) in [{dept:'Corporate',type:'Full-time',title:'Strategic Business Analyst',loc:'Jakarta, Indonesia'},{dept:'Corporate',type:'Full-time',title:'Corporate Planning Officer',loc:'Jakarta, Indonesia'}]"
                                :key="i" class="fade-up bg-white group flex items-center justify-between p-8 cursor-default" :style="`animation-delay:${100 + i * 60}ms`">
                                <div>
                                    <p class="text-[#f15a29] text-xs font-bold uppercase tracking-widest mb-2">{{ job.dept }} · {{ job.type }}</p>
                                    <h3 class="font-bold text-[#141617] text-lg" style="font-family:'Saira',sans-serif;">{{ job.title }}</h3>
                                    <p class="text-[#666] text-sm mt-1">{{ job.loc }}</p>
                                </div>
                            </div>
                        </div>

                        <p class="fade-up mt-8 text-[#999] text-sm" style="animation-delay:200ms;">
                            Don't see a matching role? Email us at
                            <a href="mailto:recruitment@azureinvestama.com" class="text-[#f15a29] font-bold hover:underline">recruitment@azureinvestama.com</a>
                        </p>
                    </div>

                    <!-- Right: application form -->
                    <div class="lg:sticky lg:top-32">
                        <div class="fade-up d-100 bg-[#141617] rounded-2xl p-10">
                            <p class="text-[#f15a29] text-xs font-bold uppercase tracking-[0.25em] mb-2">Apply Now</p>
                            <h2 class="font-bold text-white mb-2 leading-tight" style="font-family:'Saira',sans-serif; font-size:clamp(20px,2vw,28px);">Send Your Application</h2>
                            <p class="text-white/40 text-xs mb-8">General application — our team will match you to the right role.</p>

                            <div v-if="page.props.flash?.success" class="mb-6 rounded-xl px-4 py-3 text-sm font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                {{ page.props.flash.success }}
                            </div>

                            <form class="space-y-4" @submit.prevent="submitForm">
                                <!-- Honeypot -->
                                <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;pointer-events:none;">
                                    <input v-model="form._hp_field" type="text" name="_hp_field" autocomplete="off" tabindex="-1">
                                </div>

                                <!-- Name -->
                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-1.5">Full Name *</label>
                                    <input v-model="form.name" type="text" required placeholder="Your full name"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{'border-red-500/70':form.errors.name}">
                                    <p v-if="form.errors.name" class="mt-1 text-red-400 text-xs">{{ form.errors.name }}</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-1.5">Email *</label>
                                    <input v-model="form.email" type="email" required placeholder="your@email.com"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{'border-red-500/70':form.errors.email}">
                                    <p v-if="form.errors.email" class="mt-1 text-red-400 text-xs">{{ form.errors.email }}</p>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-1.5">Phone *</label>
                                    <input v-model="form.phone" type="tel" required placeholder="+62 xxx xxxx xxxx"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm"
                                        :class="{'border-red-500/70':form.errors.phone}">
                                    <p v-if="form.errors.phone" class="mt-1 text-red-400 text-xs">{{ form.errors.phone }}</p>
                                </div>

                                <!-- CV Upload -->
                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-1.5">
                                        CV / Resume <span class="normal-case font-normal text-white/25">(PDF only, max 5 MB) *</span>
                                    </label>
                                    <label for="cv-general"
                                        class="flex flex-col items-center justify-center gap-2 border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-colors duration-200"
                                        :class="cvError||form.errors.cv ? 'border-red-500/60 bg-red-500/5' : cvFileName ? 'border-green-500/50 bg-green-500/5' : 'border-white/10 hover:border-[#f15a29]/50'">
                                        <svg v-if="!cvFileName" class="h-8 w-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <svg v-else class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-xs transition-colors" :class="cvFileName ? 'text-green-400 font-semibold' : 'text-white/30'">
                                            {{ cvFileName || 'Click to upload PDF' }}
                                        </span>
                                        <span class="text-[10px] text-white/20">PDF · max 5 MB</span>
                                        <input id="cv-general" type="file" accept=".pdf,application/pdf" class="hidden" @change="onCvChange">
                                    </label>
                                    <p v-if="cvError" class="mt-1 text-red-400 text-xs">{{ cvError }}</p>
                                    <p v-else-if="form.errors.cv" class="mt-1 text-red-400 text-xs">{{ form.errors.cv }}</p>
                                </div>

                                <!-- Cover Letter -->
                                <div>
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-1.5">Cover Letter <span class="normal-case font-normal text-white/25">(optional)</span></label>
                                    <textarea v-model="form.message" rows="3" placeholder="Brief intro or position of interest..."
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/20 focus:outline-none focus:border-[#f15a29] transition-colors text-sm resize-none"
                                        :class="{'border-red-500/70':form.errors.message}"/>
                                    <p v-if="form.errors.message" class="mt-1 text-red-400 text-xs">{{ form.errors.message }}</p>
                                </div>

                                <!-- reCAPTCHA v2 -->
                                <div v-if="recaptchaSiteKey">
                                    <label class="block text-white/40 text-xs font-bold uppercase tracking-widest mb-2">Security Verification *</label>
                                    <div ref="recaptchaWidget" class="rounded-xl overflow-hidden"></div>
                                    <p v-if="recaptchaError" class="mt-1.5 text-red-400 text-xs">{{ recaptchaError }}</p>
                                    <p v-if="form.errors.recaptcha_token" class="mt-1.5 text-red-400 text-xs">{{ form.errors.recaptcha_token }}</p>
                                </div>

                                <button type="submit"
                                    :disabled="form.processing || !!cvError || !form.cv || (!!recaptchaSiteKey && !recaptchaToken)"
                                    class="w-full font-bold text-sm uppercase tracking-wider text-white bg-[#f15a29] px-6 py-4 rounded-xl hover:bg-[#d94e22] transition-colors duration-300 disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-2">
                                    {{ form.processing ? 'Sending...' : 'Submit Application' }}
                                    <svg v-if="!form.processing" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- LINKEDIN POSTS -->
        <section class="bg-[#141617] py-24 lg:py-32">
            <div class="section-container">
                <div class="fade-up flex items-center justify-between mb-12">
                    <div class="flex items-center gap-4">
                        <div class="h-px w-10 bg-[#0077b5]"></div>
                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#0077b5]">LinkedIn</span>
                    </div>
                    <a href="https://www.linkedin.com/company/azure-investama" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-white/40 text-xs font-bold uppercase tracking-wider hover:text-[#0077b5] transition-colors">
                        Follow Us
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a v-for="post in linkedinPosts" :key="post.id" :href="post.url" target="_blank" rel="noopener noreferrer"
                        class="fade-up group block bg-[#1a1b1c] rounded-2xl overflow-hidden border border-white/5 hover:border-[#0077b5]/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="overflow-hidden aspect-video relative">
                            <img :src="post.image" :alt="post.title" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-all duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="bg-[#141617]/80 text-white font-bold text-sm uppercase tracking-[0.2em] px-6 py-2.5 rounded-full border border-white/10">WE ARE HIRING</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-9 h-9 bg-[#0077b5] rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white text-sm font-bold leading-none">PT Azure Investama Grup</p>
                                    <p class="text-white/30 text-xs mt-0.5">{{ post.date }}</p>
                                </div>
                            </div>
                            <h3 class="text-white font-bold text-sm mb-2 group-hover:text-[#0077b5] transition-colors duration-300" style="font-family:'Saira',sans-serif;">{{ post.title }}</h3>
                            <p class="text-white/50 text-xs leading-relaxed line-clamp-3">{{ post.body }}</p>
                            <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                                <span class="text-[#0077b5] text-xs font-bold uppercase tracking-wider">View on LinkedIn</span>
                                <svg class="h-4 w-4 text-[#0077b5] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="fade-up mt-10 text-center">
                    <a href="https://www.linkedin.com/company/azure-investama" target="_blank" rel="noopener noreferrer"
                        class="group inline-flex items-center gap-3 font-bold text-sm uppercase tracking-wider text-white border-2 border-[#0077b5]/50 px-8 py-3.5 rounded-full hover:bg-[#0077b5] hover:border-[#0077b5] transition-all duration-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        Follow Azure Group on LinkedIn
                    </a>
                </div>
            </div>
        </section>

    </div>
</template>
