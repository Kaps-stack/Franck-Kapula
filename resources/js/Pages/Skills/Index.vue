<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import lottie from "lottie-web";

import Layout from "@/Layouts/PortfolioLayout.vue";
import skillsAnimationData from "../../assets/animations/skills.json";

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
    return props.skills.filter(
        (skill) => skill.featured === true
    );
});


/*
|--------------------------------------------------------------------------
| SKILLS GROUPED BY CATEGORY
|--------------------------------------------------------------------------
|
| Exemple :
|
| Backend
| ├── PHP
| ├── Python
| └── Laravel
|
| Frontend
| ├── Vue.js
| ├── JavaScript
| └── React
|
|--------------------------------------------------------------------------
*/

const skillsByCategory = computed(() => {
    const groups = {};

    props.skills.forEach((skill) => {
        const category =
            skill.category &&
            String(skill.category).trim() !== ""
                ? String(skill.category).trim()
                : "Autres";

        if (!groups[category]) {
            groups[category] = [];
        }

        groups[category].push(skill);
    });

    return Object.entries(groups).map(
        ([category, skills]) => ({
            category,
            skills,
        })
    );
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
};
</script>


<template>

    <!-- ========================================================= -->
    <!-- HEADER / HERO -->
    <!-- ========================================================= -->

    <section
        class=" mx-auto  border border-white/10 bg-[#450057]"
    >

        <div
            class="flex flex-col mt-10  items-center gap-10 px-7 py-12 sm:px-10 lg:flex-row lg:px-14 lg:py-16"
        >

            <!-- ================================================= -->
            <!-- TEXT -->
            <!-- ================================================= -->

            <div
                class="w-full max-w-2xl lg:w-1/2 "
            >


                <div class="mt-5">

                    <Heading
                        class="font-sans text-4xl text-white sm:text-5xl"
                    >
                        Mes compétences
                    </Heading>

                </div>


                <div class="mt-6">

                    <Body
                        class="font-sans leading-8 text-white/60"
                    >
                        Les technologies, outils et compétences que
                        j'utilise pour concevoir et développer des
                        solutions numériques modernes.
                    </Body>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- LOTTIE -->
            <!-- ================================================= -->

            <div
                class="flex w-full items-center justify-center lg:w-1/2"
            >

                <div
                    ref="animationSkills"
                    class="h-64 w-64 sm:h-80 sm:w-80 lg:h-[24rem] lg:w-[24rem]"
                ></div>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- FEATURED SKILLS -->
    <!-- ========================================================= -->

    <section
        v-if="featuredSkills.length"
        class=" bg-[#00574b] px-7 py-12"
    >

        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <div class="mb-12 px-6">

            <Title
                class="font-sans text-white"
            >
                Compétences principales
            </Title>


            <div class="mt-4">

                <Body
                    class="font-sans max-w-2xl text-slate-400"
                >
                    Les technologies que j'utilise le plus
                    régulièrement dans mes projets.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- FEATURED GRID -->
        <!-- ================================================= -->

        <div
            class="grid grid-cols-2 gap-6 px-6 md:grid-cols-3 lg:grid-cols-4"
        >

            <article
                v-for="skill in featuredSkills"
                :key="skill.id"
                class="group rounded-3xl border border-white/10 bg-[#101116] p-6 transition duration-300 hover:border-indigo-400/30"
            >

                <!-- ================================================= -->
                <!-- TOP -->
                <!-- ================================================= -->

                <div
                    class="flex items-center justify-between gap-4"
                >

                    <!-- ICON -->

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/5"
                    >

                        <img
                            v-if="skill.icon"
                            :src="skill.icon"
                            :alt="skill.name"
                            class="h-8 w-8 object-contain"
                        />

                        <i
                            v-else
                            class="fa-solid fa-code text-xl text-indigo-400"
                        ></i>

                    </div>


                    <!-- LEVEL -->

                    <Small
                        v-if="skill.level !== null"
                        class="font-sans text-slate-500"
                    >
                        {{ levelLabel(skill.level) }}
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
                        {{ skill.name }}
                    </Title>

                </div>


                <!-- ================================================= -->
                <!-- CATEGORY -->
                <!-- ================================================= -->

                <div
                    v-if="skill.category"
                    class="mt-2"
                >

                    <Small
                        class="font-sans text-indigo-400"
                    >
                        {{ skill.category }}
                    </Small>

                </div>


                <!-- ================================================= -->
                <!-- LEVEL BAR -->
                <!-- ================================================= -->

                <div
                    v-if="skill.level !== null"
                    class="mt-6"
                >

                    <div
                        class="h-1.5 overflow-hidden rounded-full bg-white/5"
                    >

                        <div
                            class="h-full rounded-full bg-indigo-400 transition-all duration-700"
                            :style="{
                                width: `${Math.min(
                                    Math.max(skill.level, 0),
                                    100
                                )}%`,
                            }"
                        ></div>

                    </div>


                    <div class="mt-2 flex justify-between">

                        <Small
                            class="font-sans text-slate-600"
                        >
                            Niveau
                        </Small>

                        <Small
                            class="font-sans text-slate-500"
                        >
                            {{ skill.level }}%
                        </Small>

                    </div>

                </div>

            </article>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- ALL SKILLS -->
    <!-- ========================================================= -->

    <section
        v-if="skillsByCategory.length"
        class="bg-[#450057] px-7 py-12"
    >

        <!-- ================================================= -->
        <!-- HEADING -->
        <!-- ================================================= -->

        <div class="mb-16 px-6">

            <Title
                class="font-sans text-white"
            >
                Toutes mes compétences
            </Title>


            <div class="mt-4 px-6">

                <Body
                    class="font-sans max-w-2xl text-slate-400"
                >
                    Retrouvez l'ensemble de mes compétences
                    techniques et leur niveau de maîtrise.
                </Body>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- CATEGORIES -->
        <!-- ================================================= -->

        <div class="space-y-16">

            <!-- ================================================= -->
            <!-- CATEGORY GROUP -->
            <!-- ================================================= -->

            <div
                v-for="group in skillsByCategory"
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
                        class="font-sans uppercase tracking-[0.2em] text-indigo-400"
                    >
                        {{ group.category }}
                    </Small>


                    <div
                        class="h-px flex-1 bg-white/10"
                    ></div>

                </div>


                <!-- ================================================= -->
                <!-- SKILLS GRID -->
                <!-- ================================================= -->

                <div
                    class="grid grid-cols-2 gap-6 px-6 md:grid-cols-3 lg:grid-cols-4"
                >

                    <article
                        v-for="skill in group.skills"
                        :key="skill.id"
                        class="group rounded-2xl border border-white/10 bg-[#101116] p-6 transition duration-300 hover:border-white/20"
                    >

                        <!-- ================================================= -->
                        <!-- TOP -->
                        <!-- ================================================= -->

                        <div
                            class="flex items-center gap-4"
                        >

                            <!-- ICON -->

                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/5"
                            >

                                <img
                                    v-if="skill.icon"
                                    :src="skill.icon"
                                    :alt="skill.name"
                                    class="h-7 w-7 object-contain"
                                />

                                <i
                                    v-else
                                    class="fa-solid fa-code text-indigo-400"
                                ></i>

                            </div>


                            <!-- NAME -->

                            <div
                                class="min-w-0"
                            >

                                <Title
                                    size="md"
                                    class="truncate font-sans text-white"
                                >
                                    {{ skill.name }}
                                </Title>

                            </div>

                        </div>


                        <!-- ================================================= -->
                        <!-- LEVEL -->
                        <!-- ================================================= -->

                        <div
                            v-if="skill.level !== null"
                            class="mt-6"
                        >

                            <div
                                class="flex items-center justify-between"
                            >

                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    {{ levelLabel(skill.level) }}
                                </Small>


                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    {{ skill.level }}%
                                </Small>

                            </div>


                            <div
                                class="mt-3 h-1 overflow-hidden rounded-full bg-white/5"
                            >

                                <div
                                    class="h-full rounded-full bg-indigo-400"
                                    :style="{
                                        width: `${Math.min(
                                            Math.max(skill.level, 0),
                                            100
                                        )}%`,
                                    }"
                                ></div>

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
        v-if="!skills.length"
        class="rounded-3xl border border-dashed border-white/10 bg-[#101116] p-16 text-center"
    >

        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
        >

            <i
                class="fa-solid fa-code text-2xl text-slate-500"
            ></i>

        </div>


        <div class="mt-6">

            <Title
                size="md"
                class="font-sans text-white"
            >
                Aucune compétence disponible
            </Title>

        </div>


        <div class="mx-auto mt-3 max-w-md">

            <Body
                class="font-sans text-slate-500"
            >
                Les compétences seront bientôt disponibles.
            </Body>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- BACK -->
    <!-- ========================================================= -->

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

</template>