<script setup>
import { Link } from "@inertiajs/vue3";

import Layout from "@/Layouts/PortfolioLayout.vue";

import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

defineOptions({
    layout: Layout,
});

defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
});


/*
|--------------------------------------------------------------------------
| FORMAT DATE
|--------------------------------------------------------------------------
*/

const formatDate = (date) => {
    if (!date) {
        return null;
    }

    return new Intl.DateTimeFormat("fr-FR", {
        month: "long",
        year: "numeric",
    }).format(new Date(date));
};


/*
|--------------------------------------------------------------------------
| IMAGE URL
|--------------------------------------------------------------------------
*/

const getImageUrl = (image) => {
    if (!image) {
        return null;
    }

    if (
        image.startsWith("http://") ||
        image.startsWith("https://")
    ) {
        return image;
    }

    return `/storage/${image}`;
};
</script>


<template>

    <!-- ========================================================= -->
    <!-- PAGE -->
    <!-- ========================================================= -->

    <div class="min-h-screen bg-[#00574b]  px-6 pb-32 pt-32 text-white">

        <!-- ================================================= -->
        <!-- HEADER -->
        <!-- ================================================= -->

        <div class="mb-20 max-w-3xl">


            <div class="mt-5"> 

                <Heading
                    class="font-sans text-4xl text-white sm:text-5xl"
                >
                    Mes projets
                </Heading>

            </div>


            <div class="mt-6">

                <Body
                    class="font-sans leading-8 text-white/60"
                >
                    Découvrez les différents projets que j'ai conçus
                    et développés, des prototypes aux applications
                    complètes.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- PROJECTS GRID -->
        <!-- ================================================= -->

        <div
            v-if="projects.length"
            class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3"
        >

            <!-- ================================================= -->
            <!-- PROJECT CARD -->
            <!-- ================================================= -->

            <article
                v-for="(project, index) in projects"
                :key="project.id"
                class="group flex h-full flex-col overflow-hidden rounded-3xl border border-white/10 bg-[#101116] transition duration-300 hover:border-white/20"
            >

                <!-- ================================================= -->
                <!-- IMAGE -->
                <!-- ================================================= -->

                <div
                    class="relative aspect-[16/10] shrink-0 overflow-hidden bg-[#202126]"
                >

                    <!-- Image -->

                    <img
                        v-if="project.image"
                        :src="getImageUrl(project.image)"
                        :alt="project.title"
                        class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                    />


                    <!-- Placeholder -->

                    <div
                        v-else
                        class="flex h-full items-center justify-center bg-[#202126]"
                    >

                        <span
                            class="text-[7rem] font-black tracking-tighter text-white/5"
                        >
                            {{ String(index + 1).padStart(2, "0") }}
                        </span>

                    </div>


                    <!-- ================================================= -->
                    <!-- NUMBER -->
                    <!-- ================================================= -->

                    <div
                        class="absolute left-5 top-5 rounded-xl bg-[#111216]/80 px-3 py-2 backdrop-blur-sm"
                    >

                        <Small
                            class="font-mono text-slate-400"
                        >
                            {{ String(index + 1).padStart(2, "0") }}
                        </Small>

                    </div>


                    <!-- ================================================= -->
                    <!-- FEATURED -->
                    <!-- ================================================= -->

                    <div
                        v-if="project.featured"
                        class="absolute right-5 top-5"
                    >

                        <Small
                            class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-3 py-2 text-white"
                        >

                            <span>
                                ★
                            </span>

                            Mis en avant

                        </Small>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- PROJECT CONTENT -->
                <!-- ================================================= -->

                <div
                    class="flex flex-1 flex-col p-6 sm:p-7"
                >

                    <!-- ================================================= -->
                    <!-- TITLE -->
                    <!-- ================================================= -->

                    <div>

                        <Title
                            size="md"
                            class="font-sans text-2xl text-white"
                        >
                            {{ project.title }}
                        </Title>


                        <!-- ================================================= -->
                        <!-- CATEGORY / STATUS -->
                        <!-- ================================================= -->

                        <div
                            class="mt-4 flex flex-wrap items-center gap-2"
                        >

                            <!-- Category -->

                            <Small
                                v-if="project.category"
                                class="inline-flex rounded-full border border-indigo-400/20 bg-indigo-400/10 px-3 py-1.5 font-sans text-indigo-300"
                            >
                                {{ project.category }}
                            </Small>


                            <!-- Status -->

                            <Small
                                v-if="project.status"
                                class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1.5 font-sans text-slate-400"
                            >
                                {{ project.status }}
                            </Small>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- DATES -->
                    <!-- ================================================= -->

                    <div
                        v-if="
                            project.start_date ||
                            project.end_date
                        "
                        class="mt-4"
                    >

                        <Small
                            class="font-sans text-slate-500"
                        >

                            <span
                                v-if="project.start_date"
                            >
                                {{ formatDate(project.start_date) }}
                            </span>


                            <span
                                v-if="
                                    project.start_date &&
                                    project.end_date
                                "
                                class="mx-1"
                            >
                                —
                            </span>


                            <span
                                v-if="project.end_date"
                            >
                                {{ formatDate(project.end_date) }}
                            </span>


                            <span
                                v-else-if="project.start_date"
                                class="text-indigo-400"
                            >
                                — Présent
                            </span>

                        </Small>

                    </div>


                    <!-- ================================================= -->
                    <!-- DESCRIPTION -->
                    <!-- ================================================= -->

                    <div
                        v-if="project.description"
                        class="mt-6"
                    >

                        <Body
                            class="font-sans leading-7 text-slate-300"
                        >
                            {{ project.description }}
                        </Body>

                    </div>


                    <!-- ================================================= -->
                    <!-- CONTENT -->
                    <!-- ================================================= -->

                    <div
                        v-if="project.content"
                        class="mt-7 border-t border-white/10 pt-6"
                    >

                        <Small
                            class="font-sans uppercase tracking-[0.18em] text-slate-500"
                        >
                            À propos
                        </Small>


                        <div class="mt-3">

                            <Body
                                class="whitespace-pre-line font-sans text-sm leading-7 text-slate-400"
                            >
                                {{ project.content }}
                            </Body>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- TECHNOLOGIES -->
                    <!-- ================================================= -->

                    <div
                        v-if="
                            project.skills &&
                            project.skills.length
                        "
                        class="mt-7 border-t border-white/10 pt-6"
                    >

                        <Small
                            class="font-sans uppercase tracking-[0.18em] text-slate-500"
                        >
                            Technologies utilisées
                        </Small>


                        <div
                            class="mt-4 flex flex-wrap gap-2"
                        >

                            <span
                                v-for="skill in project.skills"
                                :key="skill.id"
                                class="rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 font-sans text-xs text-slate-300 transition hover:border-indigo-400/30 hover:text-indigo-300"
                            >
                                {{ skill.name }}
                            </span>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- LINKS -->
                    <!-- ================================================= -->

                    <div
                        v-if="
                            project.demo_url ||
                            project.github_url
                        "
                        class="mt-auto pt-8"
                    >

                        <div
                            class="flex flex-wrap gap-3 border-t border-white/10 pt-6"
                        >

                            <!-- ================================================= -->
                            <!-- DEMO -->
                            <!-- ================================================= -->

                            <a
                                v-if="project.demo_url"
                                :href="project.demo_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 font-sans text-sm text-slate-900 transition hover:bg-slate-200"
                            >

                                <i
                                    class="fa-solid fa-arrow-up-right-from-square"
                                ></i>

                                Démo

                            </a>


                            <!-- ================================================= -->
                            <!-- GITHUB -->
                            <!-- ================================================= -->

                            <a
                                v-if="project.github_url"
                                :href="project.github_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-5 py-2.5 font-sans text-sm text-white transition hover:bg-white hover:text-slate-900"
                            >

                                <i
                                    class="fa-brands fa-github"
                                ></i>

                                GitHub

                            </a>

                        </div>

                    </div>

                </div>

            </article>

        </div>


        <!-- ================================================= -->
        <!-- EMPTY STATE -->
        <!-- ================================================= -->

        <div
            v-else
            class="rounded-3xl border border-dashed border-white/10 bg-[#101116] p-16 text-center"
        >

            <!-- Icon -->

            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
            >

                <i
                    class="fa-solid fa-code text-2xl text-slate-500"
                ></i>

            </div>


            <!-- Title -->

            <div class="mt-6">

                <Title
                    size="md"
                    class="font-sans text-white"
                >
                    Aucun projet disponible
                </Title>

            </div>


            <!-- Description -->

            <div
                class="mx-auto mt-3 max-w-md"
            >

                <Body
                    class="font-sans text-slate-500"
                >
                    Aucun projet n'est disponible pour le moment.
                    Revenez prochainement pour découvrir mes
                    réalisations.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- BACK -->
        <!-- ================================================= -->

        <div class="mt-16">

            <Link
                href="/"
                class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-6 py-3 font-sans text-sm text-white transition hover:bg-white hover:text-slate-900"
            >

                <span>
                    ←
                </span>

                Retour à l'accueil

            </Link>

        </div>

    </div>

</template>