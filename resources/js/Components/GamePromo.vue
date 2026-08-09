<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <section
        class="relative overflow-hidden bg-[#08090d] px-4 py-24 sm:px-6 sm:py-32"
    >
        <div class="mx-auto max-w-7xl">

            <!-- ================================================= -->
            <!-- TEXT -->
            <!-- ================================================= -->

            <div class="text-center">

                <Small class="font-sans text-indigo-200">
                    Une autre façon de découvrir mon travail
                </Small>

                <div class="mx-auto mt-5 max-w-4xl">
                    <Heading
                        class="font-sans text-3xl text-white sm:text-5xl lg:text-6xl"
                    >
                        Explorez mon univers.
                    </Heading>
                </div>

                <div class="mx-auto mt-6 max-w-2xl">
                    <Body
                        class="font-sans text-sm text-white/60 sm:text-base"
                    >
                        Entrez dans une expérience interactive pour
                        découvrir mon parcours, mes projets et ce que
                        je construis.
                    </Body>
                </div>

            </div>

            <!-- ================================================= -->
            <!-- GAME CONSOLE -->
            <!-- ================================================= -->

            <div
                class="mx-auto mt-14 flex w-full justify-center px-0 sm:mt-16 sm:px-4"
            >
                <div class="relative w-full max-w-5xl">

                    <!-- ================================================= -->
                    <!-- CONSOLE -->
                    <!-- ================================================= -->

                    <div
                        class="relative mx-auto
                            h-[300px]
                            w-full
                            max-w-[95vw]
                            rounded-[2rem]
                            border-4
                            border-[#18191f]
                            bg-[#111216]
                            shadow-[0_30px_70px_rgba(0,0,0,0.55)]

                            sm:h-[370px]
                            sm:max-w-4xl
                            sm:rounded-[2.5rem]

                            lg:h-[450px]
                            lg:rounded-[3rem]"
                    >

                        <!-- ================================================= -->
                        <!-- TOP LIGHT -->
                        <!-- ================================================= -->

                        <div
                            class="absolute
                                left-1/2
                                top-4
                                h-1
                                w-16
                                -translate-x-1/2
                                rounded-full
                                bg-[#ff02ab]

                                sm:top-5
                                sm:h-1.5
                                sm:w-24"
                        ></div>


                        <!-- ================================================= -->
                        <!-- SCREEN -->
                        <!-- ================================================= -->

                        <div
                            class="absolute
                                left-1/2
                                top-9
                                h-[125px]
                                w-[72%]
                                -translate-x-1/2
                                rounded-xl
                                border-[6px]
                                border-[#050609]
                                bg-[#08090d]
                                shadow-inner

                                sm:top-12
                                sm:h-[170px]
                                sm:w-[70%]
                                sm:rounded-2xl
                                sm:border-8

                                lg:h-[220px]"
                        >
                            <div
                                class="flex h-full flex-col items-center justify-center px-3 text-center"
                            >

                                <div
                                    class="mb-2
                                        text-[9px]
                                        font-sans
                                        font-bold
                                        uppercase
                                        tracking-[0.25em]
                                        text-indigo-400

                                        sm:mb-3
                                        sm:text-xs
                                        sm:tracking-[0.35em]"
                                >
                                    Portfolio.exe
                                </div>

                                <div
                                    class="text-xl
                                        font-sans
                                        font-black
                                        tracking-tight
                                        text-white

                                        sm:text-3xl
                                        lg:text-4xl"
                                >
                                    FRANCK

                                    <span class="text-[#ff02ab]">
                                        .
                                    </span>
                                </div>

                                <div
                                    class="mt-2
                                        text-[8px]
                                        font-sans
                                        uppercase
                                        tracking-[0.15em]
                                        text-slate-600

                                        sm:mt-3
                                        sm:text-xs
                                        sm:tracking-[0.25em]"
                                >
                                    Press start to explore
                                </div>

                            </div>
                        </div>


                        <!-- ================================================= -->
                        <!-- LEFT CONTROLS -->
                        <!-- ================================================= -->

                        <div
                            class="absolute
                                bottom-7
                                left-5
                                flex
                                items-center
                                gap-4

                                sm:bottom-10
                                sm:left-10
                                sm:gap-6

                                lg:left-20"
                        >

                            <!-- Joystick -->

                            <div
                                class="relative
                                    h-14
                                    w-14
                                    rounded-full
                                    border-4
                                    border-[#202127]
                                    bg-[#090a0d]
                                    shadow-inner

                                    sm:h-20
                                    sm:w-20"
                            >
                                <div
                                    class="absolute
                                        left-1/2
                                        top-1/2
                                        h-8
                                        w-8
                                        -translate-x-1/2
                                        -translate-y-1/2
                                        rounded-full
                                        border-4
                                        border-[#2b2c33]
                                        bg-[#15161c]

                                        sm:h-12
                                        sm:w-12"
                                ></div>
                            </div>


                            <!-- D-PAD -->

                            <div
                                class="relative
                                    hidden
                                    h-16
                                    w-16
                                    sm:block
                                    sm:h-20
                                    sm:w-20"
                            >
                                <div
                                    class="absolute
                                        left-1/2
                                        top-0
                                        h-full
                                        w-5
                                        -translate-x-1/2
                                        rounded
                                        bg-[#202127]

                                        sm:w-6"
                                ></div>

                                <div
                                    class="absolute
                                        left-0
                                        top-1/2
                                        h-5
                                        w-full
                                        -translate-y-1/2
                                        rounded
                                        bg-[#202127]

                                        sm:h-6"
                                ></div>
                            </div>

                        </div>


                        <!-- ================================================= -->
                        <!-- RIGHT BUTTONS -->
                        <!-- ================================================= -->

                        <div
                            class="absolute
                                bottom-7
                                right-5
                                flex
                                items-center
                                gap-2

                                sm:bottom-10
                                sm:right-10
                                sm:gap-3

                                lg:right-20"
                        >

                            <!-- A -->

                            <div
                                class="flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    border-4
                                    border-[#25262d]
                                    bg-[#ff02ab]
                                    font-sans
                                    text-[10px]
                                    font-black
                                    text-white
                                    shadow-lg

                                    sm:h-16
                                    sm:w-16
                                    sm:text-xs"
                            >
                                A
                            </div>


                            <!-- B -->

                            <div
                                class="flex
                                    h-11
                                    w-11
                                    items-center
                                    justify-center
                                    rounded-full
                                    border-4
                                    border-[#25262d]
                                    bg-[#6B21A8]
                                    font-sans
                                    text-[10px]
                                    font-black
                                    text-white
                                    shadow-lg

                                    sm:h-16
                                    sm:w-16
                                    sm:text-xs"
                            >
                                B
                            </div>

                        </div>


                        <!-- ================================================= -->
                        <!-- CENTER BUTTONS -->
                        <!-- ================================================= -->

                        <div
                            class="absolute
                                bottom-6
                                left-1/2
                                flex
                                -translate-x-1/2
                                items-center
                                gap-2

                                sm:bottom-8
                                sm:gap-4"
                        >
                            <div
                                class="h-2
                                    w-8
                                    rounded-full
                                    bg-[#292a30]

                                    sm:h-3
                                    sm:w-12"
                            ></div>

                            <div
                                class="h-2
                                    w-8
                                    rounded-full
                                    bg-[#292a30]

                                    sm:h-3
                                    sm:w-12"
                            ></div>
                        </div>

                    </div>


                    <!-- ================================================= -->
                    <!-- START BUTTON -->
                    <!-- ================================================= -->

                    <Link
                        href="/game"
                        class="absolute
                            left-1/2
                            top-1/2
                            flex
                            -translate-x-1/2
                            translate-y-[55px]
                            items-center
                            gap-2
                            rounded-full
                            border-4
                            border-[#18191f]
                            bg-white
                            px-6
                            py-3
                            text-slate-900
                            shadow-[0_15px_40px_rgba(0,0,0,0.45)]
                            transition
                            duration-300
                            hover:scale-105
                            hover:bg-[#ff02ab]
                            hover:text-white

                            sm:translate-y-[85px]
                            sm:gap-3
                            sm:px-8
                            sm:py-4"
                    >
                        <span class="text-base sm:text-lg">
                            <i class="fa-solid fa-gamepad"></i>
                        </span>

                        <Small class="font-sans font-bold">
                            START
                        </Small>

                        <span>
                            →
                        </span>
                    </Link>

                </div>
            </div>


            <!-- ================================================= -->
            <!-- GAME LABEL -->
            <!-- ================================================= -->

            <div
                class="mt-12 flex items-center justify-center gap-3 sm:mt-14"
            >
                <span
                    class="h-2 w-2 rounded-full bg-[#ff02ab]"
                ></span>

                <Small class="font-sans text-slate-500">
                    READY PLAYER 01
                </Small>

                <span
                    class="h-2 w-2 rounded-full bg-[#6B21A8]"
                ></span>
            </div>

        </div>
    </section>
</template>
