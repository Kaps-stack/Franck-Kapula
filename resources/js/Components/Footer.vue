<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Small from "@/Components/Typography/Small.vue";

const props = defineProps({
    profile: {
        type: Object,
        default: null,
    },
    projects: {
        type: Array,
        default: () => [],
    },
    experiences: {
        type: Array,
        default: () => [],
    },
    education: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();

// Récupère en priorité les props transmises, sinon fallback sur Inertia global
const profileData = computed(() => {
    return props.profile || page.props.profile || null;
});

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="border-t border-white/10 bg-[#24283680]">
        <div class="mx-auto max-w-7xl px-6">

            <!-- ================================================= -->
            <!-- MAIN FOOTER -->
            <!-- ================================================= -->

            <div class="grid gap-12 py-16 lg:grid-cols-[1.5fr_1fr_1fr]">

                <!-- ================================================= -->
                <!-- BRAND -->
                <!-- ================================================= -->

                <div class="max-w-md">

                    <Link href="/" class="inline-flex items-center">
                        <span class="text-2xl font-black tracking-tight text-white">
                            {{ profileData?.full_name || "Franck Kapula" }}

                            <span class="text-[#ff02ab]">
                                .
                            </span>
                        </span>
                    </Link>

                    <!-- Title -->
                    <div class="mt-3">
                        <Small class="font-sans text-indigo-400">
                            {{ profileData?.title || "Software Developer" }}
                        </Small>
                    </div>

                    <!-- ================================================= -->
                    <!-- SOCIALS -->
                    <!-- ================================================= -->

                    <div class="mt-7 flex flex-wrap items-center gap-3">

                        <!-- GitHub -->
                        <a
                            v-if="profileData?.github_url"
                            :href="profileData.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="GitHub"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-github"></i>
                        </a>

                        <!-- LinkedIn -->
                        <a
                            v-if="profileData?.linkedin_url"
                            :href="profileData.linkedin_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>

                        <!-- X -->
                        <a
                            v-if="profileData?.X_url || profileData?.twitter_url"
                            :href="profileData?.X_url || profileData?.twitter_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="X"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <!-- Facebook -->
                        <a
                            v-if="profileData?.facebook_url"
                            :href="profileData.facebook_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <!-- Instagram -->
                        <a
                            v-if="profileData?.instagram_url"
                            :href="profileData.instagram_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <!-- WhatsApp -->
                        <a
                            v-if="profileData?.whatsapp_url"
                            :href="profileData.whatsapp_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="WhatsApp"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <!-- Email -->
                        <a
                            v-if="profileData?.email"
                            :href="`mailto:${profileData.email}`"
                            aria-label="Email"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-solid fa-envelope"></i>
                        </a>

                    </div>
                </div>

                <!-- ================================================= -->
                <!-- NAVIGATION -->
                <!-- ================================================= -->

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-white">
                        Navigation
                    </h3>

                    <nav class="mt-5 flex flex-col gap-4">

                        <Link
                            href="/"
                            class="text-sm text-slate-500 transition hover:text-white"
                        >
                            Accueil
                        </Link>

                        <a
                            href="/#projects"
                            class="text-sm text-slate-500 transition hover:text-white"
                        >
                            Projets
                        </a>

                        <a
                            href="/#experience"
                            class="text-sm text-slate-500 transition hover:text-white"
                        >
                            Expérience
                        </a>

                        <a
                            href="/#education"
                            class="text-sm text-slate-500 transition hover:text-white"
                        >
                            Formation
                        </a>

                        <Link
                            href="/game"
                            class="text-sm text-slate-500 transition hover:text-white"
                        >
                            Mon univers
                        </Link>

                    </nav>
                </div>

                <!-- ================================================= -->
                <!-- CONTACT -->
                <!-- ================================================= -->

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-white">
                        Contact
                    </h3>

                    <div class="mt-5 flex flex-col gap-4">

                        <!-- Email -->
                        <a
                            v-if="profileData?.email"
                            :href="`mailto:${profileData.email}`"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i class="fa-solid fa-envelope w-4 text-xs"></i>

                            <span class="break-all">
                                {{ profileData.email }}
                            </span>
                        </a>

                        <!-- Phone -->
                        <a
                            v-if="profileData?.phone"
                            :href="`tel:${profileData.phone}`"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i class="fa-solid fa-phone w-4 text-xs"></i>

                            {{ profileData.phone }}
                        </a>

                        <!-- Location -->
                        <div
                            v-if="profileData?.location"
                            class="flex items-center gap-3 text-sm text-slate-500"
                        >
                            <i class="fa-solid fa-location-dot w-4 text-xs"></i>

                            {{ profileData.location }}
                        </div>

                        <!-- Website -->
                        <a
                            v-if="profileData?.website_url"
                            :href="profileData.website_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i class="fa-solid fa-globe w-4 text-xs"></i>

                            Mon site
                        </a>

                    </div>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- BOTTOM -->
            <!-- ================================================= -->

            <div class="flex flex-col gap-4 border-t border-white/10 py-7 sm:flex-row sm:items-center sm:justify-between">

                <Small class="font-sans text-slate-600">
                    © {{ currentYear }}

                    {{ profileData?.full_name || "Franck Kapula" }}.

                    Tous droits réservés.
                </Small>

                <div class="flex items-center gap-2 text-slate-600">
                    <span class="h-2 w-2 rounded-full bg-[#ff02ab]"></span>

                    <Small class="font-sans text-slate-600">
                        {{ profileData?.title || "Software Developer" }}
                    </Small>
                </div>

            </div>

        </div>
    </footer>
</template>
