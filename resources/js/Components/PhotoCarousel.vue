<script setup>
import { computed } from "vue";

// Charge automatiquement toutes les images du dossier resources/js/assets/images/
const imageModules = import.meta.glob("../assets/images/*.{png,jpg,jpeg,webp,svg}", {
    eager: true,
    import: "default",
});

const defaultImages = Object.values(imageModules);

const props = defineProps({
    images: {
        type: Array,
        default: null,
    },
});

// Utilisation de computed pour gérer la valeur par défaut de manière sûre
const carouselImages = computed(() => {
    return props.images && props.images.length > 0 ? props.images : defaultImages;
});
</script>

<template>
    <section class="relative h-44 w-full overflow-hidden border-y border-white/10 bg-[#08090d] sm:h-56 lg:h-64">
        <!-- Fondus progressifs sur les côtés -->
        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-[#08090d] to-transparent sm:w-36"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-[#08090d] to-transparent sm:w-36"></div>

        <!-- Rail de défilement infini -->
        <div v-if="carouselImages.length" class="carousel-track flex h-full w-max gap-0">
            <!-- Duplication x2 pour la boucle infinie -->
            <div v-for="loop in 2" :key="loop" class="flex h-full shrink-0 gap-0">
                <div
                    v-for="(img, index) in carouselImages"
                    :key="index"
                    class="group relative h-full w-56 shrink-0 overflow-hidden sm:w-72 lg:w-80"
                >
                    <!-- Image -->
                    <img
                        :src="img"
                        :alt="`Photo ${index + 1}`"
                        class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                    />

                    <!-- Overlay au survol -->
                    <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/80 via-black/20 to-transparent p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <span class="rounded-full border border-cyan-500/30 bg-slate-950/80 px-2.5 py-0.5 font-mono text-[11px] font-bold uppercase tracking-widest text-cyan-300">
                            Photo #0{{ index + 1 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.carousel-track {
    animation: scroll 35s linear infinite;
}

.carousel-track:hover {
    animation-play-state: paused;
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}
</style>
