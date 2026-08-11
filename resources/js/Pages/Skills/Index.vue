<script setup>
import { Link } from "@inertiajs/vue3";
import { Motion } from "motion-v";
import lottie from "lottie-web";
import { computed, onMounted, onUnmounted, ref } from "vue";

import Layout from "@/Layouts/PortfolioLayout.vue";
import skillsAnimationData from "../../assets/animations/skills.json";

import Body from "@/Components/Typography/Body.vue";
import Heading from "@/Components/Typography/Heading.vue";
import Small from "@/Components/Typography/Small.vue";
import Title from "@/Components/Typography/Title.vue";

defineOptions({
    layout: Layout,
});

/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

const props = defineProps({
    skills: {
        type: Array,
        default: () => [],
    },
});

/*
|--------------------------------------------------------------------------
| LOTTIE
|--------------------------------------------------------------------------
*/

const animationSkills = ref(null);

let skillsAnimation = null;

/*
|--------------------------------------------------------------------------
| MOUNT
|--------------------------------------------------------------------------
*/

onMounted(() => {
    if (!animationSkills.value) {
        return;
    }

    skillsAnimation = lottie.loadAnimation({
        container: animationSkills.value,
        renderer: "svg",
        loop: true,
        autoplay: true,
        animationData: skillsAnimationData,
    });
});

/*
|--------------------------------------------------------------------------
| UNMOUNT
|--------------------------------------------------------------------------
*/

onUnmounted(() => {
    if (skillsAnimation) {
        skillsAnimation.destroy();
        skillsAnimation = null;
    }
});

/*
|--------------------------------------------------------------------------
| FEATURED SKILLS
|--------------------------------------------------------------------------
*/

const featuredSkills = computed(() => {
    return props.skills.filter((skill) => skill.featured === true);
});

/*
|--------------------------------------------------------------------------
| SKILLS GROUPED BY CATEGORY
|--------------------------------------------------------------------------
*/

const skillsByCategory = computed(() => {
    const groups = {};

    props.skills.forEach((skill) => {
        const category =
            skill.category && String(skill.category).trim() !== ""
                ? String(skill.category).trim()
                : "Autres";

        if (!groups[category]) {
            groups[category] = [];
        }

        groups[category].push(skill);
    });

    return Object.entries(groups).map(([category, skills]) => ({
        category,
        skills,
    }));
});

/*
|--------------------------------------------------------------------------
| LEVEL
|--------------------------------------------------------------------------
*/

const levelLabel = (level) => {
    if (level === null || level === undefined) {
        return null;
    }

    if (level >= 90) {
        return "Expert";
    }

    if (level >= 75) {
        return "Avancé";
    }

    if (level >= 50) {
        return "Intermédiaire";
    }

    return "Débutant";
});

/*
|--------------------------------------------------------------------------
| MOTION
|--------------------------------------------------------------------------
*/

const viewport = {
    once: true,
    amount: 0.15,
};

const reveal = {
    initial: {
        opacity: 0,
        y: 30,
    },

    visible: {
        opacity: 1,
        y: 0,
    },
};

const revealLeft = {
    initial: {
        opacity: 0,
        x: -25,
    },

    visible: {
        opacity: 1,
        x: 0,
    },
};

const revealScale = {
    initial: {
        opacity: 0,
        scale: 0.96,
    },

    visible: {
        opacity: 1,
        scale: 1,
    },
};

const motionTransition = {
    duration: 0.55,
    ease: "easeOut",
};
</script>

<template>
    <!-- ========================================================= -->
    <!-- HEADER / HERO -->
    <!-- ========================================================= -->

    <section class="mx-auto border border-white/10 bg-[#450057]">
        <div
            class="flex flex-col mt-10 items-center gap-10 px-4 py-8 sm:px-10 lg:flex-row lg:px-14 lg:py-16"
        >
            <!-- ================================================= -->
            <!-- TEXT -->
            <!-- ================================================= -->

            <Motion
                tag="div"
                class="w-full max-w-2xl lg:w-1/2"
                :initial="reveal.initial"
                :while-in-view="reveal.visible"
                :viewport="viewport"
                :transition="motionTransition"
            >
                <div class="mt-5">
                    <Heading class="font-sans text-3xl text-white sm:text-5xl">
                        Mes compétences
                    </Heading>
                </div>

                <div class="mt-6">
                    <Body class="font-sans leading-8 text-white/60">
                        Les technologies, outils et compétences que j'utilise
                        pour concevoir et développer des solutions numériques
                        modernes.
                    </Body>
                </div>
            </Motion>

            <!-- ================================================= -->
            <!-- LOTTIE -->
            <!-- ================================================= -->

            <Motion
                tag="div"
                class="flex w-full items-center justify-center lg:w-1/2"
                :initial="revealScale.initial"
                :while-in-view="revealScale.visible"
                :viewport="viewport"
                :transition="{
                    ...motionTransition,
                    duration: 0.7,
                }"
            >
                <div
                    ref="animationSkills"
                    class="h-64 w-64 sm:h-80 sm:w-80 lg:h-[24rem] lg:w-[24rem]"
                ></div>
            </Motion>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- FEATURED SKILLS -->
    <!-- ========================================================= -->

    <section
        v-if="featuredSkills.length"
        class="bg-[#003457] px-4 py-10 sm:px-7 sm:py-12"
    >
        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <Motion
            tag="div"
            class="mb-8 px-2 sm:mb-12 sm:px-6"
            :initial="reveal.initial"
            :while-in-view="reveal.visible"
            :viewport="viewport"
            :transition="motionTransition"
        >
            <Title class="font-sans text-white">
                Compétences principales
            </Title>

            <div class="mt-4">
                <Body class="font-sans max-w-2xl text-slate-400">
                    Les technologies que j'utilise le plus régulièrement dans
                    mes projets.
                </Body>
            </div>
        </Motion>

        <!-- ================================================= -->
        <!-- FEATURED SKILLS — FUTURISTIC DISPLAY -->
        <!-- ================================================= -->

        <div class="grid grid-cols-1 gap-3 px-2 sm:px-6 md:grid-cols-2 lg:grid-cols-3">
            <Motion
                v-for="(skill, index) in featuredSkills"
                :key="skill.id"
                tag="article"
                class="group relative min-w-0 overflow-hidden border border-white/10 bg-[#101116] px-4 py-4 transition duration-300 hover:border-indigo-400/30 sm:px-5"
                :initial="revealScale.initial"
                :while-in-view="revealScale.visible"
                :viewport="viewport"
                :transition="{
                    ...motionTransition,
                    delay: index * 0.07,
                }"
            >
                <!-- subtle futuristic line -->
                <div
                    class="absolute left-0 top-0 h-px w-0 bg-indigo-400 transition-all duration-500 group-hover:w-full"
                ></div>

                <div class="flex items-center gap-4">
                    <!-- INDEX -->

                    <Small
                        class="hidden shrink-0 font-mono text-indigo-400/50 sm:block"
                    >
                        {{ String(index + 1).padStart(2, "0") }}
                    </Small>

                    <!-- ICON -->

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center border border-white/10 bg-white/5"
                    >
                        <img
                            v-if="skill.icon"
                            :src="skill.icon"
                            :alt="skill.name"
                            class="h-6 w-6 object-contain"
                        />

                        <i
                            v-else
                            class="fa-solid fa-code text-indigo-400"
                        ></i>
                    </div>

                    <!-- NAME -->

                    <div class="min-w-0 flex-1">
                        <Small
                            size="md"
                            class="block break-words whitespace-normal font-sans leading-5 text-white"
                        >
                            {{ skill.name }}
                        </Small>

                        <Small
                            v-if="skill.category"
                            class="mt-0.5 block truncate font-sans text-indigo-400"
                        >
                            {{ skill.category }}
                        </Small>
                    </div>

                    <!-- LEVEL -->

                    <div
                        v-if="skill.level !== null"
                        class="shrink-0 text-right"
                    >
                        <Small
                            class="block font-mono text-xs text-slate-500"
                        >
                            {{ skill.level }}%
                        </Small>

                        <Small
                            class="block font-sans text-[10px] text-slate-600"
                        >
                            {{ levelLabel(skill.level) }}
                        </Small>
                    </div>
                </div>

                <!-- PROGRESS -->

                <div
                    v-if="skill.level !== null"
                    class="mt-3 h-px w-full overflow-hidden bg-white/5"
                >
                    <Motion
                        tag="div"
                        class="h-full bg-indigo-400"
                        :initial="{ width: '0%' }"
                        :while-in-view="{
                            width: `${Math.min(
                                Math.max(skill.level, 0),
                                100,
                            )}%`,
                        }"
                        :viewport="viewport"
                        :transition="{
                            duration: 0.9,
                            delay: index * 0.07 + 0.25,
                            ease: 'easeOut',
                        }"
                    />
                </div>
            </Motion>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- ALL SKILLS -->
    <!-- ========================================================= -->

    <section
        v-if="skillsByCategory.length"
        class="bg-[#00574b] px-4 py-10 sm:px-7 sm:py-12"
    >
        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <Motion
            tag="div"
            class="mb-10 px-2 sm:mb-16 sm:px-6"
            :initial="reveal.initial"
            :while-in-view="reveal.visible"
            :viewport="viewport"
            :transition="motionTransition"
        >
            <Title class="font-sans text-white">
                Toutes mes compétences
            </Title>

            <div class="mt-4">
                <Body class="font-sans max-w-2xl text-slate-400">
                    Retrouvez l'ensemble de mes compétences techniques et leur
                    niveau de maîtrise.
                </Body>
            </div>
        </Motion>

        <!-- ================================================= -->
        <!-- CATEGORIES -->
        <!-- ================================================= -->

        <div class="space-y-12 sm:space-y-16">
            <Motion
                v-for="(group, groupIndex) in skillsByCategory"
                :key="group.category"
                tag="div"
                :initial="reveal.initial"
                :while-in-view="reveal.visible"
                :viewport="viewport"
                :transition="{
                    ...motionTransition,
                    delay: groupIndex * 0.08,
                }"
            >
                <!-- ================================================= -->
                <!-- CATEGORY TITLE -->
                <!-- ================================================= -->

                <div class="mb-6 flex items-center gap-3 sm:mb-8 sm:gap-5">
                    <div class="h-px flex-1 bg-white/10"></div>

                    <Small
                        class="font-sans text-center text-xs uppercase tracking-[0.2em] text-indigo-400 sm:text-sm"
                    >
                        {{ group.category }}
                    </Small>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <!-- ================================================= -->
                <!-- FUTURISTIC SKILLS LIST -->
                <!-- ================================================= -->

                <div class="grid grid-cols-1 gap-2 px-2 sm:grid-cols-2 sm:px-6 lg:grid-cols-3">
                    <Motion
                        v-for="(skill, index) in group.skills"
                        :key="skill.id"
                        tag="article"
                        class="group relative min-w-0 overflow-hidden border border-white/10 bg-[#101116] transition duration-300 hover:border-white/20"
                        :initial="revealLeft.initial"
                        :while-in-view="revealLeft.visible"
                        :viewport="viewport"
                        :transition="{
                            ...motionTransition,
                            delay: index * 0.05,
                        }"
                    >
                        <!-- LEFT ACCENT -->

                        <div
                            class="absolute left-0 top-0 h-full w-px bg-indigo-400/0 transition duration-300 group-hover:bg-indigo-400/70"
                        ></div>

                        <div
                            class="flex min-h-[76px] items-center gap-3 px-4 py-3 sm:px-5"
                        >
                            <!-- NUMBER -->

                            <Small
                                class="w-6 shrink-0 font-mono text-xs text-slate-600"
                            >
                                {{ String(index + 1).padStart(2, "0") }}
                            </Small>

                            <!-- ICON -->

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center border border-white/10 bg-white/5"
                            >
                                <img
                                    v-if="skill.icon"
                                    :src="skill.icon"
                                    :alt="skill.name"
                                    class="h-6 w-6 object-contain"
                                />

                                <i
                                    v-else
                                    class="fa-solid fa-code text-sm text-indigo-400"
                                ></i>
                            </div>

                            <!-- CONTENT -->

                            <div class="min-w-0 flex-1">
                                <Title
                                    size="md"
                                    class="font-sans break-words whitespace-normal leading-tight text-white"
                                >
                                    {{ skill.name }}
                                </Title>

                                <div
                                    v-if="skill.level !== null"
                                    class="mt-1.5 flex items-center gap-2"
                                >
                                    <Small
                                        class="font-sans text-[10px] text-slate-600"
                                    >
                                        {{ levelLabel(skill.level) }}
                                    </Small>

                                    <div
                                        class="h-px flex-1 overflow-hidden bg-white/5"
                                    >
                                        <Motion
                                            tag="div"
                                            class="h-full bg-indigo-400"
                                            :initial="{ width: '0%' }"
                                            :while-in-view="{
                                                width: `${Math.min(
                                                    Math.max(skill.level, 0),
                                                    100,
                                                )}%`,
                                            }"
                                            :viewport="viewport"
                                            :transition="{
                                                duration: 0.8,
                                                delay:
                                                    index * 0.05 + 0.25,
                                                ease: 'easeOut',
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- PERCENTAGE -->

                            <Small
                                v-if="skill.level !== null"
                                class="shrink-0 font-mono text-xs text-slate-500"
                            >
                                {{ skill.level }}%
                            </Small>
                        </div>
                    </Motion>
                </div>
            </Motion>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- EMPTY -->
    <!-- ========================================================= -->

    <Motion
        v-if="!skills.length"
        tag="section"
        class="mx-4 my-8 rounded-3xl border border-dashed border-white/10 bg-[#101116] p-8 text-center sm:p-16"
        :initial="revealScale.initial"
        :while-in-view="revealScale.visible"
        :viewport="viewport"
        :transition="motionTransition"
    >
        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
        >
            <i class="fa-solid fa-code text-2xl text-slate-500"></i>
        </div>

        <div class="mt-6">
            <Title size="md" class="font-sans text-white">
                Aucune compétence disponible
            </Title>
        </div>

        <div class="mx-auto mt-3 max-w-md">
            <Body class="font-sans text-slate-500">
                Les compétences seront bientôt disponibles.
            </Body>
        </div>
    </Motion>

    <!-- ========================================================= -->
    <!-- BACK -->
    <!-- ========================================================= -->

    <Motion
        tag="div"
        class="mt-12 mb-10 px-4 sm:px-7"
        :initial="reveal.initial"
        :while-in-view="reveal.visible"
        :viewport="viewport"
        :transition="motionTransition"
    >
        <Link
            href="/"
            class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-6 py-3 font-sans text-sm text-white transition hover:bg-white hover:text-slate-900"
        >
            <span> ← </span>

            Retour à l'accueil
        </Link>
    </Motion>
</template>