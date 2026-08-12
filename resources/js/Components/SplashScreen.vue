<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = defineProps({
    targetRoute: {
        type: String,
        default: "/",
    },
});

const emit = defineEmits(["finished"]);

const progress = ref(0);
const phase = ref("loading");
const cameraZoom = ref(1);
const cameraX = ref(0);
const cameraY = ref(0);
const isApproaching = ref(false);

const districts = [
    {
        name: "ACCUEIL",
        route: "/",
        x: "15%",
        y: "20%",
        icon: "fa-solid fa-house",
    },
    {
        name: "ÉDUCATION",
        route: "/educations",
        x: "30%",
        y: "30%",
        icon: "fa-solid fa-graduation-cap",
    },
    {
        name: "EXPÉRIENCE",
        route: "/experiences",
        x: "55%",
        y: "20%",
        icon: "fa-solid fa-briefcase",
    },
    {
        name: "CERTIFICATIONS",
        route: "/certifications",
        x: "80%",
        y: "30%",
        icon: "fa-solid fa-certificate",
    },
    {
        name: "FORMATIONS",
        route: "/trainings",
        x: "85%",
        y: "60%",
        icon: "fa-solid fa-book-open",
    },
    {
        name: "PROJETS",
        route: "/projects",
        x: "65%",
        y: "75%",
        icon: "fa-solid fa-laptop-code",
    },
    {
        name: "COMPÉTENCES",
        route: "/skills",
        x: "40%",
        y: "80%",
        icon: "fa-solid fa-bolt",
    },
    {
        name: "SERVICES",
        route: "/services",
        x: "18%",
        y: "65%",
        icon: "fa-solid fa-laptop-code",
    },
    {
        name: "AWARDS",
        route: "/awards",
        x: "45%",
        y: "48%",
        icon: "fa-solid fa-trophy",
    },
    {
        name: "UNIVERS",
        route: "/game",
        x: "72%",
        y: "48%",
        icon: "fa-solid fa-gamepad",
    },
];

const currentDistrict = computed(() => {
    const rawPath = (props.targetRoute || "/").split("?")[0];
    const cleanRoute = rawPath === "/" ? "/" : rawPath.replace(/\/$/, "");

    return (
        districts.find((district) => {
            const districtCleanRoute =
                district.route === "/"
                    ? "/"
                    : district.route.replace(/\/$/, "");
            return districtCleanRoute === cleanRoute;
        }) || districts[0]
    );
});

/*
|--------------------------------------------------------------------------
| CAMERA
|--------------------------------------------------------------------------
*/

const getCameraTarget = () => {
    const x = parseFloat(currentDistrict.value.x);
    const y = parseFloat(currentDistrict.value.y);

    const isMobile = window.innerWidth < 640;
    // Zoom réduit sur mobile pour conserver tout le cadre
    const zoom = isMobile ? 1.65 : 2.35;

    const offsetX = 50 - x;
    const offsetY = 50 - y;

    // Limites strictes de translation pour ne pas pousser les quartiers extrêmes hors écran
    const maxTranslateX = isMobile ? 20 : 32;
    const maxTranslateY = isMobile ? 16 : 28;

    const translateX = Math.max(
        -maxTranslateX,
        Math.min(maxTranslateX, offsetX * (zoom - 1)),
    );

    const translateY = Math.max(
        -maxTranslateY,
        Math.min(maxTranslateY, offsetY * (zoom - 1)),
    );

    return {
        zoom,
        x: translateX,
        y: translateY,
    };
};

let progressInterval = null;
let readyTimeout = null;

onMounted(() => {
    progress.value = 0;
    phase.value = "loading";

    let elapsed = 0;

    progressInterval = setInterval(() => {
        elapsed += 40;

        if (elapsed <= 2000) {
            progress.value = Math.min(
                Math.floor((elapsed / 2000) * 66),
                66,
            );
            return;
        }

        if (elapsed <= 3000) {
            if (!isApproaching.value) {
                isApproaching.value = true;

                const target = getCameraTarget();
                cameraZoom.value = target.zoom;
                cameraX.value = target.x;
                cameraY.value = target.y;
            }

            const approachProgress = (elapsed - 2000) / 1000;
            progress.value = 66 + Math.floor(approachProgress * 34);
            return;
        }

        clearInterval(progressInterval);
        progressInterval = null;

        progress.value = 100;
        phase.value = "ready";

        readyTimeout = setTimeout(() => {
            emit("finished");
        }, 1000);
    }, 40);
});

onUnmounted(() => {
    if (progressInterval) clearInterval(progressInterval);
    if (readyTimeout) clearTimeout(readyTimeout);
});
</script>

<template>
    <div
        class="fixed inset-0 z-[9999] flex select-none flex-col items-center justify-center overflow-hidden bg-[#05060a] font-sans text-white px-2"
    >
        <!-- ===================================================== -->
        <!-- BACKGROUND -->
        <!-- ===================================================== -->

        <div class="pointer-events-none absolute inset-0">
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
                class="absolute left-1/2 top-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-500/10 blur-[100px] sm:h-[600px] sm:w-[600px] sm:blur-[120px]"
            ></div>
        </div>

        <!-- ===================================================== -->
        <!-- MAP / CAMERA -->
        <!-- ===================================================== -->

        <div
            class="perspective relative z-10 h-[500px] w-[900px] max-h-[55vh] max-w-[94vw] sm:max-h-[65vh]"
        >
            <div
                class="camera absolute inset-0"
                :class="{ 'camera-approach': isApproaching }"
                :style="{
                    transform: `
                        translate(
                            ${cameraX}%,
                            ${cameraY}%
                        )
                        scale(${cameraZoom})
                    `,
                }"
            >
                <!-- CITY MAP -->
                <div
                    class="city-map relative h-full w-full overflow-visible rounded-2xl border border-cyan-400/30 bg-[#080d18] shadow-[0_0_80px_rgba(34,211,238,.25)] sm:rounded-3xl"
                >
                    <!-- ROUTES -->
                    <div
                        class="pointer-events-none absolute inset-0 overflow-hidden rounded-2xl opacity-30 sm:rounded-3xl"
                    >
                        <div
                            class="absolute left-0 top-[35%] h-1.5 w-full border-y border-cyan-300/60 bg-cyan-500/40"
                        ></div>
                        <div
                            class="absolute left-0 top-[70%] h-1.5 w-full border-y border-cyan-300/60 bg-cyan-500/40"
                        ></div>
                        <div
                            class="absolute left-[35%] top-0 h-full w-1.5 border-x border-cyan-300/60 bg-cyan-500/40"
                        ></div>
                        <div
                            class="absolute left-[65%] top-0 h-full w-1.5 border-x border-cyan-300/60 bg-cyan-500/40"
                        ></div>
                    </div>

                    <!-- BÂTIMENTS -->
                    <div
                        v-for="i in 20"
                        :key="i"
                        class="pointer-events-none absolute rounded border border-cyan-400/20 bg-slate-900/80"
                        :style="{
                            left: ((i * 37) % 85) + '%',
                            top: ((i * 53) % 80) + '%',
                            width: ((i % 3) + 2) * 10 + 'px',
                            height: ((i % 4) + 2) * 10 + 'px',
                        }"
                    ></div>

                    <!-- DISTRICTS -->
                    <div
                        v-for="d in districts"
                        :key="d.name"
                        class="pointer-events-none absolute flex -translate-x-1/2 -translate-y-1/2 transform flex-col items-center"
                        :style="{
                            left: d.x,
                            top: d.y,
                        }"
                    >
                        <!-- GLOW -->
                        <div
                            v-if="currentDistrict.route === d.route"
                            class="absolute h-20 w-20 rounded-full bg-cyan-400/20 blur-xl sm:h-28 sm:w-28 sm:blur-2xl"
                        ></div>

                        <!-- ICON -->
                        <div
                            class="relative flex h-8 w-8 items-center justify-center rounded-lg border border-cyan-500/40 bg-slate-900/90 shadow-[0_0_15px_rgba(34,211,238,0.2)] sm:h-10 sm:w-10 sm:rounded-xl"
                            :class="{
                                'border-cyan-400 bg-cyan-950/80 shadow-[0_0_30px_#22d3ee]':
                                    currentDistrict.route === d.route,
                            }"
                        >
                            <i
                                class="text-xs sm:text-base"
                                :class="[
                                    d.icon,
                                    currentDistrict.route === d.route
                                        ? 'text-cyan-300'
                                        : 'text-slate-400',
                                ]"
                            ></i>
                        </div>

                        <!-- DISTRICT NAME -->
                        <p
                            class="mt-1 whitespace-nowrap rounded border border-cyan-500/20 bg-slate-950/90 px-1.5 py-0.5 text-[8px] font-black uppercase tracking-wider text-cyan-300/80 sm:px-2 sm:text-[9px] sm:tracking-widest"
                        >
                            {{ d.name }}
                        </p>
                    </div>

                    <!-- PLAYER MARKER -->
                    <div
                        class="pointer-events-none absolute z-30 flex -translate-x-1/2 -translate-y-1/2 transform flex-col items-center"
                        :style="{
                            left: currentDistrict.x,
                            top: currentDistrict.y,
                        }"
                    >
                        <!-- PING -->
                        <div
                            class="absolute -inset-2 animate-ping rounded-full bg-cyan-400/30 sm:-inset-3"
                        ></div>

                        <!-- LOCATION PIN -->
                        <div
                            class="relative flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-cyan-400 text-slate-950 shadow-[0_0_25px_#22d3ee] animate-bounce sm:h-12 sm:w-12 sm:shadow-[0_0_30px_#22d3ee]"
                        >
                            <i
                                class="fa-solid fa-location-dot text-lg sm:text-2xl"
                            ></i>
                        </div>

                        <!-- DESTINATION BADGE (RESPONSIVE TEXT & WRAP) -->
                        <span
                            class="mt-1 max-w-[130px] whitespace-normal rounded-full bg-cyan-400 px-2 py-0.5 text-center text-[8px] font-black uppercase leading-tight tracking-tight text-slate-950 shadow-[0_0_12px_#22d3ee] xs:max-w-[160px] xs:text-[9px] sm:max-w-none sm:whitespace-nowrap sm:px-2.5 sm:text-[10px] sm:tracking-widest"
                        >
                            DESTINATION : {{ currentDistrict.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================================================== -->
        <!-- HUD -->
        <!-- ===================================================== -->

        <div
            class="relative z-20 mt-4 flex w-full flex-col items-center px-4 sm:mt-8"
        >
            <h1
                class="text-center text-xl font-black uppercase tracking-[0.2em] text-white sm:text-3xl sm:tracking-[0.4em] md:text-4xl"
            >
                FRANCK
                <span
                    class="text-cyan-400 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]"
                >
                    CITY
                </span>
            </h1>

            <p
                class="my-2 max-w-[90vw] text-center text-[9px] font-mono uppercase tracking-[0.2em] text-cyan-300/70 sm:my-4 sm:text-[10px] sm:tracking-[0.5em] md:text-xs"
            >
                Déplacement vers le quartier {{ currentDistrict.name }}...
            </p>

            <!-- PROGRESS BAR -->
            <div
                class="h-2.5 w-64 max-w-[80vw] overflow-hidden rounded-full border border-cyan-400/40 bg-slate-900 p-0.5 shadow-[inset_0_0_10px_#000] sm:h-3 sm:w-80"
            >
                <div
                    class="h-full rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 shadow-[0_0_20px_#22d3ee] transition-all duration-75"
                    :style="{
                        width: progress + '%',
                    }"
                ></div>
            </div>

            <span
                class="mt-1.5 font-mono text-[10px] font-bold tracking-widest text-cyan-400 sm:mt-2 sm:text-xs"
            >
                {{ progress }} %
            </span>
        </div>

        <!-- ===================================================== -->
        <!-- CITY READY OVERLAY -->
        <!-- ===================================================== -->

        <Transition name="ready">
            <div
                v-if="phase === 'ready'"
                class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950/90 px-4 text-center backdrop-blur-xl"
            >
                <div
                    class="mb-3 flex h-16 w-16 items-center justify-center rounded-2xl border-2 border-cyan-400 bg-cyan-950 text-3xl text-cyan-400 shadow-[0_0_30px_rgba(34,211,238,0.6)] animate-bounce sm:mb-4 sm:h-20 sm:w-20 sm:text-4xl"
                >
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <h1
                    class="text-2xl font-black tracking-[0.15em] text-white sm:text-4xl md:text-5xl md:tracking-widest"
                >
                    CITY READY
                </h1>

                <p
                    class="mt-2 max-w-[90vw] font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300 sm:mt-3 sm:text-xs sm:tracking-widest"
                >
                    ARRIVÉE À : {{ currentDistrict.name }}
                </p>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.perspective {
    perspective: 1200px;
}

.city-map {
    transform: rotateX(20deg);
    transform-origin: center center;
    transform-style: preserve-3d;
}

.camera {
    transform-origin: center center;
    transform-style: preserve-3d;
    will-change: transform;
}

.camera-approach {
    transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.ready-enter-active,
.ready-leave-active {
    transition:
        opacity 0.35s ease,
        transform 0.35s ease;
}

.ready-enter-from,
.ready-leave-to {
    opacity: 0;
    transform: scale(1.04);
}

/*
|--------------------------------------------------------------------------
| MOBILE MEDIA QUERIES
|--------------------------------------------------------------------------
*/

@media (max-width: 639px) {
    .perspective {
        width: 94vw;
        height: min(44vh, 340px);
        max-height: 340px;
    }

    .city-map {
        transform: rotateX(15deg);
    }
}

@media (max-height: 650px) and (max-width: 639px) {
    .perspective {
        height: 38vh;
        max-height: 280px;
    }

    .city-map {
        transform: rotateX(12deg);
    }
}
</style>
