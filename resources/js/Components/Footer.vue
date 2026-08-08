<script setup>
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const profile = page.props.profile;

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="border-t border-white/10 bg-[#24283680]">
        <div class="mx-auto max-w-7xl px-6">

            <!-- ================================================= -->
            <!-- MAIN FOOTER -->
            <!-- ================================================= -->

            <div
                class="grid gap-12 py-16 lg:grid-cols-[1.5fr_1fr_1fr]"
            >

                <!-- ================================================= -->
                <!-- BRAND -->
                <!-- ================================================= -->

                <div class="max-w-md">

                    <Link
                        href="/"
                        class="inline-flex items-center"
                    >
                        <span
                            class="text-2xl font-black tracking-tight text-white"
                        >
                            {{ profile?.full_name || "Franck Kapula" }}

                            <span class="text-[#ff02ab]">
                                .
                            </span>
                        </span>
                    </Link>

                    <!-- Title -->
                    <div class="mt-3">
                        <Small
                            class="font-sans text-indigo-400"
                        >
                            {{ profile?.title || "Software Developer" }}
                        </Small>
                    </div>

                    <!-- Bio -->

                    <!-- ================================================= -->
                    <!-- SOCIALS -->
                    <!-- ================================================= -->

                    <div
                        class="mt-7 flex flex-wrap items-center gap-3"
                    >

                        <!-- GitHub -->
                        <a
                            v-if="profile?.github_url"
                            :href="profile.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="GitHub"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-github"></i>
                        </a>

                        <!-- LinkedIn -->
                        <a
                            v-if="profile?.linkedin_url"
                            :href="profile.linkedin_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>

                        <!-- X -->
                        <a
                            v-if="profile?.X_url"
                            :href="profile.X_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="X"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <!-- Facebook -->
                        <a
                            v-if="profile?.facebook_url"
                            :href="profile.facebook_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <!-- Instagram -->
                        <a
                            v-if="profile?.instagram_url"
                            :href="profile.instagram_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <!-- WhatsApp -->
                        <a
                            v-if="profile?.whatsapp_url"
                            :href="profile.whatsapp_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="WhatsApp"
                            class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-[#111216] text-slate-400 transition hover:border-white/20 hover:text-white"
                        >
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        <!-- Email -->
                        <a
                            v-if="profile?.email"
                            :href="`mailto:${profile.email}`"
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
                    <h3
                        class="text-xs font-bold uppercase tracking-[0.2em] text-white"
                    >
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
                    <h3
                        class="text-xs font-bold uppercase tracking-[0.2em] text-white"
                    >
                        Contact
                    </h3>

                    <div class="mt-5 flex flex-col gap-4">

                        <!-- Email -->
                        <a
                            v-if="profile?.email"
                            :href="`mailto:${profile.email}`"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i
                                class="fa-solid fa-envelope w-4 text-xs"
                            ></i>

                            <span class="break-all">
                                {{ profile.email }}
                            </span>
                        </a>

                        <!-- Phone -->
                        <a
                            v-if="profile?.phone"
                            :href="`tel:${profile.phone}`"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i
                                class="fa-solid fa-phone w-4 text-xs"
                            ></i>

                            {{ profile.phone }}
                        </a>

                        <!-- Location -->
                        <div
                            v-if="profile?.location"
                            class="flex items-center gap-3 text-sm text-slate-500"
                        >
                            <i
                                class="fa-solid fa-location-dot w-4 text-xs"
                            ></i>

                            {{ profile.location }}
                        </div>

                        <!-- Website -->
                        <a
                            v-if="profile?.website_url"
                            :href="profile.website_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-3 text-sm text-slate-500 transition hover:text-white"
                        >
                            <i
                                class="fa-solid fa-globe w-4 text-xs"
                            ></i>

                            Mon site
                        </a>

                    </div>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- BOTTOM -->
            <!-- ================================================= -->

            <div
                class="flex flex-col gap-4 border-t border-white/10 py-7 sm:flex-row sm:items-center sm:justify-between"
            >

                <Small class="font-sans text-slate-600">
                    © {{ currentYear }}

                    {{ profile?.full_name || "Franck Kapula" }}.

                    Tous droits réservés.
                </Small>

                <div
                    class="flex items-center gap-2 text-slate-600"
                >
                    <span
                        class="h-2 w-2 rounded-full bg-[#ff02ab]"
                    ></span>

                    <Small class="font-sans text-slate-600">
                        {{ profile?.title || "Software Developer" }}
                    </Small>
                </div>

            </div>

        </div>
    </footer>
</template>
