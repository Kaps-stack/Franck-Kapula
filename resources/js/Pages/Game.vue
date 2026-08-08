<script setup>
import { ref, onMounted, onUnmounted, computed, reactive } from 'vue'

// --- DONNÉES DU PORTFOLIO (Les stations dans le monde 3D) ---
const portfolioStations = [
{ id: 1, x: 1800, title: 'ÉDUCATION', route: '/educations', icon: '🎓', subtitle: 'Diplômes & Certifs', desc: 'Mon cursus académique, mes formations et mes apprentissages.' },
  { id: 2, x: 2800, title: 'EXPERIENCE', route: '/experiences', icon: '�', subtitle: 'Parcours Professionnel', desc: 'Mon parcours professionnel et mes réalisations.' },
  { id: 3, x: 3800, title: 'PROJETS', Xroute: '/projects', icon: '💻', subtitle: 'Réalisations', desc: 'Explore mes applications web, mes codes sources et mes études de cas.' },
  { id: 4, x: 4300, title: 'COMPÉTENCES', route: '/skills', icon: '⚡', subtitle: 'Stack Technique', desc: 'Les langages, frameworks et outils que je maîtrise au quotidien.' },
  { id: 5, x: 5000, title: 'CONTACT', route: '/contact', icon: '✉️', subtitle: 'Discutons !', desc: 'Prêt à collaborer sur un projet ? Envoie-moi un message.' }
]

const worldWidth = 5500 // Longueur totale du monde 3D

// --- ÉTAT DU JEU ---
const gameState = ref('IDLE') // IDLE, PLAYING, VICTORY
const activeStation = ref(null)

const player = reactive({
  x: 100,
  speed: 6,
  isMoving: false,
  direction: 'right' // 'right' ou 'left'
})

const keys = reactive({ left: false, right: false })
const stations = ref([])

let animationFrameId = null

// --- GESTION DU JOYSTICK VIRTUEL ---
const joystickContainer = ref(null)
const joystickThumb = ref(null)
const isDragging = ref(false)
const joystickPos = reactive({ x: 0, y: 0 })
let joystickCenter = { x: 0, y: 0 }

const startJoystick = (e) => {
  if (gameState.value !== 'PLAYING') return
  isDragging.value = true
  const rect = joystickContainer.value.getBoundingClientRect()
  joystickCenter = { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 }
  handleJoystickMove(e)
}

const handleJoystickMove = (e) => {
  if (!isDragging.value) return
  const clientX = e.touches ? e.touches[0].clientX : e.clientX
  const clientY = e.touches ? e.touches[0].clientY : e.clientY

  let deltaX = clientX - joystickCenter.x
  let deltaY = clientY - joystickCenter.y
  const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY)
  const maxRadius = 40

  if (distance > maxRadius) {
    deltaX = (deltaX / distance) * maxRadius
    deltaY = (deltaY / distance) * maxRadius
  }

  joystickPos.x = deltaX
  joystickPos.y = deltaY

  if (deltaX < -10) {
    keys.left = true
    keys.right = false
    player.direction = 'left'
  } else if (deltaX > 10) {
    keys.right = true
    keys.left = false
    player.direction = 'right'
  } else {
    keys.left = false
    keys.right = false
  }
}

const stopJoystick = () => {
  isDragging.value = false
  joystickPos.x = 0
  joystickPos.y = 0
  keys.left = false
  keys.right = false
}

// --- CONTRÔLES CLAVIER ---
const handleKeyDown = (e) => {
  if (gameState.value !== 'PLAYING') return
  if (e.key === 'ArrowLeft' || e.key === 'q' || e.key === 'a') {
    keys.left = true
    player.direction = 'left'
  }
  if (e.key === 'ArrowRight' || e.key === 'd') {
    keys.right = true
    player.direction = 'right'
  }
}

const handleKeyUp = (e) => {
  if (e.key === 'ArrowLeft' || e.key === 'q' || e.key === 'a') keys.left = false
  if (e.key === 'ArrowRight' || e.key === 'd') keys.right = false
}

// --- MOTEUR DU JEU 3D ---
const startGame = () => {
  gameState.value = 'PLAYING'
  player.x = 100
  keys.left = false
  keys.right = false
  stations.value = portfolioStations.map(s => ({ ...s, readyToOpen: true }))
  loop()
}

const resumeGame = () => {
  activeStation.value = null
  loop()
}

const goHome = () => {
  gameState.value = 'IDLE'
  activeStation.value = null
  keys.left = false
  keys.right = false
  isDragging.value = false
}

const loop = () => {
  if (gameState.value !== 'PLAYING' || activeStation.value) return

  player.isMoving = false
  if (keys.left) {
    player.x -= player.speed
    player.isMoving = true
  }
  if (keys.right) {
    player.x += player.speed
    player.isMoving = true
  }

  if (player.x < 0) player.x = 0
  if (player.x > worldWidth) {
    player.x = worldWidth
    gameState.value = 'VICTORY'
    return
  }

  stations.value.forEach(station => {
    const distance = Math.abs(player.x - station.x)

    if (distance < 50) {
      if (station.readyToOpen) {
        station.readyToOpen = false
        activeStation.value = station
        keys.left = false
        keys.right = false
        player.isMoving = false
        isDragging.value = false
        joystickPos.x = 0
        joystickPos.y = 0
      }
    } else if (distance > 100) {
      station.readyToOpen = true
    }
  })

  animationFrameId = requestAnimationFrame(loop)
}

const cameraX = computed(() => {
  const offset = player.x - window.innerWidth / 2
  return Math.max(0, Math.min(offset, worldWidth - window.innerWidth + 300))
})

const progress = computed(() => Math.min(100, Math.floor((player.x / worldWidth) * 100)))

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
  window.addEventListener('keyup', handleKeyUp)
  window.addEventListener('mousemove', handleJoystickMove)
  window.addEventListener('mouseup', stopJoystick)
  window.addEventListener('touchmove', handleJoystickMove)
  window.addEventListener('touchend', stopJoystick)
})

onUnmounted(() => {
  cancelAnimationFrame(animationFrameId)
  window.removeEventListener('keydown', handleKeyDown)
  window.removeEventListener('keyup', handleKeyUp)
  window.removeEventListener('mousemove', handleJoystickMove)
  window.removeEventListener('mouseup', stopJoystick)
  window.removeEventListener('touchmove', handleJoystickMove)
  window.removeEventListener('touchend', stopJoystick)
})
</script>

<template>
  <div class="relative w-full h-screen bg-slate-950 overflow-hidden font-sans select-none flex flex-col text-slate-200">

    <!-- HEADER -->
    <header class="absolute top-0 w-full p-4 flex justify-between items-center z-50 bg-slate-900/80 backdrop-blur-md border-b border-cyan-500/20 shadow-lg">
      <div class="w-full flex items-center gap-4">
        <div class="font-black text-cyan-400 text-lg tracking-wider hidden md:block">CYBER_PORTFOLIO 3D</div>

        <div class="flex-1 max-w-md mx-4 bg-slate-800 border border-slate-700 h-5 rounded-full overflow-hidden relative shadow-inner">
          <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 transition-all duration-100" :style="{ width: progress + '%' }"></div>
          <span class="absolute inset-0 flex items-center justify-center text-[10px] font-black tracking-widest text-white drop-shadow">
            EXPLORATION : {{ progress }}%
          </span>
        </div>

        <!-- Bouton retour Home vers la route Laravel '/' -->
        <a href="/" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-cyan-500/40 text-cyan-400 rounded-xl font-bold text-xs shadow transition-all flex items-center gap-2 pointer-events-auto no-underline">
          🏠 <span>ACCUEIL</span>
        </a>
      </div>
    </header>

    <!-- MONDE 3D AVEC PERSPECTIVE -->
    <main class="relative flex-1 w-full overflow-hidden bg-gradient-to-b from-[#090a16] via-[#10132b] to-[#05060a] perspective-scene">

      <!-- MESSAGE DE DESCRIPTION DANS L'ESPACE VIDE DU HAUT -->
      <div v-if="gameState === 'PLAYING'" class="absolute top-20 w-full flex justify-center z-30 pointer-events-none">
        <div class="bg-slate-900/60 border border-cyan-500/30 px-6 py-2 rounded-2xl backdrop-blur-md text-center shadow-lg animate-pulse">
          <p class="text-xs md:text-sm font-bold text-cyan-300 tracking-wide">
            ✨ Explorez le monde et approchez-vous des bornes pour découvrir chaque section du portfolio !
          </p>
        </div>
      </div>

      <!-- Ciel et effets lointains -->
      <div class="absolute inset-0 pointer-events-none" :style="{ transform: `translateX(${-cameraX * 0.2}px)` }">
        <div class="absolute bottom-32 left-0 w-[8000px] h-[500px] bg-repeat-x opacity-20 bg-[linear-gradient(90deg,#1e1b4b_0px,#312e81_150px,transparent_150px)] bg-[size:300px_400px]"></div>
      </div>

      <!-- Scène 3D mondiale qui suit le joueur -->
      <div class="absolute inset-0 world-container transition-transform duration-75" :style="{ transform: `translateX(${-cameraX}px)` }">

        <!-- SOL 3D INCLINÉ -->
        <div class="floor-3d">
          <div class="floor-grid"></div>
        </div>

        <!-- LES STATIONS DU PORTFOLIO EN 3D -->
        <div v-for="station in stations" :key="station.id"
             class="absolute bottom-36 flex flex-col items-center transform -translate-x-1/2 entity-3d"
             :style="{ left: station.x + 'px' }">

          <!-- Hologramme / Titre flottant -->
          <div class="mb-4 bg-slate-900/90 border border-cyan-500/60 px-4 py-2 rounded-xl shadow-[0_0_20px_rgba(6,182,212,0.3)] text-center animate-bounce backdrop-blur">
            <span class="text-xs text-cyan-400 font-bold block tracking-widest">{{ station.subtitle }}</span>
            <span class="text-lg font-black text-white">{{ station.title }}</span>
          </div>

          <!-- Borne / Portail 3D -->
          <div class="relative w-24 h-40 bg-gradient-to-t from-indigo-950 to-slate-900 border-2 border-cyan-400 rounded-t-2xl flex flex-col items-center justify-between p-3 shadow-[0_0_35px_rgba(34,211,238,0.5)]">
            <div class="w-16 h-24 bg-cyan-950/80 rounded-lg border border-cyan-300/50 flex items-center justify-center text-4xl shadow-[inset_0_0_15px_rgba(34,211,238,0.5)]">
              {{ station.icon }}
            </div>
            <div class="w-20 h-3 bg-cyan-500 rounded-full shadow-[0_0_12px_#22d3ee]"></div>
          </div>
        </div>

        <!-- LE VRAI PERSONNAGE 3D -->
        <div class="absolute bottom-36 flex flex-col items-center transition-all duration-75 entity-3d"
             :style="{ left: player.x + 'px', transform: `translateX(-50%) scaleX(${player.direction === 'left' ? -1 : 1})` }">

          <!-- Ombre au sol -->
          <div class="absolute -bottom-2 w-12 h-4 bg-black/70 rounded-full blur-[3px]"></div>

          <!-- Corps du personnage en relief -->
          <div class="relative w-14 h-24 flex flex-col items-center" :class="{ 'animate-walk': player.isMoving }">

            <!-- Tête -->
            <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-indigo-600 rounded-xl border border-cyan-200 relative flex items-center justify-center shadow-[0_0_15px_rgba(34,211,238,0.6)]">
              <div class="w-6 h-2.5 bg-pink-500 rounded-full shadow-[0_0_8px_#ec4899]" :style="{ transform: player.direction === 'left' ? 'scaleX(-1)' : 'none' }"></div>
            </div>

            <!-- Torse -->
            <div class="w-12 h-10 bg-slate-800 border-2 border-indigo-400 rounded-lg relative flex items-center justify-center shadow-lg mt-0.5">
              <div class="w-5 h-4 bg-cyan-400 rounded shadow-[0_0_8px_#22d3ee]"></div>
            </div>

            <!-- Jambes -->
            <div class="flex gap-1.5 mt-0.5">
              <div class="w-3.5 h-6 bg-slate-700 rounded-b-md shadow" :class="{ 'rotate-12': player.isMoving }"></div>
              <div class="w-3.5 h-6 bg-slate-700 rounded-b-md shadow" :class="{ '-rotate-12': player.isMoving }"></div>
            </div>

          </div>
        </div>

      </div>
    </main>

    <!-- CONTRÔLES : JOYSTICK VIRTUEL & FLÈCHES -->
    <div class="absolute bottom-6 left-0 w-full flex justify-between items-center px-8 z-40 pointer-events-none">

      <!-- JOYSTICK VIRTUEL -->
      <div
        ref="joystickContainer"
        @mousedown="startJoystick"
        @touchstart.prevent="startJoystick"
        class="relative w-28 h-28 bg-slate-900/60 border-2 border-cyan-500/40 rounded-full backdrop-blur-md flex items-center justify-center shadow-[0_0_20px_rgba(34,211,238,0.2)] pointer-events-auto touch-none">

        <div class="absolute w-12 h-12 rounded-full border border-cyan-500/20"></div>

        <div
          ref="joystickThumb"
          class="absolute w-12 h-12 bg-cyan-500 rounded-full shadow-[0_0_15px_#22d3ee] transition-transform duration-75 flex items-center justify-center"
          :style="{ transform: `translate(${joystickPos.x}px, ${joystickPos.y}px)` }">
          <div class="w-4 h-4 bg-white/80 rounded-full"></div>
        </div>
      </div>

      <!-- AIDE / FLÈCHES CLAVIER -->
      <div class="hidden md:flex items-center gap-2 bg-slate-900/80 border border-slate-700 px-5 py-3 rounded-2xl backdrop-blur text-xs text-slate-300 pointer-events-auto shadow-lg">
        <span>Utilisez</span>
        <kbd class="bg-slate-800 px-2.5 py-1 rounded border border-slate-600 text-cyan-400 font-bold">Q</kbd> /
        <kbd class="bg-slate-800 px-2.5 py-1 rounded border border-slate-600 text-cyan-400 font-bold">D</kbd>
        <span>ou les </span>
        <kbd class="bg-slate-800 px-2 py-1 rounded border border-slate-600 text-cyan-400 font-bold">⬅️ ➡️</kbd>
        <span>pour bouger</span>
      </div>

      <!-- BOUTONS DE DIRECTION CLASSIQUES -->
      <div class="flex gap-3 pointer-events-auto">
        <button
          @mousedown="keys.left = true; player.direction = 'left'" @mouseup="keys.left = false" @mouseleave="keys.left = false"
          @touchstart.prevent="keys.left = true; player.direction = 'left'" @touchend.prevent="keys.left = false"
          class="w-16 h-16 bg-slate-800/90 border-2 border-cyan-500/50 rounded-2xl backdrop-blur-md flex items-center justify-center active:bg-cyan-500/40 text-cyan-400 shadow-lg active:scale-95 transition-all">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <button
          @mousedown="keys.right = true; player.direction = 'right'" @mouseup="keys.right = false" @mouseleave="keys.right = false"
          @touchstart.prevent="keys.right = true; player.direction = 'right'" @touchend.prevent="keys.right = false"
          class="w-16 h-16 bg-slate-800/90 border-2 border-cyan-500/50 rounded-2xl backdrop-blur-md flex items-center justify-center active:bg-cyan-500/40 text-cyan-400 shadow-lg active:scale-95 transition-all">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </button>
      </div>

    </div>

    <!-- SLOT / FOOTER -->
    <div class="relative z-30 pointer-events-none">
      <slot />
      <Footer />
    </div>

    <!-- === MODALE DE SECTION (POP-UP) === -->
    <div v-if="activeStation" class="absolute inset-0 z-[70] bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
      <div class="bg-slate-900 border-2 border-cyan-500 p-8 rounded-3xl shadow-[0_0_60px_rgba(34,211,238,0.4)] max-w-md w-full text-center relative overflow-hidden animate-in zoom-in duration-200">

        <div class="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl"></div>

        <div class="w-20 h-20 bg-cyan-950 border border-cyan-400 text-cyan-400 rounded-2xl flex items-center justify-center text-4xl mx-auto mb-6 shadow-[0_0_15px_rgba(34,211,238,0.3)]">
          {{ activeStation.icon }}
        </div>

        <span class="text-xs font-bold text-cyan-400 tracking-[0.2em] uppercase">{{ activeStation.subtitle }}</span>
        <h3 class="text-3xl font-black text-white mt-1 mb-3">{{ activeStation.title }}</h3>
        <p class="text-slate-300 leading-relaxed mb-8 text-sm">{{ activeStation.desc }}</p>

        <div class="flex flex-col gap-3">
          <a :href="activeStation.route" class="w-full py-4 bg-cyan-500 text-slate-950 hover:bg-cyan-400 transition-all rounded-xl font-black text-base shadow-[0_0_20px_rgba(34,211,238,0.4)] flex items-center justify-center">
            OUVRIR LA PAGE
          </a>
          <button @click="resumeGame" class="w-full py-3 bg-transparent border border-slate-700 text-slate-300 hover:bg-slate-800 hover:text-white transition-all rounded-xl font-bold text-sm">
            CONTINUER L'EXPLORATION
          </button>
        </div>
      </div>
    </div>

    <!-- Écran d'accueil (IDLE) -->
    <div v-if="gameState === 'IDLE'" class="absolute inset-0 z-50 bg-slate-950/90 backdrop-blur-xl flex flex-col items-center justify-center p-4 text-center">
      <div class="w-20 h-20 bg-cyan-950 border-2 border-cyan-400 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-[0_0_30px_rgba(34,211,238,0.5)] animate-pulse">
        🕹️
      </div>

      <h1 class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tight">
        EXPLORE MON UNIVERS
      </h1>
      <p class="mb-8 text-slate-400 text-base max-w-md font-medium leading-relaxed">
        Utilise le joystick virtuel ou les flèches pour te déplacer dans ce monde 3D. Approche-toi des bornes pour découvrir mes projets.
      </p>

      <button @click="startGame" class="px-10 py-4 bg-cyan-500 border-b-4 border-cyan-700 rounded-2xl font-black text-xl text-slate-950 hover:translate-y-0.5 hover:border-b-2 active:translate-y-1 active:border-b-0 transition-all shadow-[0_0_30px_rgba(34,211,238,0.4)]">
        COMMENCER L'AVENTURE
      </button>
    </div>

    <!-- Écran de Victoire -->
    <div v-if="gameState === 'VICTORY'" class="absolute inset-0 z-50 bg-slate-950/90 backdrop-blur-xl flex flex-col items-center justify-center p-4 text-center">
      <div class="text-7xl mb-6 animate-bounce">🏆</div>
      <h1 class="text-4xl font-black text-white mb-3">FIN DU PARCOURS</h1>
      <p class="mb-8 text-slate-400 text-base">Tu as exploré toutes les stations de mon portfolio !</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button @click="startGame" class="px-8 py-4 bg-cyan-500 text-slate-950 rounded-2xl font-bold text-lg hover:bg-cyan-400 shadow-[0_0_20px_rgba(34,211,238,0.2)]">
          RECOMMENCER
        </button>
        <a href="/" class="px-8 py-4 bg-slate-800 border border-slate-700 text-slate-300 rounded-2xl font-bold text-lg hover:bg-slate-700 flex items-center justify-center no-underline">
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
  width: 6000px;
  height: 250px;
  background: #090d16;
  border-top: 4px solid #22d3ee;
  transform: rotateX(60deg);
  transform-origin: bottom center;
  box-shadow: inset 0 50px 50px rgba(0,0,0,0.8), 0 -10px 30px rgba(34,211,238,0.3);
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

@keyframes walk {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
.animate-walk {
  animation: walk 0.25s infinite ease-in-out;
}
</style>
