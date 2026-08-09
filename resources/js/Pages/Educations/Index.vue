<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";
import { Link } from "@inertiajs/vue3";
// Version 'light' de Lottie pour éviter l'erreur CSP
import lottie from "lottie-web/build/player/lottie_light";

import Layout from "@/Layouts/PortfolioLayout.vue";

import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

import touchAnimation from "@/assets/animations/touch.json";

defineOptions({
    layout: Layout,
});

/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

defineProps({
    educations: {
        type: Array,
        default: () => [],
    },
});

/*
|--------------------------------------------------------------------------
| CARDS (FLIP LOGIC)
|--------------------------------------------------------------------------
*/

const flippedCards = ref(new Set());

const toggleCard = (id) => {
    const newSet = new Set(flippedCards.value);
    if (newSet.has(id)) {
        newSet.delete(id);
    } else {
        newSet.add(id);
    }
    flippedCards.value = newSet;
};

const isFlipped = (id) => {
    return flippedCards.value.has(id);
};

/*
|--------------------------------------------------------------------------
| MULTIPLE TOUCH ANIMATIONS (LOTTIE)
|--------------------------------------------------------------------------
*/

const animationRefs = ref([]);
let lottieInstances = [];

onMounted(async () => {
    await nextTick();

    animationRefs.value.forEach((container) => {
        if (container) {
            const instance = lottie.loadAnimation({
                container: container,
                renderer: "svg",
                loop: true,
                autoplay: true,
                animationData: touchAnimation,
            });
            lottieInstances.push(instance);
        }
    });
});

onBeforeUnmount(() => {
    lottieInstances.forEach((instance) => instance.destroy());
    lottieInstances = [];
});

/*
|--------------------------------------------------------------------------
| FORMAT DATE & PERIOD
|--------------------------------------------------------------------------
*/

const formatDate = (date) => {
    if (!date) return null;
    const value = new Date(date);
    if (Number.isNaN(value.getTime())) return null;

    return new Intl.DateTimeFormat("fr-FR", {
        month: "2-digit",
        year: "numeric",
    }).format(value);
};

const formatPeriod = (education) => {
    const start = formatDate(education.start_date);
    const end = education.current || !education.end_date
            ? "Présent"
            : formatDate(education.end_date);

    if (!start) return end;
    return `${start} — ${end}`;
};
</script>

<template>
    <div class="min-h-screen bg-[#00574b] px-5 pb-32 pt-32 text-white sm:px-8 lg:px-12">
        <div class="mx-auto max-w-7xl">

            <!-- ================================================= -->
            <!-- HEADER -->
            <!-- ================================================= -->

            <div class="mb-16 max-w-3xl sm:mb-20">
                

                <div class="mt-5">
                    <Heading class="font-sans text-4xl text-white sm:text-5xl">
                        Mon parcours académique
                    </Heading>
                </div>

                <div class="mt-6">
                    <Body class="font-sans leading-8 text-white/60">
                        Cliquez sur les cartes pour percer le mystère et découvrir
                        les différentes formations qui ont construit mon parcours.
                    </Body>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- EDUCATION GRID -->
            <!-- ================================================= -->

            <div v-if="educations.length" class="grid gap-8 md:grid-cols-2">

                <!-- ================================================= -->
                <!-- CARD -->
                <!-- ================================================= -->

                <article
                    v-for="(education, index) in educations"
                    :key="education.id"
                    class="group h-[430px] cursor-pointer [perspective:1200px]"
                    @click="toggleCard(education.id)"
                >
                    <!-- CARD INNER -->
                    <div
                        class="relative h-full w-full transition-transform duration-700 [transform-style:preserve-3d]"
                        :class="{ '[transform:rotateY(180deg)]': isFlipped(education.id) }"
                    >
                        
                        <!-- ================================================= -->
                        <!-- FRONT (MYSTÉRIEUX - JUSTE L'ANIMATION) -->
                        <!-- ================================================= -->

                        <div class="absolute inset-0 flex h-full w-full flex-col items-center justify-center overflow-hidden rounded-[2rem] border border-white/5 bg-[#101116] shadow-[0_25px_60px_rgba(0,0,0,0.25)] transition-colors duration-300 hover:border-indigo-500/30 hover:bg-[#14151a] [backface-visibility:hidden]">
                            
                            <div ref="animationRefs" class="h-28 w-28 opacity-80 transition-opacity duration-300 group-hover:opacity-100"></div>
                            
                            <Small class="mt-6 font-sans text-white/30 uppercase tracking-[0.3em] transition-colors duration-300 group-hover:text-indigo-400/70">
                                Découvrir
                            </Small>

                        </div>

                        <!-- ================================================= -->
                        <!-- BACK (TOUTES LES INFOS) -->
                        <!-- ================================================= -->

                        <div class="absolute inset-0 flex h-full w-full flex-col overflow-hidden rounded-[2rem] border border-indigo-500/30 bg-[#101116] p-7 shadow-[0_25px_60px_rgba(0,0,0,0.35)] [backface-visibility:hidden] [transform:rotateY(180deg)] sm:p-9">
                            
                            <!-- TOP : NUMÉRO ET DATE (start_date, end_date, current) -->
                            <div class="flex items-center justify-between shrink-0">
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 font-sans text-[10px] uppercase tracking-[0.2em] text-slate-400">
                                     {{ String(index + 1).padStart(2, "0") }}
                                </span>
                                <Small class="font-sans text-indigo-400 font-medium">
                                    {{ formatPeriod(education) }}
                                </Small>
                            </div>

                            <!-- CONTENT MIDDLE -->
                            <div class="mt-6 flex flex-col h-full overflow-hidden">
                                
                                <!-- TITRES (degree, institution, institution_url, field) -->
                                <div class="shrink-0">
                                    <Title class="font-sans text-2xl leading-tight text-white sm:text-3xl">
                                        {{ education.degree }}
                                    </Title>
                                    
                                    <!-- Institution + Bouton URL externe -->
                                    <div class="mt-2 flex items-center gap-3">
                                        <Small class="font-sans text-white/70">
                                            {{ education.institution }}
                                        </Small>
                                        
                                        <!-- Affiché uniquement si institution_url existe. @click.stop évite de retourner la carte -->
                                        <a
                                            v-if="education.institution_url"
                                            :href="education.institution_url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="Visiter le site de l'établissement"
                                            class="flex h-7 w-7 items-center justify-center rounded-full bg-white/10 text-indigo-400 transition-colors hover:bg-indigo-500 hover:text-white"
                                            @click.stop 
                                        >
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Field (Domaine d'études) -->
                                    <div v-if="education.field" class="mt-3 inline-flex items-center rounded-lg border border-indigo-500/20 bg-indigo-500/10 px-3 py-1.5">
                                        <Small class="font-sans text-indigo-300">
                                            {{ education.field }}
                                        </Small>
                                    </div>
                                </div>

                                <!-- DESCRIPTION SCROLLABLE (description) -->
                                <div v-if="education.description" class="mt-5 flex-1 overflow-y-auto pr-3 custom-scrollbar">
                                    <Body class="font-sans text-sm leading-6 text-slate-400">
                                        {{ education.description }}
                                    </Body>
                                </div>
                            </div>

                            <!-- BOTTOM : LOCATION ET ICONE (location) -->
                            <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-5 shrink-0">
                                <div class="flex items-center gap-2">
                                    <i v-if="education.location" class="fa-solid fa-location-dot text-xs text-indigo-400"></i>
                                    <Small class="font-sans text-slate-500">
                                        {{ education.location || "Non spécifié" }}
                                    </Small>
                                </div>
                                <div class="flex items-center gap-2 text-indigo-400/70 transition-colors hover:text-indigo-400">
                                    <Small class="font-sans">Fermer</Small>
                                    <span class="text-sm">↻</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </article>

            </div>

            <!-- ================================================= -->
            <!-- EMPTY STATE -->
            <!-- ================================================= -->

            <div v-else class="rounded-[2rem] border border-dashed border-white/10 bg-[#101116] p-16 text-center">
                <Body class="font-sans text-slate-500">
                    Aucune formation disponible pour le moment.
                </Body>
            </div>

            <!-- ================================================= -->
            <!-- BACK BUTTON -->
            <!-- ================================================= -->

            <div class="mt-16">
                <Link
                    href="/"
                    class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-6 py-3 font-sans text-sm text-white transition duration-300 hover:bg-white hover:text-slate-900"
                >
                    <span>←</span>
                    Retour à l'accueil
                </Link>
            </div>

        </div>
    </div>
</template>

<style scoped>
/* Scrollbar personnalisée pour la face arrière (description) */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background-color: rgba(99, 102, 241, 0.5); /* indigo-400 transparent */
}
</style>