<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

import codeGif from "@/assets/animations/code-loop.gif";
import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

const isOpen = ref(false);

const closeMenu = () => {
    isOpen.value = false;
};
</script>

<template>
    <header
        class="fixed left-0 top-0 z-[100] w-full px-4 pt-5 sm:px-8 lg:px-12"
    >
        <!-- ================================================= -->
        <!-- NAVIGATION -->
        <!-- ================================================= -->

        <nav
            class="mx-auto flex mb-6 max-w-7xl items-center justify-between
                   rounded-2xl
                   border border-white/10
                   bg-[#08090d]/40
                   px-4 py-3
                   shadow-[0_15px_50px_rgba(0,0,0,0.25)]
                   backdrop-blur-xl
                   sm:px-6
                   lg:px-7"
        >

            <!-- ================================================= -->
            <!-- LOGO / CODE GIF -->
            <!-- ================================================= -->

            <Link
                href="/"
                class="group flex h-11 w-36 items-center overflow-hidden rounded-xl"
            >
                <img
                    :src="codeGif"
                    alt="Code"
                    class="h-full w-full object-contain transition duration-500 group-hover:scale-105"
                />
            </Link>


            <!-- ================================================= -->
            <!-- DESKTOP GAME BUTTON -->
            <!-- ================================================= -->

            <Link
                href="/game"
                class="hidden items-center gap-3
                       rounded-full
                       border border-white/10
                       bg-[#ff02ab]
                       px-6 py-3
                       font-sans
                       text-sm
                       font-bold
                       text-white
                       shadow-[0_8px_30px_rgba(255,2,171,0.20)]
                       transition
                       duration-300
                       hover:scale-105
                       hover:bg-[#e60099]
                       hover:shadow-[0_10px_35px_rgba(255,2,171,0.35)]
                       lg:inline-flex"
            >
                <i class="fa-solid fa-gamepad text-xs"></i>

                <span class="font-sans ">
                    Explorer mon univers
                </span>

                <span
                    class="text-base transition-transform duration-300 group-hover:translate-x-1"
                >
                    →
                </span>
            </Link>


            <!-- ================================================= -->
            <!-- MOBILE MENU BUTTON -->
            <!-- ================================================= -->

            <button
                type="button"
                class="flex h-11 w-11 items-center justify-center
                       rounded-xl
                       border border-white/10
                       bg-white/5
                       text-white
                       transition
                       duration-300
                       hover:border-white/20
                       hover:bg-white/10
                       lg:hidden"
                :aria-expanded="isOpen"
                aria-label="Ouvrir le menu"
                @click="isOpen = !isOpen"
            >
                <i
                    :class="
                        isOpen
                            ? 'fa-solid fa-xmark text-lg'
                            : 'fa-solid fa-bars text-lg'
                    "
                    class="transition-transform duration-300"
                ></i>
            </button>

        </nav>


        <!-- ================================================= -->
        <!-- MOBILE MENU -->
        <!-- ================================================= -->

        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="translate-y-2 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-2 opacity-0"
        >

            <div
                v-if="isOpen"
                class="mx-auto mt-3 max-w-7xl
                       overflow-hidden
                       rounded-2xl
                       border border-white/10
                       bg-[#08090d]/90
                       p-2
                       shadow-[0_20px_60px_rgba(0,0,0,0.45)]
                       backdrop-blur-xl
                       lg:hidden"
            >

                <!-- ================================================= -->
                <!-- MOBILE GAME BUTTON -->
                <!-- ================================================= -->

                <Link
                    href="/game"
                    @click="closeMenu"
                    class="flex w-full items-center justify-center
                           gap-3
                           rounded-xl
                           border border-white/10
                           bg-[#ff02ab]
                           px-4 py-4
                           font-sans
                           text-sm
                           font-bold
                           text-white
                           shadow-[0_8px_25px_rgba(255,2,171,0.18)]
                           transition
                           duration-300
                           hover:bg-[#e60099]"
                >

                    <i class="fa-solid fa-gamepad"></i>

                    <span>
                        Explorer mon univers
                    </span>

                    <span>
                        →
                    </span>

                </Link>

            </div>

        </Transition>

    </header>
</template>
