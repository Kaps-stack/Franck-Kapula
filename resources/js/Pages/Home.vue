<script setup>
import { nextTick, onBeforeUnmount, onMounted, ref } from "vue";
import { Motion } from "motion-v"
import PhotoCarousel from "@/Components/PhotoCarousel.vue";
import Body from "@/Components/Typography/Body.vue";
import Heading from "@/Components/Typography/Heading.vue";
import Small from "@/Components/Typography/Small.vue";
import Title from "@/Components/Typography/Title.vue";
import { Head, Link } from "@inertiajs/vue3";
import lottie from "lottie-web";

import Layout from "@/Layouts/PortfolioLayout.vue";

import codingManAnimation from "../assets/animations/coding_man.json";
import splashAnimation from "../assets/animations/splash.json";
import { ref, onMounted } from "vue";

const typedBio = ref("");

const startTyping = () => {
    const text =
        profile?.bio?.substring(0, 500) + "..." ||
        "Je transforme des idées en expériences numériques utiles, modernes et accessibles.";

    let index = 0;

    const interval = setInterval(() => {
        typedBio.value += text[index];

        index++;

        if (index >= text.length) {
            clearInterval(interval);
        }
    }, 35);
};

onMounted(() => {
    startTyping();
});

defineOptions({
    layout: Layout,
});

// =========================================================
// PROPS
// =========================================================

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

// =========================================================
// LOTTIE
// =========================================================

const animationSplash = ref(null);
const animationCodingMan = ref(null);

let splash = null;
let codingMan = null;

// =========================================================
// INIT LOTTIE
// =========================================================

onMounted(async () => {
    await nextTick();

    // =====================================================
    // SPLASH — BACKGROUND
    // =====================================================

    if (animationSplash.value) {
        splash = lottie.loadAnimation({
            container: animationSplash.value,
            renderer: "svg",
            loop: true,
            autoplay: true,
            animationData: splashAnimation,
            rendererSettings: {
                preserveAspectRatio: "xMidYMid slice",
            },
        });
    }

    // =====================================================
    // CODING MAN — HERO
    // =====================================================

    if (animationCodingMan.value) {
        codingMan = lottie.loadAnimation({
            container: animationCodingMan.value,
            renderer: "svg",
            loop: true,
            autoplay: true,
            animationData: codingManAnimation,
            rendererSettings: {
                preserveAspectRatio: "xMidYMid meet",
            },
        });
    }
});

// =========================================================
// DESTROY LOTTIE
// =========================================================

onBeforeUnmount(() => {
    if (splash) {
        splash.destroy();
        splash = null;
    }

    if (codingMan) {
        codingMan.destroy();
        codingMan = null;
    }
});

const formatMonthYear = (date) => {
    if (!date) {
        return "";
    }

    const parsedDate = new Date(date);

    if (Number.isNaN(parsedDate.getTime())) {
        return "";
    }

    const month = String(parsedDate.getMonth() + 1).padStart(2, "0");
    const year = parsedDate.getFullYear();

    return `${month}/${year}`;
};
</script>

<template>
    <Head :title="profile?.full_name || 'Franck Kapula'" />

    <div class="bg-[#08090d] text-white">
        <!-- ========================================================= -->
        <!-- HERO -->
        <!-- ========================================================= -->

        <section
            class="relative flex min-h-screen items-center overflow-hidden bg-[#001d3d] px-6 pt-24"
        >
            <!-- ===================================================== -->
            <!-- SPLASH BACKGROUND -->
            <!-- ===================================================== -->

            <!-- ===================================================== -->
            <!-- HERO CONTENT -->
            <!-- ===================================================== -->

            <div
                class="relative z-10 mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-12 lg:flex-row lg:gap-16"
            >
                <!-- ================================================= -->
                <!-- TEXT CONTENT -->
                <!-- ================================================= -->

                <div
                    class="relative z-20 mt-6 w-full max-w-3xl text-center lg:text-left"
                >
                    <!-- Greeting -->
                    <Small
                        class="font-sans inline-block rounded-xl bg-[#6B21A8]/20 px-4 py-2 text-white"
                    >
<Motion
    :animate="{
        scale: [1, 1.2, 1.2, 1],
        rotate: [0, -12, 12, -8, 8, 0]
    }"
    :transition="{
        duration: 2,
        repeat: Infinity,
        ease: 'easeInOut'
    }"
>
    <i class="fa-solid fa-hand-peace text-amber-100"></i>
</Motion>

                        Hi, je suis
                        {{ profile?.full_name || "Franck Kapula" }}
                    </Small>

                    <!-- Title -->
                    <div
                        class="mt-7 flex items-center justify-center lg:justify-start"
                    >
                        <Motion
                            :initial="{
                                opacity: 0,
                                x: 100,
                            }"
                            :whileInView="{
                                opacity: 1,
                                x: 0,
                            }"
                            :transition="{
                                duration: 0.8,
                                ease: 'easeOut',
                            }"
                        >
                            <h1 class="bitcount text-4xl text-white">
                                <span class="text-[#ff02ab]"> Un </span>

                                {{ profile?.title || "Software Developer" }}

                                <span class="text-[#ff02ab]">
                                    Qui Transforme vos idées en solutions
                                    concrètes
                                </span>
                            </h1>
                        </Motion>
                    </div>

                    <!-- Bio -->
                    <div class="mx-auto mt-6 max-w-3xl lg:mx-auto />
<Motion
    class="relative mt-6"
    :initial="{
        opacity:0
    }"
    :whileInView="{
        opacity:1
    }"
    :viewport="{
        once:true
    }"
    :transition="{
        duration:0.8
    }"
>

    <Body class="font-sans text-justify text-white/80">
        {{ typedBio }}

        <Motion
            class="ml-2 inline-block"
            :animate="{
                rotate:[-15,10,-15],
                y:[0,-3,0]
            }"
            :transition="{
                duration:0.8,
                repeat:Infinity,
                ease:'easeInOut'
            }"
        >
            <i class="fa-solid fa-pencil text-amber-200"></i>
        </Motion>

    </Body>

</Motion>
                    </div>

                    <!-- Button -->
                    <div
                        class="font-sans mt-10 flex flex-wrap items-center justify-center gap-4 lg:justify-start"
                    >
                        <Link
                            href="/game"
                            class="inline-flex items-center gap-3 rounded-full bg-white px-7 py-4 text-slate-900 transition hover:bg-slate-200"
                        >
                            <Small class="text-slate-900">
                                Explorer mon univers
                            </Small>

                            <span>→</span>
                        </Link>

                        <!-- TELECHARGER CV -->
                        <a
                            v-if="profile?.cv"
                            :href="profile.cv"
                            target="_blank"
                            download
                            class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-7 py-4 text-white transition hover:bg-white/20"
                        >
                            <i class="fa-solid fa-download text-sm"></i>
                            <Small class="text-white">
                                Télécharger mon CV
                            </Small>
                        </a>
                    </div>
                </div>

                <!-- ================================================= -->
                <!-- CODING MAN -->
                <!-- ================================================= -->

                <div
                    class="relative z-20 flex w-full shrink-0 items-center justify-center lg:w-[42%]"
                >
                    <div
                        ref="animationCodingMan"
                        class="lottie-coding h-64 w-64 sm:h-80 sm:w-80 lg:h-[28rem] lg:w-[28rem] xl:h-[32rem] xl:w-[32rem]"
                    ></div>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- CAROUSSEL -->
        <!-- ========================================================= -->

        <PhotoCarousel />

        <!-- ========================================================= -->
        <!-- PROJECTS -->
        <!-- ========================================================= -->

        <section id="projects" class="relative bg-[#00574b] px-6 py-32">
            <div class="mx-auto max-w-7xl">
                <!-- ===================================================== -->
                <!-- HEADING -->
                <!-- ===================================================== -->

                <div
                    class="mb-16 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                >
                    <div>
                        <div class="mt-3">
                            <Title class="text-white font-sans">
                                01 — Mes projets
                            </Title>
                        </div>
                    </div>

                    <Body
                        class="font-sans max-w-md text-slate-400 sm:text-right"
                    >
                        Quelques projets sur lesquels j'ai travaillé et les
                        solutions que j'ai développées.
                    </Body>
                </div>

                <!-- ===================================================== -->
                <!-- PROJECTS GRID -->
                <!-- ===================================================== -->

                <div
                    v-if="projects?.length"
                    class="grid grid-cols-1 gap-8 lg:grid-cols-2"
                >
                    <article
                        v-for="(project, index) in projects"
                        :key="project.id"
                        class="group overflow-hidden rounded-3xl border border-white/10 bg-[#02302a] transition duration-300 hover:border-white/20"
                    >
                        <!-- ================================================= -->
                        <!-- IMAGE -->
                        <!-- ================================================= -->

                        <div
                            class="relative aspect-[16/10] overflow-hidden bg-[#202126]"
                        >
                            <img
                                v-if="project.image"
                                :src="project.image"
                                :alt="project.title"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
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

                            <!-- Number -->
                            <div
                                class="absolute left-5 top-5 rounded-lg bg-[#111216]/80 px-3 py-2 backdrop-blur-sm"
                            >
                                <Small
                                    class="font-mono font-sans text-slate-400"
                                >
                                    {{ String(index + 1).padStart(2, "0") }}
                                </Small>
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- CONTENT -->
                        <!-- ================================================= -->

                        <div class="p-6 sm:p-8">
                            <!-- Title -->
                            <Title size="md" class="text-white font-sans">
                                {{ project.title }}
                            </Title>

                            <!-- Description -->
                            <div class="mt-4">
                                <Body class="text-slate-400 font-sans">
                                    {{ project.description }}
                                </Body>
                            </div>

                            <!-- Link -->
                            <div class="mt-7">
                                <Link
                                    :href="`/projects/${project.id}`"
                                    class="inline-flex items-center gap-3 border-b border-white/20 pb-1 text-white transition hover:border-white"
                                >
                                    <Small class="text-white font-sans">
                                        Voir le projet
                                    </Small>

                                    <span> ↗ </span>
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- ===================================================== -->
                <!-- EMPTY STATE -->
                <!-- ===================================================== -->

                <div
                    v-else
                    class="rounded-3xl border border-dashed border-white/10 bg-[#191a1f] p-16 text-center"
                >
                    <Body class="text-slate-500 font-sans">
                        Aucun projet disponible pour le moment.
                    </Body>
                </div>

                <!-- ===================================================== -->
                <!-- ALL PROJECTS BUTTON -->
                <!-- ===================================================== -->

                <div v-if="projects?.length" class="mt-14 flex justify-center">
                    <Link
                        href="/game"
                        class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-[#191a1f] px-7 py-4 text-white transition hover:bg-[#24252b]"
                    >
                        <Small class="text-white font-sans">
                            Voir tous les projets
                        </Small>

                        <span> → </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- EXPERIENCE -->
        <!-- ========================================================= -->

        <section
            id="experience"
            class="relative border-y border-white/10 bg-[#0d0e13] px-6 py-32"
        >
            <div class="mx-auto max-w-7xl">
                <!-- Heading -->
                <div class="mb-20">
                    <Title class="font-sans text-white">
                        02 — Experience
                    </Title>

                    <div class="mt-4">
                        <Heading class="font-sans text-indigo-400">
                            Mon parcours professionnel
                        </Heading>
                    </div>
                </div>

                <!-- Experiences -->
                <div
                    v-if="experiences?.length"
                    class="relative ml-2 border-l border-white/10"
                >
                    <article
                        v-for="experience in experiences"
                        :key="experience.id"
                        class="relative pb-16 pl-8 last:pb-0 sm:pl-12"
                    >
                        <!-- Timeline dot -->
                        <span
                            class="absolute -left-[5px] top-1 h-2.5 w-2.5 rounded-full bg-indigo-400 ring-8 ring-[#0d0e13]"
                        ></span>

                        <div class="grid gap-6 md:grid-cols-[180px_1fr]">
                            <!-- Date -->
                            <div>
                                <Small class="text-slate-500 font-sans">
                                    {{ formatMonthYear(experience.start_date) }}

                                    —

                                    <span v-if="experience.end_date">
                                        {{
                                            formatMonthYear(experience.end_date)
                                        }}
                                    </span>

                                    <span v-else class="text-indigo-400">
                                        Présent
                                    </span>
                                </Small>
                            </div>

                            <!-- Experience -->
                            <div>
                                <Title class="font-sans text-white" size="md">
                                    {{ experience.position }}
                                </Title>

                                <div class="mt-2">
                                    <Small class="text-indigo-400 font-sans">
                                        {{ experience.company }}
                                    </Small>
                                </div>

                                <div class="mt-5 max-w-2xl">
                                    <Body class="text-slate-400 font-sans">
                                        {{ experience.description }}
                                    </Body>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Empty state -->
                <div v-else>
                    <Body class="text-slate-500 *:font-sans">
                        Aucune expérience disponible pour le moment.
                    </Body>
                </div>

                <!-- ===================================================== -->
                <!-- SEE ALL -->
                <!-- ===================================================== -->

                <div
                    v-if="experiences?.length"
                    class="mt-14 flex justify-center"
                >
                    <Link
                        href="/game"
                        class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-[#191a1f] px-7 py-4 text-white transition hover:bg-[#24252b]"
                    >
                        <Small class="text-white"> Voir au complet </Small>

                        <span> → </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ========================================================= -->
        <!-- EDUCATION -->
        <!-- ========================================================= -->

        <section id="education" class="bg-[#00574b] px-6 py-32">
            <div class="mx-auto max-w-7xl">
                <!-- ===================================================== -->
                <!-- HEADING -->
                <!-- ===================================================== -->

                <div class="mb-16">
                    <Title class="font-sans text-white"> 03 — Education </Title>

                    <div class="mt-4">
                        <Heading class="font-sans text-indigo-400">
                            Formation
                        </Heading>
                    </div>
                </div>

                <!-- ===================================================== -->
                <!-- EDUCATION -->
                <!-- ===================================================== -->

                <div
                    v-if="education?.length"
                    class="divide-y divide-white/10 border-y border-white/10"
                >
                    <article
                        v-for="(item, index) in education"
                        :key="item.id"
                        class="grid gap-6 py-10 md:grid-cols-[100px_1fr_2fr] md:items-center"
                    >
                        <!-- Number -->
                        <Small class="font-mono text-slate-600">
                            {{ String(index + 1).padStart(2, "0") }}
                        </Small>

                        <!-- Formation -->
                        <div>
                            <Title size="md">
                                {{ item.degree }}
                            </Title>

                            <!-- Dates -->
                            <div class="mt-2">
                                <Small class="text-indigo-400">
                                    {{ formatMonthYear(item.start_date) }}

                                    —

                                    <span v-if="item.end_date">
                                        {{ formatMonthYear(item.end_date) }}
                                    </span>

                                    <span v-else> Présent </span>
                                </Small>
                            </div>

                            <!-- Institution -->
                            <div class="mt-2">
                                <Small class="font-sans text-white">
                                    {{ item.institution }}
                                </Small>
                            </div>
                        </div>

                        <!-- Description -->
                        <Body class="font-sans text-slate-400">
                            {{ item.description }}
                        </Body>
                    </article>
                </div>

                <!-- ===================================================== -->
                <!-- EMPTY STATE -->
                <!-- ===================================================== -->

                <div v-else>
                    <Body class="text-slate-500">
                        Aucune formation disponible pour le moment.
                    </Body>
                </div>

                <!-- ===================================================== -->
                <!-- SEE ALL -->
                <!-- ===================================================== -->

                <div v-if="education?.length" class="mt-14 flex justify-center">
                    <Link
                        href="/game"
                        class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-[#191a1f] px-7 py-4 text-white transition hover:bg-[#24252b]"
                    >
                        <Small class="text-white"> Voir au complet </Small>

                        <span> → </span>
                    </Link>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* =========================================================
   SPLASH
   ========================================================= */

.lottie-splash {
    width: 100%;
    height: 100%;
}

.lottie-splash :deep(svg) {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    overflow: visible !important;
}

/* =========================================================
   CODING MAN
   ========================================================= */

.lottie-coding {
    position: relative;
    width: 100%;
    height: 100%;
}

.lottie-coding :deep(svg) {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    overflow: visible !important;
}
</style>