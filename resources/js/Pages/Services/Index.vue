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
    services: {
        type: Array,
        default: () => [],
    },
});


/*
|--------------------------------------------------------------------------
| SERVICES
|--------------------------------------------------------------------------
*/

const services = props.services;


/*
|--------------------------------------------------------------------------
| SERVICES PRINCIPAUX
|--------------------------------------------------------------------------
*/

const featuredServices = services.filter(
    (service) => service.featured === true || service.featured === 1
);


/*
|--------------------------------------------------------------------------
| ICON
|--------------------------------------------------------------------------
|
| Si icon contient une classe Font Awesome :
| fa-solid fa-code
|
| Si icon contient une image :
| icons/service.png
|
|--------------------------------------------------------------------------
*/

const isImageIcon = (service) => {
    if (!service.icon) {
        return false;
    }

    return (
        service.icon.startsWith("/") ||
        service.icon.startsWith("http://") ||
        service.icon.startsWith("https://") ||
        service.icon.startsWith("storage/") ||
        service.icon.match(/\.(png|jpg|jpeg|gif|svg|webp)$/i)
    );
};


/*
|--------------------------------------------------------------------------
| ICON URL
|--------------------------------------------------------------------------
*/

const iconUrl = (service) => {
    return service?.icon || null;
};

/*
|--------------------------------------------------------------------------
| FONT AWESOME ICON
|--------------------------------------------------------------------------
*/

const serviceIcon = (service) => {
    if (!service.icon || isImageIcon(service)) {
        return "fa-solid fa-code";
    }

    return service.icon;
};
</script>


<template>
<!-- ========================================================= -->
<!-- SECTION 1 — MES SERVICES -->
<!-- ========================================================= -->

<section
    class="mx-auto overflow-hidden border border-white/10 bg-[#450057]"
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
                    Mes services
                </Heading>

            </div>


            <div class="mt-6">

                <Body
                    class="font-sans leading-8 text-white/60"
                >
                    Découvrez les services que je propose pour concevoir,
                    développer et améliorer des solutions numériques
                    adaptées à vos besoins.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- IMAGE -->
        <!-- ================================================= -->

        <div
            class="mt-4 flex w-full items-center justify-center lg:w-1/2"
        >

            <div
                class="h-64 w-64 sm:h-80 sm:w-80 lg:h-[24rem] lg:w-[24rem]"
            >

                <img
                    src="../../assets/icons/services.png"
                    alt="Mes services"
                    class="h-full w-full object-contain"
                />

            </div>

        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- SECTION 2 — SERVICES PRINCIPAUX -->
<!-- ========================================================= -->

<section
    v-if="featuredServices.length"
    class="bg-[#00574b] px-7 py-14 sm:px-10 lg:px-14"
>

    <!-- ================================================= -->
    <!-- HEADING -->
    <!-- ================================================= -->

    <div
        class="mx-auto mb-16 max-w-7xl px-6"
    >

        <Small
            class="font-sans uppercase tracking-[0.2em] text-emerald-300"
        >
            Mes domaines d'intervention
        </Small>


        <div class="mt-4">

            <Title
                class="font-sans text-white"
            >
                Services principaux
            </Title>

        </div>


        <div class="mt-4">

            <Body
                class="max-w-2xl font-sans leading-7 text-slate-300"
            >
                Les services sur lesquels je me concentre
                particulièrement dans mes projets professionnels.
            </Body>

        </div>

    </div>


    <!-- ================================================= -->
    <!-- FEATURED GRID -->
    <!-- ================================================= -->

    <div
        class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 md:grid-cols-2 lg:grid-cols-3"
    >

        <article
            v-for="(service, index) in featuredServices"
            :key="service.id"
            class="group relative overflow-hidden rounded-3xl border border-white/10 bg-[#101116] p-8 shadow-lg shadow-black/20 transition duration-300 hover:-translate-y-2 hover:border-emerald-300/40 hover:shadow-xl hover:shadow-black/30"
        >

            <!-- ================================================= -->
            <!-- TOP LINE -->
            <!-- ================================================= -->

            <div
                class="absolute left-0 top-0 h-1 w-full bg-emerald-400/70 transition duration-300 group-hover:bg-emerald-300"
            ></div>


            <!-- ================================================= -->
            <!-- HEADER -->
            <!-- ================================================= -->

            <div
                class="flex items-center justify-between"
            >

                <div
                    class="flex h-9 min-w-9 items-center justify-center rounded-full bg-emerald-400/10 px-3"
                >

                    <Small
                        class="font-sans font-semibold text-emerald-300"
                    >
                        {{ String(index + 1).padStart(2, "0") }}
                    </Small>

                </div>


                <Small
                    class="font-sans uppercase tracking-[0.15em] text-slate-600"
                >
                    Service
                </Small>

            </div>


            <!-- ================================================= -->
            <!-- ICON -->
            <!-- ================================================= -->

            <div class="mt-8">

                <div
                    class="flex h-20 w-20 items-center justify-center rounded-2xl border  bg-emerald-400/10 transition duration-300 group-hover:border-emerald-300/40 group-hover:bg-emerald-400/20"
                >

                    <!-- IMAGE -->

                    <img
                        v-if="isImageIcon(service)"
                        :src="iconUrl(service)"
                        :alt="service.title"
                        class="h-11 w-11 object-contain"
                    />


                    <!-- FONT AWESOME -->

                    <i
                        v-else
                        :class="serviceIcon(service)"
                        class="text-3xl text-emerald-300"
                    ></i>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- TITLE -->
            <!-- ================================================= -->

            <div class="mt-7">

                <Title
                    size="md"
                    class="font-sans text-xl text-white"
                >
                    {{ service.title }}
                </Title>

            </div>


            <!-- ================================================= -->
            <!-- DESCRIPTION -->
            <!-- ================================================= -->

            <div
                v-if="service.description"
                class="mt-4"
            >

                <Body
                    class="font-sans leading-7 text-slate-400"
                >
                    {{ service.description }}
                </Body>

            </div>


            <!-- ================================================= -->
            <!-- BOTTOM -->
            <!-- ================================================= -->

            <div
                class="mt-8 flex items-center justify-between border-t border-white/10 pt-5"
            >

                <Small
                    class="font-sans text-slate-600"
                >
                    Domaine d'expertise
                </Small>


                <span
                    class="h-2 w-2 rounded-full bg-emerald-400 transition duration-300 group-hover:scale-150"
                ></span>

            </div>

        </article>

    </div>

</section>


<!-- ========================================================= -->
<!-- SECTION 3 — TOUS LES SERVICES -->
<!-- ========================================================= -->

<section
    v-if="services.length"
    class="bg-[#00574b] px-7 py-14 sm:px-10 lg:px-14"
>

    <!-- ================================================= -->
    <!-- HEADING -->
    <!-- ================================================= -->

    <div
        class="mx-auto mb-16 max-w-7xl px-6"
    >

        <Small
            class="font-sans uppercase tracking-[0.2em] text-indigo-300"
        >
            Mon savoir-faire
        </Small>


        <div class="mt-4">

            <Title
                class="font-sans text-white"
            >
                Tous mes services
            </Title>

        </div>


        <div class="mt-4">

            <Body
                class="max-w-2xl font-sans leading-7 text-slate-300"
            >
                Retrouvez l'ensemble des services que je peux
                proposer dans le cadre de projets numériques.
            </Body>

        </div>

    </div>


    <!-- ================================================= -->
    <!-- SERVICES GRID -->
    <!-- ================================================= -->

    <div
        class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 md:grid-cols-2 lg:grid-cols-3"
    >

        <article
            v-for="(service, index) in services"
            :key="service.id"
            class="group relative rounded-2xl border border-white/10 bg-[#101116] p-6 transition duration-300 hover:-translate-y-6 hover:border-indigo-400/40 hover:bg-[#14151c]"
        >

            <!-- ================================================= -->
            <!-- NUMBER -->
            <!-- ================================================= -->

            <div
                class="flex items-center justify-between"
            >

                <Small
                    class="font-sans font-semibold text-indigo-400"
                >
                    {{ String(index + 1).padStart(2, "0") }}
                </Small>


                <Small
                    v-if="service.featured"
                    class="rounded-full bg-emerald-400/10 px-3 py-1 font-sans text-emerald-400"
                >
                    Principal
                </Small>

            </div>


            <!-- ================================================= -->
            <!-- ICON -->
            <!-- ================================================= -->

            <div class="mt-6">

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/5 transition duration-300 group-hover:bg-indigo-400/10"
                >

                    <!-- IMAGE -->

                    <img
                        v-if="isImageIcon(service)"
                        :src="iconUrl(service)"
                        :alt="service.title"
                        class="h-8 w-8 object-contain"
                    />


                    <!-- FONT AWESOME -->

                    <i
                        v-else
                        :class="serviceIcon(service)"
                        class="text-xl text-indigo-400"
                    ></i>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- TITLE -->
            <!-- ================================================= -->

            <div class="mt-6">

                <Title
                    size="md"
                    class="font-sans text-white"
                >
                    {{ service.title }}
                </Title>

            </div>


            <!-- ================================================= -->
            <!-- DESCRIPTION -->
            <!-- ================================================= -->

            <div
                v-if="service.description"
                class="mt-3"
            >

                <Body
                    class="font-sans leading-7 text-slate-400"
                >
                    {{ service.description }}
                </Body>

            </div>


            <!-- ================================================= -->
            <!-- FOOTER -->
            <!-- ================================================= -->



        </article>

    </div>

</section>


<!-- ========================================================= -->
<!-- EMPTY -->
<!-- ========================================================= -->

<section
    v-if="!services.length"
    class="mx-auto bg-[#101116] px-7 py-16 text-center sm:px-10"
>

    <div
        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
    >

        <i
            class="fa-solid fa-briefcase text-2xl text-slate-500"
        ></i>

    </div>


    <div class="mt-6">

        <Title
            size="md"
            class="font-sans text-white"
        >
            Aucun service disponible
        </Title>

    </div>


    <div
        class="mx-auto mt-3 max-w-md"
    >

        <Body
            class="font-sans text-slate-500"
        >
            Les services seront bientôt disponibles.
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


