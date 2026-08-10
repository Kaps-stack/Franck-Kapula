<script setup>
import { computed, onMounted, onUnmounted, reactive, ref } from "vue";
// Remonte de Pages/ (..) vers js/ puis rentre dans assets/audio/
import bgMusicUrl from "@/assets/audio/son.mp3";
// --- DONNÉES DU PORTFOLIO (Les stations dans le monde 3D) ---
const portfolioStations = [
    {
        id: 1,
        x: 1800,
        title: "ÉDUCATION",
        route: "/educations",
        icon: "fa-solid fa-graduation-cap",
        subtitle: "Diplômes & Certificats",
        desc: "Mon cursus académique, mes formations et mes apprentissages.",
    },
    {
        id: 2,
        x: 2800,
        title: "EXPÉRIENCE",
        route: "/experiences",
        icon: "fa-solid fa-briefcase",
        subtitle: "Parcours Professionnel",
        desc: "Mon parcours professionnel et mes réalisations.",
    },
    {
        id: 3,
        x: 3800,
        title: "CERTIFICATIONS",
        route: "/certifications",
        icon: "fa-solid fa-certificate",
        subtitle: "Certifications",
        desc: "Mes certificats et qualifications professionnelles.",
    },
    {
        id: 4,
        x: 4800,
        title: "AUTRES FORMATIONS",
        route: "/trainings",
        icon: "fa-solid fa-book-open",
        subtitle: "Formations",
        desc: "Mes formations complémentaires et mes apprentissages.",
    },
    {
        id: 5,
        x: 5800,
        title: "PROJETS",
        route: "/projects",
        icon: "fa-solid fa-laptop-code",
        subtitle: "Réalisations",
        desc: "Explore mes applications web, mes codes sources et mes études de cas.",
    },
    {
        id: 6,
        x: 6800,
        title: "COMPÉTENCES",
        route: "/skills",
        icon: "fa-solid fa-bolt",
        subtitle: "Stack Technique",
        desc: "Les langages, frameworks et outils que je maîtrise au quotidien.",
    },
    {
        id: 7,
        x: 7800,
        title: "SERVICES",
        route: "/services",
        icon: "fa-solid fa-laptop-code",
        subtitle: "Services",
        desc: "Les services que je propose pour concevoir et développer des solutions numériques.",
    },
    {
        id: 8,
        x: 8800,
        title: "AWARDS",
        route: "/awards",
        icon: "fa-solid fa-trophy",
        subtitle: "Prix & Distinctions",
        desc: "Mes récompenses, distinctions et réalisations remarquables.",
    },
];

const worldWidth = 9600; // Longueur totale du monde 3D

// --- TROUS DANS LE SOL (Obstacles) ---
const holes = ref([
    { id: 1, x: 2300, width: 80 },
    { id: 2, x: 4300, width: 80 },
    { id: 3, x: 6300, width: 80 },
    { id: 4, x: 8300, width: 80 },
]);

// --- PIÈCES (COINS) DANS LE MONDE ---
const coins = ref([]);
const score = ref(0);

const generateCoins = () => {
    const newCoins = [];
    let coinId = 1;
    // Génération de pièces régulièrement réparties le long du monde
    for (let x = 400; x < worldWidth - 400; x += 250) {
        // Vérifier qu'on n'est pas au-dessus d'un trou
        const isOverHole = holes.value.some(
            (h) => x >= h.x - 40 && x <= h.x + h.width + 40,
        );
        if (!isOverHole) {
            // Hauteur aléatoire : au sol (0) ou en hauteur (saut nécessaire, ex: -60 à -110)
            const isHigh = Math.random() > 0.4;
            const y = isHigh ? -(50 + Math.floor(Math.random() * 60)) : 0;
            newCoins.push({
                id: coinId++,
                x: x,
                y: y,
                collected: false,
            });
        }
    }
    coins.value = newCoins;
};

// --- AUDIO & PARAMÈTRES ---
const isSettingsOpen = ref(false);
const audioSettings = reactive({
    bgMusicMuted: false,
    bgMusicVolume: 0.1,
    sfxMuted: false,
    sfxVolume: 0.7,
});

let bgAudio = null;
let audioCtx = null;

const initAudio = () => {
    if (!bgAudio) {
        // On passe l'URL générée par l'import au lieu du chemin brut
        bgAudio = new Audio(bgMusicUrl);
        bgAudio.loop = true;
        bgAudio.volume = audioSettings.bgMusicVolume;
    }
};

const playBgMusic = () => {
    if (bgAudio && !audioSettings.bgMusicMuted) {
        bgAudio.play().catch(() => {
            // Auto-play bloqué jusqu'à interaction utilisateur
        });
    }
};

const pauseBgMusic = () => {
    if (bgAudio) {
        bgAudio.pause();
    }
};

const updateBgVolume = () => {
    if (bgAudio) {
        bgAudio.volume = audioSettings.bgMusicVolume;
        if (audioSettings.bgMusicMuted) {
            bgAudio.pause();
        } else if (gameState.value === "PLAYING") {
            bgAudio.play().catch(() => {});
        }
    }
};

// Son par défaut généré pour la collecte de pièce (Web Audio API)
const playCoinSound = () => {
    if (audioSettings.sfxMuted || audioSettings.sfxVolume <= 0) return;
    try {
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioCtx.state === "suspended") {
            audioCtx.resume();
        }
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = "sine";

        // Fréquence aiguë montante typique d'un son de pièce
        const now = audioCtx.currentTime;
        osc.frequency.setValueAtTime(987.77, now); // B5
        osc.frequency.setValueAtTime(1318.51, now + 0.08); // E6

        gain.gain.setValueAtTime(audioSettings.sfxVolume * 0.3, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 0.25);

        osc.connect(gain);
        gain.connect(audioCtx.destination);

        osc.start(now);
        osc.stop(now + 0.25);
    } catch (e) {
        console.error("Erreur lecture audio SFX", e);
    }
};

// --- ÉTAT DU JEU ---
const gameState = ref("IDLE"); // IDLE, PLAYING, VICTORY

const player = reactive({
    x: 100,
    y: 0, // Hauteur (0 = sol, négatif = en l'air, positif = chute)
    velocityY: 0,
    isJumping: false,
    isFallen: false,
    speed: 6,
    isMoving: false,
    direction: "right", // 'right' ou 'left'
});

const gravity = 0.7;
const jumpPower = -13;

const keys = reactive({ left: false, right: false });
const stations = ref([]);

let animationFrameId = null;

// --- SAUT ---
const jump = () => {
    if (gameState.value !== "PLAYING" || player.isJumping || player.isFallen)
        return;
    player.isJumping = true;
    player.velocityY = jumpPower;
};

// --- GESTION DU JOYSTICK VIRTUEL ---
const joystickContainer = ref(null);
const joystickThumb = ref(null);
const isDragging = ref(false);
const joystickPos = reactive({ x: 0, y: 0 });
let joystickCenter = { x: 0, y: 0 };

const startJoystick = (e) => {
    if (gameState.value !== "PLAYING") return;
    isDragging.value = true;
    const rect = joystickContainer.value.getBoundingClientRect();
    joystickCenter = {
        x: rect.left + rect.width / 2,
        y: rect.top + rect.height / 2,
    };
    handleJoystickMove(e);
};

const handleJoystickMove = (e) => {
    if (!isDragging.value) return;
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;

    let deltaX = clientX - joystickCenter.x;
    let deltaY = clientY - joystickCenter.y;
    const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
    const maxRadius = 40;

    if (distance > maxRadius) {
        deltaX = (deltaX / distance) * maxRadius;
        deltaY = (deltaY / distance) * maxRadius;
    }

    joystickPos.x = deltaX;
    joystickPos.y = deltaY;

    if (deltaX < -10) {
        keys.left = true;
        keys.right = false;
        player.direction = "left";
    } else if (deltaX > 10) {
        keys.right = true;
        keys.left = false;
        player.direction = "right";
    } else {
        keys.left = false;
        keys.right = false;
    }

    // Saut en poussant le joystick vers le haut
    if (deltaY < -25 && !player.isJumping) {
        jump();
    }
};

const stopJoystick = () => {
    isDragging.value = false;
    joystickPos.x = 0;
    joystickPos.y = 0;
    keys.left = false;
    keys.right = false;
};

// --- CONTRÔLES CLAVIER ---
const handleKeyDown = (e) => {
    if (gameState.value !== "PLAYING") return;
    if (e.key === "ArrowLeft" || e.key === "q" || e.key === "a") {
        keys.left = true;
        player.direction = "left";
    }
    if (e.key === "ArrowRight" || e.key === "d") {
        keys.right = true;
        player.direction = "right";
    }
    if (
        e.key === " " ||
        e.key === "ArrowUp" ||
        e.key === "w" ||
        e.key === "z"
    ) {
        jump();
    }
};

const handleKeyUp = (e) => {
    if (e.key === "ArrowLeft" || e.key === "q" || e.key === "a")
        keys.left = false;
    if (e.key === "ArrowRight" || e.key === "d") keys.right = false;
};

// --- MOTEUR DU JEU 3D ---
const startGame = () => {
    gameState.value = "PLAYING";
    player.x = 100;
    player.y = 0;
    player.velocityY = 0;
    player.isJumping = false;
    player.isFallen = false;
    keys.left = false;
    keys.right = false;
    score.value = 0;

    generateCoins();
    initAudio();
    playBgMusic();

    stations.value = portfolioStations.map((s) => ({
        ...s,
        isNear: false,
    }));
    loop();
};

const loop = () => {
    if (gameState.value !== "PLAYING") return;

    // Animation de chute dans un trou
    if (player.isFallen) {
        player.y += 8;
        if (player.y > 250) {
            // Réapparition après la chute
            player.y = 0;
            player.isFallen = false;
            player.x = Math.max(100, player.x - 200);
        }
        animationFrameId = requestAnimationFrame(loop);
        return;
    }

    // Déplacement horizontal
    player.isMoving = false;
    if (keys.left) {
        player.x -= player.speed;
        player.isMoving = true;
    }
    if (keys.right) {
        player.x += player.speed;
        player.isMoving = true;
    }

    if (player.x < 0) player.x = 0;
    if (player.x > worldWidth) {
        player.x = worldWidth;
        gameState.value = "VICTORY";
        pauseBgMusic();
        return;
    }

    // Physique du Saut
    if (player.isJumping) {
        player.y += player.velocityY;
        player.velocityY += gravity;

        if (player.y >= 0) {
            player.y = 0;
            player.velocityY = 0;
            player.isJumping = false;
        }
    }

    // Test de collision avec les Trous (Si le joueur ne saute pas)
    if (!player.isJumping && player.y >= 0) {
        const fallenHole = holes.value.find(
            (h) => player.x > h.x + 20 && player.x < h.x + h.width - 20,
        );
        if (fallenHole) {
            player.isFallen = true;
            player.isMoving = false;
        }
    }

    // Collision avec les pièces
    coins.value.forEach((coin) => {
        if (!coin.collected) {
            const distX = Math.abs(player.x - coin.x);
            const distY = Math.abs(player.y - coin.y);
            // Tolérance de proximité pour attraper la pièce
            if (distX < 35 && distY < 40) {
                coin.collected = true;
                score.value += 1;
                playCoinSound();
            }
        }
    });

    // Proximité avec les bornes
    stations.value.forEach((station) => {
        const distance = Math.abs(player.x - station.x);
        station.isNear = distance < 150;
    });

    animationFrameId = requestAnimationFrame(loop);
};

const cameraX = computed(() => {
    const offset = player.x - window.innerWidth / 2;
    return Math.max(0, Math.min(offset, worldWidth - window.innerWidth + 300));
});

const progress = computed(() =>
    Math.min(100, Math.floor((player.x / worldWidth) * 100)),
);

onMounted(() => {
    window.addEventListener("keydown", handleKeyDown);
    window.addEventListener("keyup", handleKeyUp);
    window.addEventListener("mousemove", handleJoystickMove);
    window.addEventListener("mouseup", stopJoystick);
    window.addEventListener("touchmove", handleJoystickMove);
    window.addEventListener("touchend", stopJoystick);
});

onUnmounted(() => {
    cancelAnimationFrame(animationFrameId);
    pauseBgMusic();
    window.removeEventListener("keydown", handleKeyDown);
    window.removeEventListener("keyup", handleKeyUp);
    window.removeEventListener("mousemove", handleJoystickMove);
    window.removeEventListener("mouseup", stopJoystick);
    window.removeEventListener("touchmove", handleJoystickMove);
    window.removeEventListener("touchend", stopJoystick);
});
</script>

<template>
    <div
        class="relative w-full h-screen bg-slate-950 overflow-hidden font-sans select-none flex flex-col text-slate-200"
    >
        <!-- HEADER -->
        <header
            class="absolute top-0 w-full p-4 flex justify-between items-center z-50 bg-slate-900/80 backdrop-blur-md border-b border-cyan-500/20 shadow-lg"
        >
            <div
                class="w-full flex items-center gap-3 md:gap-4 justify-between"
            >
                <div
                    class="font-black text-cyan-400 text-lg tracking-wider hidden md:block whitespace-nowrap"
                >
                    CYBER_PORTFOLIO 3D
                </div>

                <!-- COMPTEUR DE PIÈCES -->

                <div
                    class="flex-1 max-w-md mx-2 md:mx-4 bg-slate-800 border border-slate-700 h-5 rounded-full overflow-hidden relative shadow-inner"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 transition-all duration-100"
                        :style="{ width: progress + '%' }"
                    ></div>
                    <span
                        class="absolute inset-0 flex items-center justify-center text-[10px] font-black tracking-widest text-white drop-shadow"
                    >
                        EXPLORATION : {{ progress }}%
                    </span>
                </div>

                <div class="flex items-center gap-2 pointer-events-auto">
                    <!-- BOUTON SETTINGS (Icône i / engrenage) -->
                    <button
                        @click="isSettingsOpen = true"
                        class="w-9 h-9 bg-slate-800 hover:bg-slate-700 border border-cyan-500/40 text-cyan-400 rounded-xl font-bold text-sm flex items-center justify-center shadow transition-all cursor-pointer"
                        title="Paramètres audio"
                    >
                        <i class="fa-solid fa-gear"></i>
                    </button>

                    <!-- Bouton retour Home vers la route Laravel '/' -->
                    <a
                        href="/"
                        class="px-3 md:px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-cyan-500/40 text-cyan-400 rounded-xl font-bold text-xs shadow transition-all flex items-center gap-2 no-underline"
                    >
                        <span>ACCUEIL</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- MONDE 3D AVEC PERSPECTIVE -->
        <main
            class="relative flex-1 w-full overflow-hidden bg-gradient-to-b from-[#090a16] via-[#10132b] to-[#05060a] perspective-scene"
        >
            <!-- MESSAGE DE DESCRIPTION DANS L'ESPACE VIDE DU HAUT -->
            <div
                v-if="gameState === 'PLAYING'"
                class="absolute top-20 left-0 w-full flex flex-col items-center gap-3 z-30 pointer-events-none px-4"
            >
                <!-- Message indicatif -->
                <div
                    class="max-w-xl bg-slate-900/60 border border-cyan-500/30 px-5 py-2 rounded-2xl backdrop-blur-md shadow-lg animate-pulse text-center"
                >
                    <p
                        class="text-xs md:text-sm font-bold text-cyan-300 tracking-wide leading-relaxed"
                    >
                        Sautez par-dessus les trous et récupérez les pièces, et
                        explorez mon portfolio
                    </p>
                </div>

                <!-- Score -->
                <div
                    class="self-start ml-2 flex items-center gap-2 bg-slate-800/90 border border-amber-500/40 px-4 py-2 rounded-full text-amber-400 font-black text-sm shadow shrink-0"
                >
                    <i
                        class="fa-solid fa-coins text-amber-400 animate-pulse"
                    ></i>

                    <span class="tabular-nums whitespace-nowrap">
                        {{ score }}
                    </span>
                </div>
            </div>

            <!-- Ciel et effets lointains -->
            <div
                class="absolute inset-0 pointer-events-none"
                :style="{ transform: `translateX(${-cameraX * 0.2}px)` }"
            >
                <div
                    class="absolute bottom-32 left-0 w-[12000px] h-[500px] bg-repeat-x opacity-20 bg-[linear-gradient(90deg,#1e1b4b_0px,#312e81_150px,transparent_150px)] bg-[size:300px_400px]"
                ></div>
            </div>

            <!-- Scène 3D mondiale qui suit le joueur -->
            <div
                class="absolute inset-0 world-container transition-transform duration-75"
                :style="{ transform: `translateX(${-cameraX}px)` }"
            >
                <!-- SOL 3D INCLINÉ -->
                <div class="floor-3d">
                    <div class="floor-grid"></div>

                    <!-- TROUS DANS LE SOL -->
                    <div
                        v-for="hole in holes"
                        :key="'hole-' + hole.id"
                        class="absolute top-0 h-full bg-slate-950/95 border-x-2 border-cyan-500/80 shadow-[inset_0_0_30px_#000]"
                        :style="{
                            left: hole.x + 'px',
                            width: hole.width + 'px',
                        }"
                    >
                        <div
                            class="w-full h-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-cyan-950/40 via-slate-950 to-slate-950"
                        ></div>
                        <div
                            class="absolute -top-5 -left-3 text-yellow-400 text-xs font-black animate-bounce"
                        >
                            ⚠️
                        </div>
                        <div
                            class="absolute -top-5 -right-3 text-yellow-400 text-xs font-black animate-bounce"
                        >
                            ⚠️
                        </div>
                    </div>
                </div>

                <!-- PIÈCES À RÉCUPÉRER (COINS) -->
                <div
                    v-for="coin in coins"
                    :key="'coin-' + coin.id"
                    v-show="!coin.collected"
                    class="absolute bottom-36 flex flex-col items-center pointer-events-none transition-transform"
                    :style="{
                        left: coin.x + 'px',
                        transform: `translateX(-50%) translateY(${coin.y}px)`,
                    }"
                >
                    <div
                        class="w-7 h-7 bg-amber-400 border-2 border-amber-200 rounded-full flex items-center justify-center text-slate-950 font-black text-xs shadow-[0_0_15px_#f59e0b] animate-bounce"
                    >
                        <i class="fa-solid fa-coins"></i>
                    </div>
                </div>

                <!-- LES STATIONS DU PORTFOLIO EN 3D -->
                <div
                    v-for="station in stations"
                    :key="station.id"
                    class="absolute bottom-36 flex flex-col items-center transform -translate-x-1/2 entity-3d"
                    :style="{ left: station.x + 'px' }"
                >
                    <!-- BOUTON CLIQUABLE (DOIGT) APPARAÎT QUAND ON EST PROCHE -->
                    <a
                        v-if="station.isNear"
                        :href="station.route"
                        class="absolute -top-16 bg-cyan-400 text-slate-900 px-5 py-2 rounded-full font-black text-sm animate-bounce whitespace-nowrap shadow-[0_0_25px_#22d3ee] flex items-center gap-2 pointer-events-auto z-50 hover:bg-white hover:scale-110 transition-all no-underline cursor-pointer"
                    >
                        <span class="text-xl"
                            ><i class="fa-solid fa-arrow-right"></i
                        ></span>
                        OUVRIR LA PAGE
                    </a>

                    <!-- Hologramme / Titre flottant -->
                    <div
                        class="mb-4 bg-slate-900/90 border border-cyan-500/60 px-4 py-2 rounded-xl shadow-[0_0_20px_rgba(6,182,212,0.3)] text-center animate-bounce backdrop-blur"
                        :class="{
                            'border-cyan-300 shadow-[0_0_30px_rgba(34,211,238,0.8)] scale-110 transition-all':
                                station.isNear,
                        }"
                    >
                        <span
                            class="text-xs text-cyan-400 font-bold block tracking-widest"
                            >{{ station.subtitle }}</span
                        >
                        <span class="text-lg font-black text-white">{{
                            station.title
                        }}</span>
                    </div>

                    <!-- Borne / Portail 3D -->
                    <div
                        class="relative w-24 h-40 bg-gradient-to-t from-indigo-950 to-slate-900 border-2 border-cyan-400 rounded-t-2xl flex flex-col items-center justify-between p-3 shadow-[0_0_35px_rgba(34,211,238,0.5)]"
                        :class="{
                            'shadow-[0_0_50px_rgba(34,211,238,0.8)] border-cyan-300 transition-all':
                                station.isNear,
                        }"
                    >
                        <div
                            class="w-16 h-24 bg-cyan-950/80 rounded-lg border border-cyan-300/50 flex items-center justify-center text-4xl shadow-[inset_0_0_15px_rgba(34,211,238,0.5)]"
                        >
                            <i
                                :class="station.icon"
                                class="text-cyan-400 drop-shadow-md"
                            ></i>
                        </div>
                        <div
                            class="w-20 h-3 bg-cyan-500 rounded-full shadow-[0_0_12px_#22d3ee]"
                            :class="{
                                'bg-cyan-300 shadow-[0_0_20px_#67e8f9]':
                                    station.isNear,
                            }"
                        ></div>
                    </div>
                </div>

                <!-- LE VRAI PERSONNAGE 3D -->
                <div
                    class="absolute bottom-36 flex flex-col items-center entity-3d pointer-events-none"
                    :style="{
                        left: player.x + 'px',
                        transform: `translateX(-50%) translateY(${player.y}px) scaleX(${player.direction === 'left' ? -1 : 1})`,
                    }"
                >
                    <!-- Ombre au sol (disparaît quand le joueur saute) -->
                    <div
                        v-if="!player.isJumping && !player.isFallen"
                        class="absolute -bottom-2 w-12 h-4 bg-black/70 rounded-full blur-[3px]"
                    ></div>

                    <!-- Corps du personnage en relief -->
                    <div
                        class="relative w-14 h-24 flex flex-col items-center"
                        :class="{
                            'animate-walk':
                                player.isMoving && !player.isJumping,
                        }"
                    >
                        <!-- Tête -->
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-indigo-600 rounded-xl border border-cyan-200 relative flex items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.6)]"
                        >
                            <div
                                class="w-6 h-2.5 bg-pink-500 rounded-full shadow-[0_0_8px_#ec4899]"
                                :style="{
                                    transform:
                                        player.direction === 'left'
                                            ? 'scaleX(-1)'
                                            : 'none',
                                }"
                            ></div>
                        </div>

                        <!-- Torse -->
                        <div
                            class="w-12 h-10 bg-slate-800 border-2 border-indigo-400 rounded-lg relative flex items-center justify-center shadow-lg mt-0.5"
                        >
                            <div
                                class="w-5 h-4 bg-cyan-400 rounded shadow-[0_0_8px_#22d3ee]"
                            ></div>
                        </div>

                        <!-- Jambes -->
                        <div class="flex gap-1.5 mt-0.5">
                            <div
                                class="w-3.5 h-6 bg-slate-700 rounded-b-md shadow"
                                :class="{
                                    'rotate-12':
                                        player.isMoving || player.isJumping,
                                }"
                            ></div>
                            <div
                                class="w-3.5 h-6 bg-slate-700 rounded-b-md shadow"
                                :class="{
                                    '-rotate-12':
                                        player.isMoving || player.isJumping,
                                }"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- CONTRÔLES : JOYSTICK VIRTUEL, FLÈCHES & BOUTON SAUT -->
        <div
            class="absolute bottom-6 left-0 w-full flex justify-between items-center px-4 md:px-8 z-40 pointer-events-none"
        >
            <!-- JOYSTICK VIRTUEL -->
            <div
                ref="joystickContainer"
                @mousedown="startJoystick"
                @touchstart.prevent="startJoystick"
                class="relative w-28 h-28 bg-slate-900/60 border-2 border-cyan-500/40 rounded-full backdrop-blur-md flex items-center justify-center shadow-[0_0_20px_rgba(34,211,238,0.2)] pointer-events-auto touch-none cursor-pointer"
            >
                <div
                    class="absolute w-12 h-12 rounded-full border border-cyan-500/20"
                ></div>

                <div
                    ref="joystickThumb"
                    class="absolute w-12 h-12 bg-cyan-500 rounded-full shadow-[0_0_15px_#22d3ee] transition-transform duration-75 flex items-center justify-center"
                    :style="{
                        transform: `translate(${joystickPos.x}px, ${joystickPos.y}px)`,
                    }"
                >
                    <div class="w-4 h-4 bg-white/80 rounded-full"></div>
                </div>
            </div>

            <!-- AIDE / FLÈCHES CLAVIER -->
            <div
                class="hidden md:flex items-center gap-2 bg-slate-900/80 border border-slate-700 px-5 py-3 rounded-2xl backdrop-blur text-xs text-slate-300 pointer-events-auto shadow-lg"
            >
                <span>Utilisez</span>
                <kbd
                    class="bg-slate-800 px-2.5 py-1 rounded border border-slate-600 text-cyan-400 font-bold"
                    >Q</kbd
                >
                /
                <kbd
                    class="bg-slate-800 px-2.5 py-1 rounded border border-slate-600 text-cyan-400 font-bold"
                    >D</kbd
                >
                <span>pour bouger,</span>
                <kbd
                    class="bg-slate-800 px-2.5 py-1 rounded border border-slate-600 text-cyan-400 font-bold"
                    >ESPACE</kbd
                >
                <span>pour sauter</span>
            </div>

            <!-- BOUTONS DE DIRECTION CLASSIQUES (MASQUÉS SUR MOBILE) ET BOUTON DE SAUT -->
            <div class="flex gap-3 pointer-events-auto items-center">
                <!-- Flèche Gauche : visible seulement à partir de l'écran medium (md:) -->
                <button
                    @mousedown="
                        keys.left = true;
                        player.direction = 'left';
                    "
                    @mouseup="keys.left = false"
                    @mouseleave="keys.left = false"
                    @touchstart.prevent="
                        keys.left = true;
                        player.direction = 'left';
                    "
                    @touchend.prevent="keys.left = false"
                    class="hidden md:flex w-16 h-16 bg-slate-800/90 border-2 border-cyan-500/50 rounded-2xl backdrop-blur-md items-center justify-center active:bg-cyan-500/40 text-cyan-400 shadow-lg active:scale-95 transition-all cursor-pointer"
                >
                    <svg
                        class="w-8 h-8"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M15 19l-7-7 7-7"
                        ></path>
                    </svg>
                </button>

                <!-- BOUTON DE SAUT (Toujours visible) -->
                <button
                    @click="jump"
                    @touchstart.prevent="jump"
                    class="w-16 h-16 bg-cyan-500 border-2 border-cyan-300 text-slate-950 font-black rounded-2xl backdrop-blur-md flex items-center justify-center active:scale-95 shadow-[0_0_20px_rgba(34,211,238,0.5)] transition-all cursor-pointer md:mr-2"
                >
                    <i class="fas fa-arrow-up text-2xl"></i>
                </button>

                <!-- Flèche Droite : visible seulement à partir de l'écran medium (md:) -->
                <button
                    @mousedown="
                        keys.right = true;
                        player.direction = 'right';
                    "
                    @mouseup="keys.right = false"
                    @mouseleave="keys.right = false"
                    @touchstart.prevent="
                        keys.right = true;
                        player.direction = 'right';
                    "
                    @touchend.prevent="keys.right = false"
                    class="hidden md:flex w-16 h-16 bg-slate-800/90 border-2 border-cyan-500/50 rounded-2xl backdrop-blur-md items-center justify-center active:bg-cyan-500/40 text-cyan-400 shadow-lg active:scale-95 transition-all cursor-pointer"
                >
                    <svg
                        class="w-8 h-8"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M9 5l7 7-7 7"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- MODAL REGLAGES AUDIO -->
        <div
            v-if="isSettingsOpen"
            class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 pointer-events-auto"
        >
            <div
                class="w-full max-w-sm bg-slate-900 border-2 border-cyan-500/60 rounded-2xl p-6 shadow-[0_0_30px_rgba(34,211,238,0.3)] relative"
            >
                <button
                    @click="isSettingsOpen = false"
                    class="absolute top-4 right-4 text-slate-400 hover:text-white text-xl font-bold"
                >
                    &times;
                </button>

                <h2
                    class="text-xl font-black text-cyan-400 mb-6 flex items-center gap-2"
                >
                    <i class="fa-solid fa-sliders"></i> PARAMÈTRES AUDIO
                </h2>

                <!-- MUSIQUE DE FOND -->
                <div class="mb-5 space-y-2">
                    <div
                        class="flex justify-between items-center text-sm font-bold"
                    >
                        <span>Musique de fond</span>
                        <button
                            @click="
                                audioSettings.bgMusicMuted =
                                    !audioSettings.bgMusicMuted;
                                updateBgVolume();
                            "
                            class="px-3 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1"
                            :class="
                                audioSettings.bgMusicMuted
                                    ? 'bg-red-500/20 text-red-400 border border-red-500/40'
                                    : 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/40'
                            "
                        >
                            <i
                                :class="
                                    audioSettings.bgMusicMuted
                                        ? 'fa-solid fa-bell-slash'
                                        : 'fa-solid fa-bell'
                                "
                            ></i>
                        </button>
                    </div>
                    <input
                        type="range"
                        min="0"
                        max="1"
                        step="0.05"
                        v-model.number="audioSettings.bgMusicVolume"
                        @input="updateBgVolume"
                        class="w-full accent-cyan-400 bg-slate-800 rounded-lg cursor-pointer"
                    />
                </div>

                <!-- EFFETS SONORES (PIÈCES) -->
                <div class="mb-6 space-y-2">
                    <div
                        class="flex justify-between items-center text-sm font-bold"
                    >
                        <span>Effets sonores (Pièces)</span>
                        <button
                            @click="
                                audioSettings.sfxMuted = !audioSettings.sfxMuted
                            "
                            class="px-3 py-1 rounded-lg text-xs font-bold transition-all flex items-center gap-1"
                            :class="
                                audioSettings.sfxMuted
                                    ? 'bg-red-500/20 text-red-400 border border-red-500/40'
                                    : 'bg-cyan-500/20 text-cyan-400 border border-cyan-500/40'
                            "
                        >
                            <i
                                :class="
                                    audioSettings.sfxMuted
                                        ? 'fa-solid fa-bell-slash'
                                        : 'fa-solid fa-bell'
                                "
                            ></i>
                        </button>
                    </div>
                    <input
                        type="range"
                        min="0"
                        max="1"
                        step="0.05"
                        v-model.number="audioSettings.sfxVolume"
                        class="w-full accent-cyan-400 bg-slate-800 rounded-lg cursor-pointer"
                    />
                </div>

                <button
                    @click="isSettingsOpen = false"
                    class="w-full py-3 bg-cyan-500 text-slate-950 rounded-xl font-black hover:bg-cyan-400 transition-all shadow-[0_0_15px_rgba(34,211,238,0.4)]"
                >
                    FERMER
                </button>
            </div>
        </div>

        <!-- SLOT / FOOTER -->
        <div class="relative z-30 pointer-events-none">
            <slot />
            <Footer />
        </div>

        <!-- Écran d'accueil (IDLE) -->
        <div
            v-if="gameState === 'IDLE'"
            class="absolute inset-0 z-50 bg-slate-950/90 backdrop-blur-xl flex flex-col items-center justify-center p-4 text-center"
        >
            <div
                class="w-20 h-20 bg-cyan-950 border-2 border-cyan-400 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-[0_0_30px_rgba(34,211,238,0.5)] animate-pulse"
            >
                <i class="fa-solid fa-gamepad text-4xl text-cyan-400"></i>
            </div>

            <h1
                class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tight"
            >
                EXPLORE MON UNIVERS
            </h1>
            <p
                class="mb-8 text-slate-400 text-base max-w-md font-medium leading-relaxed"
            >
                Utilise le joystick virtuel ou les flèches pour te déplacer dans
                ce monde 3D. Saute par-dessus les trous et récupère les pièces
                pour maximiser ton score !
            </p>

            <button
                @click="startGame"
                class="px-10 py-4 bg-cyan-500 border-b-4 border-cyan-700 rounded-2xl font-black text-xl text-slate-950 hover:translate-y-0.5 hover:border-b-2 active:translate-y-1 active:border-b-0 transition-all shadow-[0_0_30px_rgba(34,211,238,0.4)]"
            >
                COMMENCER L'AVENTURE
            </button>
        </div>

        <!-- Écran de Victoire -->
        <div
            v-if="gameState === 'VICTORY'"
            class="absolute inset-0 z-50 bg-slate-950/90 backdrop-blur-xl flex flex-col items-center justify-center p-4 text-center"
        >
            <div class="text-7xl mb-4 animate-bounce text-amber-400">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <h1 class="text-4xl font-black text-white mb-2">FIN DU PARCOURS</h1>
            <p class="text-lg font-bold text-amber-400 mb-2">
                Pièces récoltées : {{ score }}
            </p>
            <p class="mb-8 text-slate-400 text-base">
                Tu as exploré toutes les stations de mon portfolio !
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    @click="startGame"
                    class="px-8 py-4 bg-cyan-500 text-slate-950 rounded-2xl font-bold text-lg hover:bg-cyan-400 shadow-[0_0_20px_rgba(34,211,238,0.2)]"
                >
                    RECOMMENCER
                </button>
                <a
                    href="/"
                    class="px-8 py-4 bg-slate-800 border border-slate-700 text-slate-300 rounded-2xl font-bold text-lg hover:bg-slate-700 flex items-center justify-center no-underline pointer-events-auto"
                >
                    RETOURNER À L'ACCUEIL
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped>
.perspective-scene {
    perspective: 800px;
    perspective-origin: 50% 50%;
}

.world-container {
    transform-style: preserve-3d;
}

.floor-3d {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 10000px;
    height: 250px;
    background: #090d16;
    border-top: 4px solid #22d3ee;
    transform: rotateX(60deg);
    transform-origin: bottom center;
    box-shadow:
        inset 0 50px 50px rgba(0, 0, 0, 0.8),
        0 -10px 30px rgba(34, 211, 238, 0.3);
}

.floor-grid {
    width: 100%;
    height: 100%;
    background-image:
        linear-gradient(90deg, rgba(34, 211, 238, 0.15) 2px, transparent 2px),
        linear-gradient(0deg, rgba(34, 211, 238, 0.15) 2px, transparent 2px);
    background-size: 80px 80px;
}

.entity-3d {
    transform-style: preserve-3d;
}
</style>
