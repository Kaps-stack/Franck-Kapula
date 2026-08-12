<script setup>
import { Link } from "@inertiajs/vue3";
import { Motion } from "motion-v";
import lottie from "lottie-web";
import { computed, onMounted, onUnmounted, ref } from "vue";

import Layout from "@/Layouts/PortfolioLayout.vue";
import skillsAnimationData from "../../assets/animations/skills.json";

defineOptions({
    layout: Layout,
});

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

onMounted(() => {
    if (!animationSkills.value) return;

    skillsAnimation = lottie.loadAnimation({
        container: animationSkills.value,
        renderer: "svg",
        loop: true,
        autoplay: true,
        animationData: skillsAnimationData,
    });
});

onUnmounted(() => {
    if (skillsAnimation) {
        skillsAnimation.destroy();
        skillsAnimation = null;
    }
});

/*
|--------------------------------------------------------------------------
| COMPUTED
|--------------------------------------------------------------------------
*/

const featuredSkills = computed(() => {
    return props.skills.filter((skill) => skill.featured === true);
});

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

const viewport = { once: true, amount: 0.2 };
</script>

<template>
    <div class="min-h-screen pt-10 bg-[#08080a] text-slate-200">

        <!-- ========================================================= -->
        <!-- HERO COMPACT -->
        <!-- ========================================================= -->

        <section class="border-b border-white/10 py-8 sm:py-12">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-6 px-4 sm:px-6 md:flex-row">

                <!-- TEXTE -->
                <div class="max-w-xl text-center md:text-left">
                    <div class="mb-2 flex items-center justify-center gap-2 md:justify-start">
                        <span class="h-1.5 w-1.5 rounded-full bg-violet-400 shadow-[0_0_8px_#a78bfa]"></span>
                        <span class="font-mono text-xs font-semibold uppercase tracking-[0.25em] text-violet-400">
                            Stack Technique
                        </span>
                    </div>

                    <h1 class="font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Mes Compétences
                    </h1>

                    <p class="mt-2 font-sans text-xs leading-relaxed text-slate-400 sm:text-sm">
                        Les technologies et outils que j'utilise pour concevoir des applications web performantes.
                    </p>

                    <!-- METRICS -->
                    <div class="mt-4 flex items-center justify-center gap-6 font-mono text-xs text-slate-400 md:justify-start">
                        <div>
                            <span class="font-bold text-white">{{ skills.length }}</span>
                            <span class="ml-1 text-[11px] text-slate-500">skills</span>
                        </div>
                        <span class="h-3 w-px bg-white/10"></span>
                        <div>
                            <span class="font-bold text-white">{{ skillsByCategory.length }}</span>
                            <span class="ml-1 text-[11px] text-slate-500">catégories</span>
                        </div>
                    </div>
                </div>

                <!-- LOTTIE ANIMATION REDUITE -->
                <div class="flex h-32 w-32 shrink-0 items-center justify-center sm:h-40 sm:w-40">
                    <div ref="animationSkills" class="h-full w-full opacity-80"></div>
                </div>

            </div>
        </section>

        <!-- ========================================================= -->
        <!-- FOCUS (COMPACT BADGES / PILLS) -->
        <!-- ========================================================= -->

        <section v-if="featuredSkills.length" class="border-b border-white/10 py-8">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">

                <div class="mb-4 flex items-center gap-3">
                    <span class="font-mono text-xs text-violet-400">01.</span>
                    <h2 class="font-mono text-xs font-semibold uppercase tracking-[0.2em] text-white">
                        Focus Principal
                    </h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <!-- GRILLE DE BADGES ULTRA-COMPACTS -->
                <div class="flex flex-wrap gap-2.5">
                    <Motion
                        v-for="(skill, index) in featuredSkills"
                        :key="skill.id"
                        :initial="{ opacity: 0, y: 10 }"
                        :whileInView="{ opacity: 1, y: 0 }"
                        :viewport="viewport"
                        :transition="{ duration: 0.3, delay: index * 0.03 }"
                        class="group flex items-center gap-2.5 rounded-lg border border-white/10 bg-[#101116] px-3 py-2 transition-all hover:border-violet-400/50 hover:bg-[#161822]"
                    >
                        <!-- ICON -->
                        <div class="flex h-5 w-5 shrink-0 items-center justify-center">
                            <img
                                v-if="skill.icon"
                                :src="skill.icon"
                                :alt="skill.name"
                                class="h-4 w-4 object-contain opacity-80 group-hover:opacity-100"
                            />
                            <i v-else class="fa-solid fa-code text-xs text-violet-400"></i>
                        </div>

                        <!-- NAME -->
                        <span class="font-sans text-xs font-semibold text-white group-hover:text-violet-200">
                            {{ skill.name }}
                        </span>

                        <!-- LEVEL -->
                        <span v-if="skill.level !== null" class="font-mono text-[10px] text-slate-500">
                            {{ skill.level }}%
                        </span>

                        <span class="h-1 w-1 rounded-full bg-violet-400 shadow-[0_0_6px_#a78bfa]"></span>
                    </Motion>
                </div>

            </div>
        </section>

        <!-- ========================================================= -->
        <!-- TOUTES LES COMPÉTENCES (LISTE SOBRE & MINIMALE) -->
        <!-- ========================================================= -->

        <section v-if="skillsByCategory.length" class="py-8 sm:py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 space-y-8">

                <div class="flex items-center gap-3">
                    <span class="font-mono text-xs text-violet-400">02.</span>
                    <h2 class="font-mono text-xs font-semibold uppercase tracking-[0.2em] text-white">
                        Toutes les compétences
                    </h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        v-for="(group, groupIndex) in skillsByCategory"
                        :key="group.category"
                        class="rounded-xl border border-white/10 bg-[#101116] p-4"
                    >
                        <!-- TITRE CATEGORIE -->
                        <div class="mb-3 flex items-center justify-between border-b border-white/10 pb-2.5">
                            <h3 class="font-mono text-xs font-bold uppercase tracking-wider text-violet-300">
                                {{ group.category }}
                            </h3>
                            <span class="font-mono text-[10px] text-slate-500">
                                {{ group.skills.length }}
                            </span>
                        </div>

                        <!-- LISTE ULTRA FLUIDE DE COMPÉTENCES -->
                        <div class="divide-y divide-white/5">
                            <div
                                v-for="(skill, index) in group.skills"
                                :key="skill.id"
                                class="group flex items-center justify-between py-2.5 transition-colors hover:bg-white/[0.02]"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <img
                                        v-if="skill.icon"
                                        :src="skill.icon"
                                        :alt="skill.name"
                                        class="h-4 w-4 shrink-0 object-contain opacity-70 group-hover:opacity-100"
                                    />
                                    <i v-else class="fa-solid fa-code text-xs text-slate-500 group-hover:text-violet-400 shrink-0"></i>

                                    <span class="truncate font-sans text-xs font-medium text-slate-200 group-hover:text-white">
                                        {{ skill.name }}
                                    </span>
                                </div>

                                <!-- BARRE & POURCENTAGE -->
                                <div v-if="skill.level !== null" class="flex items-center gap-3 shrink-0">
                                    <div class="hidden w-20 sm:block">
                                        <div class="h-1 w-full overflow-hidden rounded-full bg-white/10">
                                            <div
                                                class="h-full bg-violet-400 shadow-[0_0_6px_#a78bfa]"
                                                :style="{ width: `${Math.min(Math.max(Number(skill.level) || 0, 0), 100)}%` }"
                                            ></div>
                                        </div>
                                    </div>
                                    <span class="w-8 text-right font-mono text-[11px] text-slate-400">
                                        {{ skill.level }}%
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================================= -->
        <!-- RETOUR -->
        <!-- ========================================================= -->

        <div class="mx-auto max-w-6xl px-4 pb-12 sm:px-6">
            <Link
                href="/"
                class="inline-flex items-center gap-2 font-mono text-xs text-slate-400 transition hover:text-white"
            >
                <span>←</span> Retour
            </Link>
        </div>

    </div>
</template>
