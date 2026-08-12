<script setup>
defineProps({
    interests: {
        type: Array,
        default: () => [],
    },
    languages: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <section
        v-if="interests.length || languages.length"
        class="border-y border-white/10 bg-[#0b0c10] py-8 sm:py-10"
    >
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            <!-- ================================================= -->
            <!-- 01. CENTRES D'INTÉRÊT -->
            <!-- ================================================= -->

            <div v-if="interests.length">
                <!-- HEADER -->
                <div class="mb-4 flex items-center gap-3">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-400 shadow-[0_0_8px_#818cf8]"></span>
                    <h3 class="font-mono text-xs font-semibold uppercase tracking-[0.25em] text-indigo-400">
                        Centres d'intérêt
                    </h3>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <!-- CARROUSEL SUR MOBILE / GRILLE SUR DESKTOP -->
                <div class="no-scrollbar flex gap-4 overflow-x-auto py-2 lg:grid lg:grid-cols-4 lg:overflow-visible">
                    <div
                        v-for="interest in interests"
                        :key="interest.id"
                        class="carousel-item group relative h-40 w-48 shrink-0 overflow-hidden rounded-xl border border-white/10 bg-[#12131a] transition-all duration-300 hover:border-indigo-400/50 lg:h-44 lg:w-full lg:shrink"
                    >
                        <!-- IMAGE EN AVANT-PLAN -->
                        <img
                            v-if="interest.icon"
                            :src="interest.icon.startsWith('http') ? interest.icon : `/storage/${interest.icon}`"
                            :alt="interest.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />
                        <div v-else class="flex h-full w-full items-center justify-center bg-indigo-950/20">
                            <i class="fa-solid fa-star text-3xl text-indigo-400/40"></i>
                        </div>

                        <!-- OVERLAY SOMBRE + TITRE SUPERPOSÉ -->
                        <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-black/90 via-black/40 to-transparent p-3.5">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="truncate font-sans text-sm font-semibold text-white group-hover:text-indigo-300">
                                    {{ interest.name }}
                                </h4>
                                <span v-if="interest.featured" class="h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-400 shadow-[0_0_6px_#818cf8]"></span>
                            </div>
                            <p v-if="interest.description" class="line-clamp-1 mt-0.5 font-sans text-[11px] text-slate-400">
                                {{ interest.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- 02. LANGUES -->
            <!-- ================================================= -->

            <div v-if="languages.length">
                <!-- HEADER -->
                <div class="mb-4 flex items-center gap-3">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                    <h3 class="font-mono text-xs font-semibold uppercase tracking-[0.25em] text-emerald-400">
                        Langues
                    </h3>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <!-- CARROUSEL SUR MOBILE / GRILLE SUR DESKTOP -->
                <div class="no-scrollbar flex gap-4 overflow-x-auto py-2 lg:grid lg:grid-cols-4 lg:overflow-visible">
                    <div
                        v-for="language in languages"
                        :key="language.id"
                        class="carousel-item group min-w-[200px] shrink-0 rounded-xl border border-white/10 bg-[#12131a] p-3.5 transition-all duration-300 hover:border-emerald-400/50 lg:w-full lg:shrink"
                    >
                        <div class="flex items-center justify-between gap-3">
                            <span class="font-sans text-sm font-semibold text-white transition group-hover:text-emerald-300">
                                {{ language.name }}
                            </span>
                            <span class="font-mono text-xs text-slate-400">
                                {{ language.level }}
                            </span>
                        </div>

                        <!-- BARRE DE PROGRESSION SUBTILE -->
                        <div v-if="language.percentage !== null" class="mt-2.5">
                            <div class="h-1 w-full overflow-hidden rounded-full bg-white/10">
                                <div
                                    class="h-full bg-emerald-400 shadow-[0_0_6px_#34d399] transition-all duration-500"
                                    :style="{ width: `${Math.min(Math.max(Number(language.percentage) || 0, 0), 100)}%` }"
                                ></div>
                            </div>
                            <span class="mt-1 block text-right font-mono text-[10px] text-emerald-400/80">
                                {{ language.percentage }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<style scoped>
/* Masquer la barre de défilement tout en gardant le scroll tactile actif */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Auto-scroll uniquement sur les écrans inférieurs à lg (1024px) */
@media (max-width: 1023px) {
    @keyframes scrollAuto {
        0% {
            transform: translateX(0);
        }
        50% {
            transform: translateX(-30%);
        }
        100% {
            transform: translateX(0);
        }
    }

    .carousel-item {
        animation: scrollAuto 18s ease-in-out infinite;
    }

    /* Mettre en pause le défilement automatique au survol ou au toucher */
    .no-scrollbar:hover .carousel-item,
    .no-scrollbar:active .carousel-item {
        animation-play-state: paused;
    }
}
</style>
