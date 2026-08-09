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


/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

const props = defineProps({
    trainings: {
        type: Array,
        default: () => [],
    },
});


/*
|--------------------------------------------------------------------------
| GROUP TRAININGS BY CATEGORY
|--------------------------------------------------------------------------
|
| Toutes les formations ayant exactement la même catégorie
| sont automatiquement regroupées ensemble.
|
*/

const trainingGroups = Object.values(
    props.trainings.reduce((groups, training) => {

        const category =
            training.category?.trim() || "Autres";

        if (!groups[category]) {
            groups[category] = {
                category,
                trainings: [],
            };
        }

        groups[category].trainings.push(training);

        return groups;

    }, {})
);


/*
|--------------------------------------------------------------------------
| DATE FORMAT
|--------------------------------------------------------------------------
*/

const formatDate = (date) => {

    if (!date) {
        return null;
    }

    return new Date(date).toLocaleDateString("fr-FR", {
        month: "long",
        year: "numeric",
    });

};


/*
|--------------------------------------------------------------------------
| DATE RANGE
|--------------------------------------------------------------------------
*/

const formatDateRange = (training) => {

    const start = formatDate(training.start_date);
    const end = formatDate(training.end_date);

    if (start && end) {
        return `${start} — ${end}`;
    }

    if (start) {
        return `Depuis ${start}`;
    }

    if (end) {
        return `Jusqu'en ${end}`;
    }

    return null;

};


/*
|--------------------------------------------------------------------------
| CERTIFICATE
|--------------------------------------------------------------------------
*/

const hasCertificate = (training) => {

    return Boolean(training.certificate_file);

};


/*
|--------------------------------------------------------------------------
| CERTIFICATE URL
|--------------------------------------------------------------------------
*/

const certificateUrl = (training) => {

    if (!training.certificate_file) {
        return null;
    }

    if (
        training.certificate_file.startsWith("http://") ||
        training.certificate_file.startsWith("https://")
    ) {
        return training.certificate_file;
    }

    return `/storage/${training.certificate_file}`;

};


/*
|--------------------------------------------------------------------------
| EXTERNAL URL
|--------------------------------------------------------------------------
*/

const hasUrl = (training) => {

    return Boolean(training.url);

};


/*
|--------------------------------------------------------------------------
| IMAGE URL
|--------------------------------------------------------------------------
*/

const imageUrl = (training) => {

    if (!training.image) {
        return null;
    }

    if (
        training.image.startsWith("http://") ||
        training.image.startsWith("https://")
    ) {
        return training.image;
    }

    return `/storage/${training.image}`;

};
</script>


<template>

    <!-- ========================================================= -->
    <!-- SECTION 1 — MES FORMATIONS -->
    <!-- ========================================================= -->

    <section
        class="mx-auto  overflow-hidden border border-white/10 bg-[#450057]"
    >

        <div
            class="flex flex-col items-center gap-10 px-7 py-12 sm:px-10 lg:flex-row lg:px-14 lg:py-16"
        >

            <!-- ================================================= -->
            <!-- TEXT -->
            <!-- ================================================= -->

            <div
                class="w-full max-w-2xl lg:w-1/2"
            >

                <div class="mt-16">

                    <Heading
                        class="font-sans text-4xl text-white sm:text-5xl"
                    >
                        Mes formations
                    </Heading>

                </div>


                <div class="mt-6">

                    <Body
                        class="font-sans leading-8 text-white/60"
                    >
                        Découvrez les formations, certifications et
                        apprentissages qui ont contribué à développer
                        mes compétences professionnelles et techniques.
                    </Body>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- IMAGE -->
            <!-- ================================================= -->

            <div
                class="flex w-full mt-12 items-center justify-center lg:w-1/2"
            >

                <div
                    class=" sm:w-80 lg:h-[24rem] lg:w-[24rem]"
                >

                    <img
                        src="../../assets/icons/salle-de-classe.png"
                        alt="Mes formations"
                        class="h-full w-full object-contain"
                    />

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- SECTION 2 — PARCOURS / FORMATIONS -->
    <!-- ========================================================= -->

    <section
        v-if="trainingGroups.length"
        class="bg-[#00574b] px-7 py-12"
    >

        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <div
            class="mx-auto mb-16 max-w-7xl px-6"
        >

            <Title
                class="font-sans text-white"
            >
                Parcours de formation
            </Title>


            <div class="mt-4">

                <Body
                    class="font-sans max-w-2xl text-slate-300"
                >
                    Retrouvez les formations, certifications et
                    apprentissages que j'ai suivis au cours de mon
                    parcours.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- GROUPES PAR CATÉGORIE -->
        <!-- ================================================= -->

        <div
            class="mx-auto max-w-7xl space-y-16"
        >

            <div
                v-for="group in trainingGroups"
                :key="group.category"
            >

                <!-- ================================================= -->
                <!-- CATEGORY TITLE -->
                <!-- ================================================= -->

                <div
                    class="mb-8 flex items-center gap-5"
                >

                    <div
                        class="h-px flex-1 bg-white/10"
                    ></div>


                    <Small
                        class="font-sans uppercase  text-indigo-300"
                    >
                        {{ group.category }}
                    </Small>


                    <div
                        class="h-px flex-1 bg-white/10"
                    ></div>

                </div>


                <!-- ================================================= -->
                <!-- TRAININGS GRID -->
                <!-- ================================================= -->

                <div
                    class="grid grid-cols-1 gap-6 px-6 md:grid-cols-2 lg:grid-cols-3"
                >

                    <article
                        v-for="training in group.trainings"
                        :key="training.id"
                        class="group overflow-hidden rounded-3xl border border-white/10 bg-[#101116] transition duration-300 hover:border-indigo-400/30"
                    >

                        <!-- ================================================= -->
                        <!-- IMAGE FORMATION -->
                        <!-- ================================================= -->

                        <div
                            v-if="training.image"
                            class="h-48 w-full overflow-hidden bg-white/5"
                        >

                            <img
                                :src="imageUrl(training)"
                                :alt="training.title"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            />

                        </div>


                        <!-- ================================================= -->
                        <!-- CONTENT -->
                        <!-- ================================================= -->

                        <div class="p-6">

                            <!-- ================================================= -->
                            <!-- TOP -->
                            <!-- ================================================= -->

                            <div
                                class="flex items-start justify-between gap-4"
                            >

                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white/5"
                                >

                                    <i
                                        class="fa-solid fa-graduation-cap text-xl text-indigo-400"
                                    ></i>

                                </div>


                                <Small
                                    v-if="training.category"
                                    class="  px-3  font-sans text-indigo-400"
                                >
                                    {{ training.category }}
                                </Small>

                            </div>


                            <!-- ================================================= -->
                            <!-- TITLE -->
                            <!-- ================================================= -->

                            <div class="mt-6">

                                <Title
                                    size="md"
                                    class="font-sans text-white"
                                >
                                    {{ training.title }}
                                </Title>

                            </div>


                            <!-- ================================================= -->
                            <!-- ORGANIZATION -->
                            <!-- ================================================= -->

                            <div
                                v-if="training.organization"
                                class="mt-2"
                            >

                                <Small
                                    class="font-sans text-indigo-400"
                                >
                                    {{ training.organization }}
                                </Small>

                            </div>


                            <!-- ================================================= -->
                            <!-- DESCRIPTION -->
                            <!-- ================================================= -->

                            <div
                                v-if="training.description"
                                class="mt-5"
                            >

                                <Body
                                    class="font-sans leading-7 text-slate-400"
                                >
                                    {{ training.description }}
                                </Body>

                            </div>


                            <!-- ================================================= -->
                            <!-- DETAILS -->
                            <!-- ================================================= -->

                            <div
                                class="mt-6 space-y-3 border-t border-white/10 pt-5"
                            >

                                <!-- DATE -->

                                <div
                                    v-if="formatDateRange(training)"
                                    class="flex items-center gap-3"
                                >

                                    <i
                                        class="fa-regular fa-calendar text-sm text-indigo-400"
                                    ></i>

                                    <Small
                                        class="font-sans text-slate-500"
                                    >
                                        {{ formatDateRange(training) }}
                                    </Small>

                                </div>


                                <!-- DURATION -->

                                <div
                                    v-if="training.duration"
                                    class="flex items-center gap-3"
                                >

                                    <i
                                        class="fa-regular fa-clock text-sm text-indigo-400"
                                    ></i>

                                    <Small
                                        class="font-sans text-slate-500"
                                    >
                                        {{ training.duration }}
                                    </Small>

                                </div>


                                <!-- LOCATION -->

                                <div
                                    v-if="training.location"
                                    class="flex items-center gap-3"
                                >

                                    <i
                                        class="fa-solid fa-location-dot text-sm text-indigo-400"
                                    ></i>

                                    <Small
                                        class="font-sans text-slate-500"
                                    >
                                        {{ training.location }}
                                    </Small>

                                </div>

                            </div>


                            <!-- ================================================= -->
                            <!-- ACTIONS -->
                            <!-- ================================================= -->

                            <div
                                v-if="hasCertificate(training) || hasUrl(training)"
                                class="mt-6 flex flex-wrap gap-3"
                            >

                                <!-- CERTIFICATE -->

                                <a
                                    v-if="hasCertificate(training)"
                                    :href="certificateUrl(training)"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 font-sans text-sm text-white transition hover:bg-white hover:text-slate-900"
                                >

                                    <i
                                        class="fa-solid fa-certificate text-xs"
                                    ></i>

                                    Certificat

                                </a>


                                <!-- URL -->

                                <a
                                    v-if="hasUrl(training)"
                                    :href="training.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-400/10 px-4 py-2 font-sans text-sm text-indigo-300 transition hover:bg-indigo-400 hover:text-white"
                                >

                                    <i
                                        class="fa-solid fa-arrow-up-right-from-square text-xs"
                                    ></i>

                                    En savoir plus

                                </a>

                            </div>

                        </div>

                    </article>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- EMPTY -->
    <!-- ========================================================= -->

    <section
        v-if="!trainings.length"
        class="mx-auto mt-8 max-w-7xl rounded-3xl border border-dashed border-white/10 bg-[#101116] p-16 text-center"
    >

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
        >

            <i
                class="fa-solid fa-graduation-cap text-2xl text-slate-500"
            ></i>

        </div>


        <div class="mt-6">

            <Title
                size="md"
                class="font-sans text-white"
            >
                Aucune formation disponible
            </Title>

        </div>


        <div class="mx-auto mt-3 max-w-md">

            <Body
                class="font-sans text-slate-500"
            >
                Les formations seront bientôt disponibles.
            </Body>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- BACK -->
    <!-- ========================================================= -->

    <div
        class="mx-auto mt-16 max-w-7xl px-6"
    >

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

</template>