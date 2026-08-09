<script setup>
import { computed, onMounted, ref } from "vue";

const props = defineProps({
    targetRoute: {
        type: String,
        default: "/",
    },
});

const emit = defineEmits(["finished"]);

const progress = ref(0);
const phase = ref("loading"); // 'loading' | 'ready'

// Districts de la ville cyber et leurs coordonnées (x, y) en % sur la carte
const districts = [
    { name: "ACCUEIL", route: "/", x: "15%", y: "20%", icon: "fa-solid fa-house" },
    { name: "ÉDUCATION", route: "/educations", x: "30%", y: "30%", icon: "fa-solid fa-graduation-cap" },
    { name: "EXPÉRIENCE", route: "/experiences", x: "55%", y: "20%", icon: "fa-solid fa-briefcase" },
    { name: "CERTIFICATIONS", route: "/certifications", x: "80%", y: "30%", icon: "fa-solid fa-certificate" },
    { name: "FORMATIONS", route: "/trainings", x: "85%", y: "60%", icon: "fa-solid fa-book-open" },
    { name: "PROJETS", route: "/projects", x: "65%", y: "75%", icon: "fa-solid fa-laptop-code" },
    { name: "COMPÉTENCES", route: "/skills", x: "40%", y: "80%", icon: "fa-solid fa-bolt" },
    { name: "SERVICES", route: "/services", x: "18%", y: "65%", icon: "fa-solid fa-laptop-code" },
    { name: "AWARDS", route: "/awards", x: "45%", y: "48%", icon: "fa-solid fa-trophy" },
];

// Détermine automatiquement le quartier cible en fonction de la route
const currentDistrict = computed(() => {
    const cleanRoute = props.targetRoute.split("?")[0].replace(/\/$/, "") || "/";
    const found = districts.find((d) => d.route === cleanRoute);
    return found || districts[0];
});

onMounted(() => {
    progress.value = 0;
    phase.value = "loading";

    // 100 étapes de 70ms = 7000ms (7 secondes pour la barre de progression)
    const interval = setInterval(() => {
        if (progress.value < 100) {
            progress.value += 1;
        } else {
            clearInterval(interval);
            phase.value = "ready";

            // 1000ms (1 seconde) supplémentaire pour l'écran "CITY READY" -> Total 8 secondes
            setTimeout(() => {
                emit("finished");
            }, 1000);
        }
    }, 70);
});
</script>

<template>
    <div class="fixed inset-0 z-[9999] bg-[#05060a] flex flex-col items-center justify-center font-sans select-none overflow-hidden text-white">
        <!-- BACKGROUND GRID & GLOW -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="absolute inset-0 opacity-20"
                style="
                    background-image:
                        linear-gradient(#22d3ee22 1px, transparent 1px),
                        linear-gradient(90deg, #22d3ee22 1px, transparent 1px);
                    background-size: 40px 40px;
                "
            ></div>
            <div
                class="absolute left-1/2 top-1/2 h-[600px] w-[600px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-500/10 blur-[120px]"
            ></div>
        </div>

        <!-- MAP CONTAINER -->
        <div class="relative w-[900px] h-[550px] max-w-[92vw] max-h-[65vh] perspective z-10">
            <div class="city-map relative w-full h-full rounded-3xl border border-cyan-400/30 bg-[#080d18] shadow-[0_0_80px_rgba(34,211,238,.25)] overflow-hidden">

                <!-- ROUTES FICTIVES -->
                <div class="absolute inset-0 opacity-30 pointer-events-none">
                    <div class="absolute top-[35%] left-0 w-full h-1.5 bg-cyan-500/40 border-y border-cyan-300/60"></div>
                    <div class="absolute top-[70%] left-0 w-full h-1.5 bg-cyan-500/40 border-y border-cyan-300/60"></div>
                    <div class="absolute left-[35%] top-0 w-1.5 h-full bg-cyan-500/40 border-x border-cyan-300/60"></div>
                    <div class="absolute left-[65%] top-0 w-1.5 h-full bg-cyan-500/40 border-x border-cyan-300/60"></div>
                </div>

                <!-- BÂTIMENTS DÉCORATIFS -->
                <div
                    v-for="i in 20"
                    :key="i"
                    class="absolute bg-slate-900/80 border border-cyan-400/20 rounded pointer-events-none"
                    :style="{
                        left: ((i * 37) % 85) + '%',
                        top: ((i * 53) % 80) + '%',
                        width: ((i % 3) + 2) * 12 + 'px',
                        height: ((i % 4) + 2) * 12 + 'px',
                    }"
                ></div>

                <!-- DISTRICTS DE LA VILLE -->
                <div
                    v-for="d in districts"
                    :key="d.name"
                    class="absolute transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center pointer-events-none transition-all duration-300"
                    :style="{ left: d.x, top: d.y }"
                >
                    <div
                        class="w-10 h-10 rounded-xl bg-slate-900/90 border border-cyan-500/40 flex items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.2)]"
                        :class="{ 'border-cyan-400 bg-cyan-950/80 shadow-[0_0_25px_#22d3ee] scale-110': currentDistrict.route === d.route }"
                    >
                        <i class="text-base" :class="[d.icon, currentDistrict.route === d.route ? 'text-cyan-300' : 'text-slate-400']"></i>
                    </div>
                    <p class="mt-1 text-[9px] font-black tracking-widest uppercase text-cyan-300/80 whitespace-nowrap bg-slate-950/80 px-2 py-0.5 rounded border border-cyan-500/20">
                        {{ d.name }}
                    </p>
                </div>

                <!-- MARQUEUR JOUEUR (ICÔNE LOCALISATION) -->
                <div
                    class="absolute z-30 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center pointer-events-none transition-all duration-1000 ease-in-out"
                    :style="{ left: currentDistrict.x, top: currentDistrict.y }"
                >
                    <div class="absolute -inset-3 bg-cyan-400/30 rounded-full animate-ping"></div>

                    <div class="relative w-12 h-12 bg-cyan-400 text-slate-950 rounded-full flex items-center justify-center shadow-[0_0_30px_#22d3ee] border-2 border-white animate-bounce">
                        <i class="fa-solid fa-location-dot text-2xl"></i>
                    </div>

                    <span class="mt-1 text-[10px] font-black tracking-widest text-slate-950 bg-cyan-400 px-2.5 py-0.5 rounded-full shadow-[0_0_12px_#22d3ee] uppercase whitespace-nowrap">
                        DESTINATION : {{ currentDistrict.name }}
                    </span>
                </div>
            </div>
        </div>

        <!-- HUD -->
        <div class="relative z-20 mt-8 w-full flex flex-col items-center">
            <h1 class="font-black text-3xl md:text-4xl tracking-[0.4em] uppercase text-white">
                FRANCK <span class="text-cyan-400 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]">CITY</span>
            </h1>

            <p class="text-[10px] md:text-xs uppercase tracking-[0.5em] text-cyan-300/70 my-4 font-mono">
                Déplacement vers le quartier {{ currentDistrict.name }}...
            </p>

            <div class="w-80 max-w-[85vw] h-3 bg-slate-900 border border-cyan-400/40 rounded-full overflow-hidden p-0.5 shadow-[inset_0_0_10px_#000]">
                <div
                    class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 rounded-full shadow-[0_0_20px_#22d3ee] transition-all duration-75"
                    :style="{ width: progress + '%' }"
                ></div>
            </div>

            <span class="mt-2 font-mono text-xs font-bold text-cyan-400 tracking-widest">
                {{ Math.floor(progress) }} %
            </span>
        </div>

        <!-- ECRAN READY / TRANSITION -->
        <Transition name="ready">
            <div
                v-if="phase === 'ready'"
                class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-xl flex flex-col items-center justify-center animate-in fade-in zoom-in duration-300"
            >
                <div class="w-20 h-20 bg-cyan-950 border-2 border-cyan-400 text-cyan-400 rounded-2xl flex items-center justify-center text-4xl mb-4 shadow-[0_0_30px_rgba(34,211,238,0.6)] animate-bounce">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <h1 class="text-4xl md:text-5xl font-black tracking-widest text-white">
                    CITY READY
                </h1>

                <p class="mt-3 font-mono text-cyan-300 tracking-widest text-xs uppercase">
                    ARRIVÉE À : {{ currentDistrict.name }}
                </p>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.perspective {
    perspective: 1000px;
}

.city-map {
    transform: rotateX(20deg);
    transform-origin: center center;
}

.ready-enter-active,
.ready-leave-active {
    transition: opacity 0.3s ease;
}

.ready-enter-from,
.ready-leave-to {
    opacity: 0;
}
</style>
