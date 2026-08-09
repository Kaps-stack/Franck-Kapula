<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { router, usePage } from "@inertiajs/vue3";

import Footer from "@/Components/Footer.vue";
import GamePromo from "@/Components/GamePromo.vue";
import Header from "@/Components/Header.vue";
import InterestsLanguages from "@/Components/InterestsLanguages.vue";
import SplashScreen from "@/Components/SplashScreen.vue";

defineProps({
    profile: {
        type: Object,
        default: null,
    },
    projects: {
        type: Array,
        default: () => [],
    },
    experiences: {
        type: Array,
        default: () => [],
    },
    education: {
        type: Array,
        default: () => [],
    },
    interests: {
        type: Array,
        default: () => [],
    },
    languages: {
        type: Array,
        default: () => [],
    },
});

const showSplash = ref(true);
const targetRoute = ref(usePage().url || "/");

let unbindStart = null;

onMounted(() => {
    // Intercepte chaque début de navigation Inertia pour réafficher le splash
    unbindStart = router.on("start", (event) => {
        if (event?.detail?.visit?.url) {
            targetRoute.value = event.detail.visit.url.pathname;
        }
        showSplash.value = true;
    });
});

onUnmounted(() => {
    if (unbindStart) unbindStart();
});

function finishSplash() {
    showSplash.value = false;
}
</script>

<template>
    <div class="relative min-h-[100dvh] bg-[#08090d] text-white">
        <!-- ================================================= -->
        <!-- SPLASH SCREEN (S'AFFICHE À CHAQUE NAVIGATION) -->
        <!-- ================================================= -->
        <SplashScreen
            v-if="showSplash"
            :target-route="targetRoute"
            @finished="finishSplash"
        />

        <!-- ================================================= -->
        <!-- MAIN CONTENT -->
        <!-- ================================================= -->
        <Transition name="page">
            <div v-show="!showSplash" class="min-h-screen">
                <Header />

                <main>
                    <slot />
                </main>

                <InterestsLanguages
                    :interests="interests"
                    :languages="languages"
                />

                <GamePromo />

                <Footer
                    :profile="profile"
                    :projects="projects"
                    :experiences="experiences"
                    :education="education"
                />
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.page-enter-active,
.page-leave-active {
    transition: opacity 0.4s ease;
}

.page-enter-from,
.page-leave-to {
    opacity: 0;
}
</style>
