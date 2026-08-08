<script setup>
import { Head } from "@inertiajs/vue3";

import Footer from "@/Components/Footer.vue";
import GamePromo from "@/Components/GamePromo.vue";

import Header from "@/Components/Header.vue";

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
});
</script>

<template>
    <div class="min-h-[100dvh] bg-[#08090d] text-white">

        <!-- ================================================= -->
        <!-- MAIN CONTENT -->
        <!-- ================================================= -->
        <Header />
        <main>
            <slot />
        </main>

        <!-- ================================================= -->
        <!-- GAME PROMO -->
        <!-- ================================================= -->

        <GamePromo />

        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->

        <Footer
            :profile="profile"
            :projects="projects"
            :experiences="experiences"
            :education="education"
        />

    </div>
</template>
