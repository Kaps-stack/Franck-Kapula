<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { Link } from "@inertiajs/vue3";

import Layout from "@/Layouts/PortfolioLayout.vue";

import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

defineOptions({
    layout: Layout,
});


/*
|--------------------------------------------------------------------------
| PROPS
|--------------------------------------------------------------------------
*/

const props = defineProps({
    awards: {
        type: Array,
        default: () => [],
    },
});


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentIndex = ref(0);

const selectedAward = ref(null);

const isPaused = ref(false);

let autoplayInterval = null;


/*
|--------------------------------------------------------------------------
| IMAGE URL
|--------------------------------------------------------------------------
*/

const imageUrl = (award) => {

    if (!award || !award.image) {
        return null
    }

    return award.image

}

/*
|--------------------------------------------------------------------------
| DATE
|--------------------------------------------------------------------------
*/

const formatDate = (date) => {
    if (!date) {
        return null;
    }

    return new Date(date).toLocaleDateString("fr-FR", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};


/*
|--------------------------------------------------------------------------
| POSITION
|--------------------------------------------------------------------------
*/

const positionLabel = (position) => {
    if (!position) {
        return null;
    }

    const value = String(position).toLowerCase();

    if (
        value.includes("1") ||
        value.includes("premier") ||
        value.includes("or") ||
        value.includes("gold")
    ) {
        return "1er prix";
    }

    if (
        value.includes("2") ||
        value.includes("deux") ||
        value.includes("argent") ||
        value.includes("silver")
    ) {
        return "2e prix";
    }

    if (
        value.includes("3") ||
        value.includes("trois") ||
        value.includes("bronze")
    ) {
        return "3e prix";
    }

    return position;
};


/*
|--------------------------------------------------------------------------
| CURRENT AWARD
|--------------------------------------------------------------------------
*/

const currentAward = computed(() => {
    if (!props.awards.length) {
        return null;
    }

    return props.awards[currentIndex.value];
});


/*
|--------------------------------------------------------------------------
| NEXT
|--------------------------------------------------------------------------
*/

const nextAward = () => {
    if (!props.awards.length) {
        return;
    }

    currentIndex.value =
        (currentIndex.value + 1) % props.awards.length;
};


/*
|--------------------------------------------------------------------------
| PREVIOUS
|--------------------------------------------------------------------------
*/

const previousAward = () => {
    if (!props.awards.length) {
        return;
    }

    currentIndex.value =
        (currentIndex.value - 1 + props.awards.length) %
        props.awards.length;
};


/*
|--------------------------------------------------------------------------
| GO TO
|--------------------------------------------------------------------------
*/

const goToAward = (index) => {
    currentIndex.value = index;
};


/*
|--------------------------------------------------------------------------
| OPEN MODAL
|--------------------------------------------------------------------------
*/

const openAward = (award) => {
    selectedAward.value = award;

    stopAutoplay();
};


/*
|--------------------------------------------------------------------------
| CLOSE MODAL
|--------------------------------------------------------------------------
*/

const closeAward = () => {
    selectedAward.value = null;

    startAutoplay();
};


/*
|--------------------------------------------------------------------------
| AUTOPLAY
|--------------------------------------------------------------------------
*/

const startAutoplay = () => {
    stopAutoplay();

    if (props.awards.length <= 1) {
        return;
    }

    autoplayInterval = setInterval(() => {
        if (!isPaused.value && !selectedAward.value) {
            nextAward();
        }
    }, 4500);
};


const stopAutoplay = () => {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
        autoplayInterval = null;
    }
};


/*
|--------------------------------------------------------------------------
| KEYBOARD
|--------------------------------------------------------------------------
*/

const handleKeyboard = (event) => {
    if (event.key === "Escape" && selectedAward.value) {
        closeAward();
    }

    if (event.key === "ArrowRight") {
        nextAward();
    }

    if (event.key === "ArrowLeft") {
        previousAward();
    }
};


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

onMounted(() => {
    startAutoplay();

    window.addEventListener("keydown", handleKeyboard);
});


onUnmounted(() => {
    stopAutoplay();

    window.removeEventListener("keydown", handleKeyboard);
});
</script>


<template>

    <!-- ========================================================= -->
    <!-- SECTION 1 — HERO -->
    <!-- ========================================================= -->

    <section
        class="mx-auto overflow-hidden border border-white/10 bg-[#171717]"
    >

        <div
            class="flex min-h-[32rem] flex-col items-center justify-center px-7 py-16 text-center sm:px-10 lg:px-14"
        >



            <div class="mt-6">

                <Title
                    class="font-sans text-justify text-5xl font-bold text-white sm:text-6xl lg:text-7xl"
                >
                    Mes réalisations
                </Title>

            </div>


            <div class="mx-auto mt-6 max-w-2xl">

                <Body
                    class="font-sans text-justify text-lg leading-8 text-slate-400"
                >
                    Les prix, distinctions et reconnaissances obtenus
                    au cours de mon parcours académique et professionnel.
                </Body>

            </div>


            <!-- ================================================= -->
            <!-- FILM STRIP DECORATION -->
            <!-- ================================================= -->

            <div
                class="mt-12 flex items-center gap-3 opacity-60"
            >

                <span
                    v-for="i in 7"
                    :key="i"
                    class="h-2 w-2 rounded-full bg-amber-400"
                ></span>

            </div>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- SECTION 2 — CINEMA CAROUSEL -->
    <!-- ========================================================= -->

    <section
        v-if="awards.length"
        class="relative overflow-hidden bg-[#0b0b0b] px-4 py-16 sm:px-8 lg:px-14"
        @mouseenter="isPaused = true"
        @mouseleave="isPaused = false"
    >

        <!-- ================================================= -->
        <!-- TOP -->
        <!-- ================================================= -->

        <div
            class="mx-auto mb-10 flex max-w-7xl items-end justify-between gap-6 px-2"
        >

            <div>

                <Small
                    class="font-sans uppercase tracking-[0.25em] text-amber-400"
                >
                    Collection
                </Small>


                <div class="mt-3">

                    <Title
                        class="font-sans text-3xl text-white sm:text-4xl"
                    >
                        Prix & distinctions
                    </Title>

                </div>

            </div>


            <!-- COUNTER -->

            <div
                class="hidden items-center gap-3 sm:flex"
            >

                <Small
                    class="font-sans text-slate-500"
                >
                    {{ String(currentIndex + 1).padStart(2, "0") }}
                </Small>


                <div class="h-px w-10 bg-white/20"></div>


                <Small
                    class="font-sans text-slate-500"
                >
                    {{ String(awards.length).padStart(2, "0") }}
                </Small>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- FILM STRIP -->
        <!-- ================================================= -->

        <div
            class="relative mx-auto max-w-7xl overflow-hidden rounded-[2rem] border border-white/10 bg-[#151515] p-3 shadow-2xl shadow-black/50 sm:p-5"
        >

            <!-- TOP HOLES -->

            <div
                class="pointer-events-none absolute left-0 right-0 top-0 z-20 flex h-5 items-center justify-around overflow-hidden px-3"
            >

                <span
                    v-for="i in 15"
                    :key="`top-${i}`"
                    class="h-3 w-7 rounded-sm bg-black"
                ></span>

            </div>


            <!-- ================================================= -->
            <!-- MAIN DISPLAY -->
            <!-- ================================================= -->

            <div
                class="relative mt-5 overflow-hidden rounded-[1.5rem] bg-black"
            >

                <div
                    class="relative h-[26rem] sm:h-[34rem] lg:h-[42rem]"
                >

                    <!-- IMAGE -->

                    <button
                        v-if="currentAward"
                        type="button"
                        class="absolute inset-0 h-full w-full cursor-pointer"
                        @click="openAward(currentAward)"
                    >

                        <img
                            v-if="imageUrl(currentAward)"
                            :src="imageUrl(currentAward)"
                            :alt="currentAward.title"
                            class="h-full w-full object-contain transition duration-700 hover:scale-[1.02]"
                        />


                        <!-- FALLBACK -->

                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-[#151515]"
                        >

                            <i
                                class="fa-solid fa-trophy text-[8rem] text-amber-400/70 sm:text-[12rem]"
                            ></i>

                        </div>


                        <!-- DARK OVERLAY -->

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent"
                        ></div>


                        <!-- CONTENT ON IMAGE -->

                        <div
                            class="absolute bottom-0 left-0 right-0 p-6 text-left sm:p-10 lg:p-12"
                        >

                            <div
                                class="flex flex-wrap items-center gap-3"
                            >

                                <Small
                                    v-if="currentAward.type"
                                    class="rounded-full bg-amber-400 px-4 py-2 font-sans font-semibold text-black"
                                >
                                    {{ currentAward.type }}
                                </Small>


                                <Small
                                    v-if="currentAward.position"
                                    class="rounded-full border border-white/20 bg-black/50 px-4 py-2 font-sans text-white backdrop-blur"
                                >
                                    {{ positionLabel(currentAward.position) }}
                                </Small>

                            </div>


                            <div class="mt-4">

                                <h2
                                    class="font-sans text-3xl font-bold text-white sm:text-4xl lg:text-5xl"
                                >
                                    {{ currentAward.title }}
                                </h2>

                            </div>


                            <p
                                v-if="currentAward.organization"
                                class="mt-3 font-sans text-lg text-white/70"
                            >
                                {{ currentAward.organization }}
                            </p>

                        </div>


                        <!-- OPEN ICON -->

                        <div
                            class="absolute right-6 top-6 flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-black/50 text-white backdrop-blur transition hover:bg-amber-400 hover:text-black"
                        >

                            <i
                                class="fa-solid fa-expand"
                            ></i>

                        </div>

                    </button>

                </div>

            </div>


            <!-- BOTTOM HOLES -->

            <div
                class="pointer-events-none mt-3 flex h-5 items-center justify-around overflow-hidden px-3"
            >

                <span
                    v-for="i in 15"
                    :key="`bottom-${i}`"
                    class="h-3 w-7 rounded-sm bg-black"
                ></span>

            </div>

        </div>


        <!-- ================================================= -->
        <!-- CONTROLS -->
        <!-- ================================================= -->

        <div
            class="mx-auto mt-8 flex max-w-7xl items-center justify-center gap-4"
        >

            <!-- PREVIOUS -->

            <button
                type="button"
                class="flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:border-amber-400/50 hover:bg-amber-400 hover:text-black"
                @click="previousAward"
            >

                <i
                    class="fa-solid fa-chevron-left"
                ></i>

            </button>


            <!-- DOTS -->

            <div
                class="flex max-w-[50vw] items-center gap-2 overflow-hidden px-2"
            >

                <button
                    v-for="(award, index) in awards"
                    :key="award.id"
                    type="button"
                    class="h-2 rounded-full transition-all duration-300"
                    :class="
                        index === currentIndex
                            ? 'w-8 bg-amber-400'
                            : 'w-2 bg-white/20 hover:bg-white/50'
                    "
                    :aria-label="`Afficher ${award.title}`"
                    @click="goToAward(index)"
                ></button>

            </div>


            <!-- NEXT -->

            <button
                type="button"
                class="flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:border-amber-400/50 hover:bg-amber-400 hover:text-black"
                @click="nextAward"
            >

                <i
                    class="fa-solid fa-chevron-right"
                ></i>

            </button>

        </div>


        <!-- ================================================= -->
        <!-- THUMBNAILS -->
        <!-- ================================================= -->

        <div
            class="mx-auto mt-10 flex max-w-7xl gap-4 overflow-x-auto px-2 pb-4"
        >

            <button
                v-for="(award, index) in awards"
                :key="`thumb-${award.id}`"
                type="button"
                class="group relative h-24 w-32 shrink-0 overflow-hidden rounded-xl border-2 bg-[#151515] transition sm:h-28 sm:w-40"
                :class="
                    index === currentIndex
                        ? 'border-amber-400'
                        : 'border-white/10 opacity-60 hover:border-white/30 hover:opacity-100'
                "
                @click="goToAward(index)"
            >

                <img
                    v-if="imageUrl(award)"
                    :src="imageUrl(award)"
                    :alt="award.title"
                    class="h-full w-full object-cover"
                />


                <div
                    v-else
                    class="flex h-full w-full items-center justify-center"
                >

                    <i
                        class="fa-solid fa-trophy text-2xl text-amber-400"
                    ></i>

                </div>


                <div
                    class="absolute inset-x-0 bottom-0 bg-black/70 px-2 py-1"
                >

                    <Small
                        class="block truncate text-left font-sans text-white"
                    >
                        {{ award.title }}
                    </Small>

                </div>

            </button>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- SECTION 3 — EMPTY -->
    <!-- ========================================================= -->

    <section
        v-else
        class="bg-[#101116] px-7 py-20 text-center"
    >

        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-white/5"
        >

            <i
                class="fa-solid fa-trophy text-3xl text-slate-500"
            ></i>

        </div>


        <div class="mt-7">

            <Title
                size="md"
                class="font-sans text-white"
            >
                Aucun prix ou distinction
            </Title>

        </div>


        <div
            class="mx-auto mt-3 max-w-md"
        >

            <Body
                class="font-sans leading-7 text-slate-500"
            >
                Les prix et distinctions seront bientôt disponibles.
            </Body>

        </div>

    </section>


    <!-- ========================================================= -->
    <!-- BACK -->
    <!-- ========================================================= -->

    <div
        class="mx-auto mt-16 max-w-7xl px-6"
    >

        <Link
            href="/"
            class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-6 py-3 font-sans text-sm text-white transition hover:bg-white hover:text-slate-900"
        >

            <span>
                ←
            </span>

            Retour à l'accueil

        </Link>

    </div>


    <!-- ========================================================= -->
    <!-- MODAL -->
    <!-- ========================================================= -->

    <Teleport to="body">

        <Transition name="award-modal">

            <div
                v-if="selectedAward"
                class="fixed inset-0 z-[9999] flex items-center justify-center overflow-y-auto bg-black/90 p-4 backdrop-blur-md sm:p-8"
                @click.self="closeAward"
            >

                <!-- ================================================= -->
                <!-- MODAL -->
                <!-- ================================================= -->

                <div
                    class="relative my-auto w-full max-w-6xl overflow-hidden rounded-3xl border border-white/10 bg-[#111111] shadow-2xl shadow-black"
                >

                    <!-- CLOSE -->

                    <button
                        type="button"
                        class="absolute right-5 top-5 z-20 flex h-12 w-12 items-center justify-center rounded-full border border-white/10 bg-black/70 text-white backdrop-blur transition hover:bg-white hover:text-black"
                        @click="closeAward"
                    >

                        <i
                            class="fa-solid fa-xmark text-xl"
                        ></i>

                    </button>


                    <!-- ================================================= -->
                    <!-- IMAGE -->
                    <!-- ================================================= -->

                    <div
                        class="flex max-h-[75vh] min-h-[20rem] items-center justify-center bg-black"
                    >

                        <img
                            v-if="imageUrl(selectedAward)"
                            :src="imageUrl(selectedAward)"
                            :alt="selectedAward.title"
                            class="max-h-[75vh] w-full object-contain"
                        />


                        <div
                            v-else
                            class="flex h-[30rem] w-full items-center justify-center"
                        >

                            <i
                                class="fa-solid fa-trophy text-[10rem] text-amber-400/70"
                            ></i>

                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- INFORMATION -->
                    <!-- ================================================= -->

                    <div
                        class="p-7 sm:p-10 lg:p-12"
                    >

                        <!-- TYPE / POSITION -->

                        <div
                            class="flex flex-wrap items-center gap-3"
                        >

                            <Small
                                v-if="selectedAward.type"
                                class="rounded-full bg-amber-400 px-4 py-2 font-sans font-semibold text-black"
                            >
                                {{ selectedAward.type }}
                            </Small>


                            <Small
                                v-if="selectedAward.position"
                                class="rounded-full border border-white/10 bg-white/5 px-4 py-2 font-sans text-amber-300"
                            >
                                {{ positionLabel(selectedAward.position) }}
                            </Small>

                        </div>


                        <!-- TITLE -->

                        <div class="mt-5">

                            <Heading
                                class="font-sans text-3xl text-white sm:text-4xl"
                            >
                                {{ selectedAward.title }}
                            </Heading>

                        </div>


                        <!-- ORGANIZATION -->

                        <div
                            v-if="selectedAward.organization"
                            class="mt-4 flex items-center gap-3"
                        >

                            <i
                                class="fa-solid fa-building text-amber-400"
                            ></i>


                            <Body
                                class="font-sans text-slate-300"
                            >
                                {{ selectedAward.organization }}
                            </Body>

                        </div>


                        <!-- DATE -->

                        <div
                            v-if="selectedAward.date"
                            class="mt-3 flex items-center gap-3"
                        >

                            <i
                                class="fa-regular fa-calendar text-amber-400"
                            ></i>


                            <Body
                                class="font-sans text-slate-400"
                            >
                                {{ formatDate(selectedAward.date) }}
                            </Body>

                        </div>


                        <!-- DESCRIPTION -->

                        <div
                            v-if="selectedAward.description"
                            class="mt-7 border-t border-white/10 pt-7"
                        >

                            <Body
                                class="max-w-4xl font-sans text-base leading-8 text-slate-400"
                            >
                                {{ selectedAward.description }}
                            </Body>

                        </div>


                        <!-- URL -->

                        <div
                            v-if="selectedAward.url"
                            class="mt-8"
                        >

                            <a
                                :href="selectedAward.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-3 rounded-full bg-amber-400 px-6 py-3 font-sans text-sm font-semibold text-black transition hover:bg-amber-300"
                            >

                                <i
                                    class="fa-solid fa-arrow-up-right-from-square"
                                ></i>

                                Voir plus d'informations

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </Transition>

    </Teleport>

</template>


<style scoped>

.award-modal-enter-active,
.award-modal-leave-active {
    transition: opacity 0.3s ease;
}

.award-modal-enter-active > div,
.award-modal-leave-active > div {
    transition:
        transform 0.3s ease,
        opacity 0.3s ease;
}

.award-modal-enter-from,
.award-modal-leave-to {
    opacity: 0;
}

.award-modal-enter-from > div,
.award-modal-leave-to > div {
    transform: scale(0.95);
    opacity: 0;
}

</style>
