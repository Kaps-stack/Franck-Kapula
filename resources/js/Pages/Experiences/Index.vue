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
    experiences: {
        type: Array,
        default: () => [],
    },
});

/*
|--------------------------------------------------------------------------
| Format date
|--------------------------------------------------------------------------
| Exemple :
| 2026-07-31 -> 07/2026
*/
const formatDate = (date) => {
    if (!date) {
        return null;
    }

    const value = new Date(date);

    if (Number.isNaN(value.getTime())) {
        return null;
    }

    return new Intl.DateTimeFormat("fr-FR", {
        month: "2-digit",
        year: "numeric",
    }).format(value);
};
</script>

<template>
    <div
        class="min-h-screen bg-[#0d0e13] px-6 pb-32 pt-32 text-white"
    >
        <div class="mx-auto max-w-7xl">

            <!-- ================================================= -->
            <!-- HEADER -->
            <!-- ================================================= -->

            <div class="mb-20 max-w-3xl">



                <div class="mt-5">
                    <Heading
                        class="font-sans text-4xl text-white sm:text-5xl"
                    >
                        Mon parcours professionnel
                    </Heading>
                </div>

                <div class="mt-6">
                    <Body
                        class="font-sans text-white/60"
                    >
                        Découvrez les différentes expériences qui
                        ont contribué à cmon progrès professionnel
                    </Body>
                </div>

            </div>


            <!-- ================================================= -->
            <!-- EXPERIENCES -->
            <!-- ================================================= -->

            <div
                v-if="experiences.length"
                class="relative border-l border-white/10"
            >

                <article
                    v-for="experience in experiences"
                    :key="experience.id"
                    class="relative pb-20 pl-8 sm:pl-12"
                >

                    <!-- DOT -->

                    <span
                        class="absolute -left-[6px] top-1 h-3 w-3 rounded-full bg-indigo-400 ring-8 ring-[#08090d]"
                    ></span>


                    <div
                        class="grid gap-8 lg:grid-cols-[220px_1fr]"
                    >

                        <!-- ================================================= -->
                        <!-- DATE -->
                        <!-- ================================================= -->

                        <div>

                            <Small
                                class="font-sans text-slate-500"
                            >
                                {{ formatDate(experience.start_date) }}

                                <span class="mx-1">
                                    —
                                </span>

                                <span
                                    v-if="
                                        experience.current ||
                                        !experience.end_date
                                    "
                                    class="text-indigo-400"
                                >
                                    Présent
                                </span>

                                <span v-else>
                                    {{ formatDate(experience.end_date) }}
                                </span>
                            </Small>

                        </div>


                        <!-- ================================================= -->
                        <!-- CONTENT -->
                        <!-- ================================================= -->

                        <div class="max-w-3xl">

                            <Heading
                                class="font-sans text-2xl text-white"
                            >
                                {{ experience.position }}
                            </Heading>


                            <!-- COMPANY -->

                            <div
                                class="mt-2 flex flex-wrap items-center gap-3"
                            >

                                <Small
                                    class="font-sans text-indigo-400"
                                >
                                    {{ experience.company }}
                                </Small>

                                <span
                                    v-if="experience.location"
                                    class="text-white/20"
                                >
                                    •
                                </span>

                                <Small
                                    v-if="experience.location"
                                    class="font-sans text-slate-500"
                                >
                                    {{ experience.location }}
                                </Small>

                            </div>


                            <!-- TYPE -->

                            <div
                                v-if="experience.type"
                                class="mt-3"
                            >

                                <Small
                                    class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 font-sans text-slate-400"
                                >
                                    {{ experience.type }}
                                </Small>

                            </div>


                            <!-- DESCRIPTION -->

                            <div class="mt-6">

                                <Body
                                    class="font-sans leading-8 text-slate-400"
                                >
                                    {{ experience.description }}
                                </Body>

                            </div>


                            <!-- COMPANY URL -->

                            <div
                                v-if="experience.company_url"
                                class="mt-6"
                            >

                                <a
                                    :href="experience.company_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 border-b border-white/20 pb-1 font-sans text-sm text-white transition hover:border-indigo-400 hover:text-indigo-400"
                                >
                                    Voir l'entreprise

                                    <span>
                                        ↗
                                    </span>
                                </a>

                            </div>

                        </div>

                    </div>

                </article>

            </div>


            <!-- ================================================= -->
            <!-- EMPTY -->
            <!-- ================================================= -->

            <div
                v-else
                class="rounded-3xl border border-dashed border-white/10 bg-[#101116] p-16 text-center"
            >

                <Body class="font-sans text-slate-500">
                    Aucune expérience disponible pour le moment.
                </Body>

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
    </div>
</template>
