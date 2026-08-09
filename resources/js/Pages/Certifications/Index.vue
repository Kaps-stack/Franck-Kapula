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
    certifications: {
        type: Array,
        default: () => [],
    },
});


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
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};


/*
|--------------------------------------------------------------------------
| CERTIFICATION STATUS
|--------------------------------------------------------------------------
*/

const certificationStatus = (certification) => {
    if (!certification.expiration_date) {
        return "Valide";
    }

    const expirationDate = new Date(
        certification.expiration_date
    );

    const today = new Date();

    if (expirationDate >= today) {
        return "Valide";
    }

    return "Expirée";
};


/*
|--------------------------------------------------------------------------
| STATUS CLASS
|--------------------------------------------------------------------------
*/

const statusClass = (certification) => {
    if (certificationStatus(certification) === "Expirée") {
        return "bg-red-500/10 text-red-400";
    }

    return "bg-green-500/10 text-green-400";
};


/*
|--------------------------------------------------------------------------
| CERTIFICATE URL
|--------------------------------------------------------------------------
*/

const certificateUrl = (certification) => {
    if (!certification.certificate_file) {
        return null;
    }

    if (
        certification.certificate_file.startsWith("http://") ||
        certification.certificate_file.startsWith("https://")
    ) {
        return certification.certificate_file;
    }

    return `/storage/${certification.certificate_file}`;
};


/*
|--------------------------------------------------------------------------
| HAS CERTIFICATE
|--------------------------------------------------------------------------
*/

const hasCertificate = (certification) => {
    return Boolean(certification.certificate_file);
};


/*
|--------------------------------------------------------------------------
| HAS CREDENTIAL URL
|--------------------------------------------------------------------------
*/

const hasCredentialUrl = (certification) => {
    return Boolean(certification.credential_url);
};


/*
|--------------------------------------------------------------------------
| HAS CREDENTIAL ID
|--------------------------------------------------------------------------
*/

const hasCredentialId = (certification) => {
    return Boolean(certification.credential_id);
};
</script>


<template>

    <!-- ========================================================= -->
    <!-- SECTION 1 — MES CERTIFICATIONS -->
    <!-- ========================================================= -->

    <section
        class="mx-auto  n bg-[#3b0033] border border-white/10"
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
                        class="mt-5 font-sans text-4xl text-white sm:text-5xl"
                    >
                        Mes certifications
                    </Heading>

                </div>


                <div class="mt-6">

                    <Body
                        class="font-sans leading-8 text-white/60"
                    >
                        Découvrez les certifications obtenues au cours
                        de mon parcours et les compétences validées
                        auprès de différentes organisations.
                    </Body>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- IMAGE / ICON -->
            <!-- ================================================= -->

            <div
                class="flex w-full items-center justify-center lg:w-1/2"
            >

                <div
                    class="flex h-64 w-64 items-center justify-center sm:h-80 sm:w-80 lg:h-[24rem] lg:w-[24rem]"
                >

                    <div
                        class="flex h-48 w-48 items-center justify-center rounded-full border border-yellow-400/20 bg-yellow-400/5 sm:h-60 sm:w-60 lg:h-72 lg:w-72"
                    >

                        <i
                            class="fa-solid fa-award text-7xl text-"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- SECTION 2 — PARCOURS / CERTIFICATIONS -->
    <!-- ========================================================= -->

    <section
        v-if="certifications.length"
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
                Parcours de certifications
            </Title>


            <div class="mt-4">

                <Body
                    class="font-sans max-w-2xl text-white/60"
                >
                    Retrouvez les certifications obtenues au cours
                    de mon parcours ainsi que les informations
                    associées à chacune d'elles.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- CERTIFICATIONS -->
        <!-- ================================================= -->

        <div
            class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 md:grid-cols-2 lg:grid-cols-3"
        >

            <article
                v-for="certification in certifications"
                :key="certification.id"
                class="group relative overflow-hidden border border-white/10 bg-[#101116] transition duration-300 hover:border-yellow-400/40"
            >

                <!-- ================================================= -->
                <!-- TOP LINE -->
                <!-- ================================================= -->

                


                <!-- ================================================= -->
                <!-- CONTENT -->
                <!-- ================================================= -->

                <div class="p-6">

                    <!-- ================================================= -->
                    <!-- HEADER -->
                    <!-- ================================================= -->

                    <div
                        class="flex items-start justify-between gap-4"
                    >

                        <!-- ICON -->

                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center bg-yellow-400/10"
                        >

                            <i
                                class="fa-solid fa-certificate text-xl text-yellow-400"
                            ></i>

                        </div>


                        <!-- STATUS -->

                        <Small
                            class="font-sans"
                            :class="statusClass(certification)"
                        >
                            {{ certificationStatus(certification) }}
                        </Small>

                    </div>


                    <!-- ================================================= -->
                    <!-- NAME -->
                    <!-- ================================================= -->

                    <div class="mt-6">

                        <Title
                            size="md"
                            class="font-sans text-white"
                        >
                            {{ certification.name }}
                        </Title>

                    </div>


                    <!-- ================================================= -->
                    <!-- ISSUER -->
                    <!-- ================================================= -->

                    <div
                        v-if="certification.issuer"
                        class="mt-2"
                    >

                        <Small
                            class="font-sans text-yellow-400"
                        >
                            {{ certification.issuer }}
                        </Small>

                    </div>


                    <!-- ================================================= -->
                    <!-- DESCRIPTION -->
                    <!-- ================================================= -->

                    <div
                        v-if="certification.description"
                        class="mt-5"
                    >

                        <Body
                            class="font-sans leading-7 text-slate-400"
                        >
                            {{ certification.description }}
                        </Body>

                    </div>


                    <!-- ================================================= -->
                    <!-- DETAILS -->
                    <!-- ================================================= -->

                    <div
                        class="mt-6 space-y-3 border-t border-white/10 pt-5"
                    >

                        <!-- ISSUE DATE -->

                        <div
                            v-if="certification.issue_date"
                            class="flex items-center gap-3"
                        >

                            <i
                                class="fa-regular fa-calendar text-sm text-yellow-400"
                            ></i>

                            <div>

                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    Obtention
                                </Small>


                                <Small
                                    class="ml-2 font-sans text-slate-300"
                                >
                                    {{ formatDate(certification.issue_date) }}
                                </Small>

                            </div>

                        </div>


                        <!-- EXPIRATION -->

                        <div
                            v-if="certification.expiration_date"
                            class="flex items-center gap-3"
                        >

                            <i
                                class="fa-regular fa-clock text-sm text-yellow-400"
                            ></i>

                            <div>

                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    Expiration
                                </Small>


                                <Small
                                    class="ml-2 font-sans text-slate-300"
                                >
                                    {{ formatDate(certification.expiration_date) }}
                                </Small>

                            </div>

                        </div>


                        <!-- CREDENTIAL -->

                        <div
                            v-if="hasCredentialId(certification)"
                            class="flex items-start gap-3"
                        >

                            <i
                                class="fa-solid fa-fingerprint mt-1 text-sm text-yellow-400"
                            ></i>

                            <div class="min-w-0">

                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    Identifiant
                                </Small>


                                <Small
                                    class="mt-1 block break-all font-mono text-xs text-slate-400"
                                >
                                    {{ certification.credential_id }}
                                </Small>

                            </div>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- ACTIONS -->
                    <!-- ================================================= -->

                    <div
                        v-if="
                            hasCertificate(certification) ||
                            hasCredentialUrl(certification)
                        "
                        class="mt-6 flex flex-wrap gap-3"
                    >

                        <!-- CERTIFICATE -->

                        <a
                            v-if="hasCertificate(certification)"
                            :href="certificateUrl(certification)"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-yellow-400 px-4 py-2 font-sans text-sm font-medium text-black transition hover:bg-yellow-300"
                        >

                            <i
                                class="fa-solid fa-file-lines text-xs"
                            ></i>

                            Certificat

                        </a>


                        <!-- CREDENTIAL -->

                        <a
                            v-if="hasCredentialUrl(certification)"
                            :href="certification.credential_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 border border-white/10 bg-white/5 px-4 py-2 font-sans text-sm text-white transition hover:bg-white hover:text-black"
                        >

                            <i
                                class="fa-solid fa-arrow-up-right-from-square text-xs"
                            ></i>

                            Vérifier

                        </a>

                    </div>

                </div>

            </article>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- SECTION 3 — EMPTY -->
    <!-- ========================================================= -->

    <section
        v-else
        class="mx-auto  bg-[#003626] px-7 py-16 text-center"
    >

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center bg-white/5"
        >

            <i
                class="fa-solid fa-award text-2xl text-slate-500"
            ></i>

        </div>


        <div class="mt-6">

            <Title
                size="md"
                class="font-sans text-white"
            >
                Aucune certification disponible
            </Title>

        </div>


        <div
            class="mx-auto mt-3 max-w-md"
        >

            <Body
                class="font-sans text-slate-500"
            >
                Les certifications seront bientôt disponibles.
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