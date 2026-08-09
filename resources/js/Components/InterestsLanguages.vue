<script setup>
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

defineProps({
    interests: {
        type: Array,
        default: () => [],
    },

    languages: {
        type: Array,
        default: () => [],
    },
});
</script>


<template>

    <!-- ========================================================= -->
    <!-- CENTRES D'INTÉRÊT + LANGUES -->
    <!-- ========================================================= -->

    <section
        v-if="interests.length || languages.length"
        class="bg-[#450057] px-7 py-14 sm:px-10 lg:px-14"
    >

        <div
            class="mx-auto max-w-7xl"
        >

            <!-- ================================================= -->
            <!-- HEADER -->
            <!-- ================================================= -->

            <div class="mb-12">

                <Small
                    class="font-sans uppercase tracking-[0.2em] text-indigo-300"
                >
                    Profil
                </Small>


                <div class="mt-4">

                    <Title
                        class="font-sans text-white"
                    >
                        Centres d'intérêt & langues
                    </Title>

                </div>


                <div class="mt-4">

                    <Body
                        class="max-w-2xl font-sans leading-7 text-slate-300"
                    >
                        Découvrez mes centres d'intérêt ainsi que les
                        langues que je pratique et mon niveau de maîtrise.
                    </Body>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- CONTENT -->
            <!-- ================================================= -->

            <div
                class="grid grid-cols-1 gap-10 lg:grid-cols-2"
            >

                <!-- ================================================= -->
                <!-- CENTRES D'INTÉRÊT -->
                <!-- ================================================= -->

                <div
                    v-if="interests.length"
                    class="rounded-3xl border border-white/10 bg-[#101116] p-7"
                >

                    <!-- HEADER -->

                    <div
                        class="flex items-center gap-4 border-b border-white/10 pb-6"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-400/10"
                        >

                            <i
                                class="fa-solid fa-heart text-xl text-indigo-400"
                            ></i>

                        </div>


                        <div>

                            <Title
                                size="md"
                                class="font-sans text-white"
                            >
                                Centres d'intérêt
                            </Title>


                            <Small
                                class="font-sans text-slate-500"
                            >
                                Ce qui me passionne
                            </Small>

                        </div>

                    </div>


                    <!-- INTERESTS -->

                    <div
                        class="mt-6 space-y-4"
                    >

                        <article
                            v-for="interest in interests"
                            :key="interest.id"
                            class="group flex items-start gap-4 rounded-2xl border border-white/5 bg-white/[0.03] p-4 transition duration-300 hover:border-indigo-400/30 hover:bg-white/[0.06]"
                        >

                            <!-- ICON -->

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-400/10"
                            >

                                <img
                                    v-if="interest.icon"
                                    :src="
                                        interest.icon.startsWith('http')
                                            ? interest.icon
                                            : `/storage/${interest.icon}`
                                    "
                                    :alt="interest.name"
                                    class="h-6 w-6 object-contain"
                                />

                                <i
                                    v-else
                                    class="fa-solid fa-star text-indigo-400"
                                ></i>

                            </div>


                            <!-- CONTENT -->

                            <div
                                class="min-w-0 flex-1"
                            >

                                <Title
                                    size="md"
                                    class="font-sans text-white"
                                >
                                    {{ interest.name }}
                                </Title>


                                <div
                                    v-if="interest.description"
                                    class="mt-1"
                                >

                                    <Body
                                        class="font-sans text-sm leading-6 text-slate-500"
                                    >
                                        {{ interest.description }}
                                    </Body>

                                </div>

                            </div>


                            <!-- FEATURED -->

                            <span
                                v-if="interest.featured"
                                class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-400"
                            ></span>

                        </article>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- LANGUES -->
                <!-- ================================================= -->

                <div
                    v-if="languages.length"
                    class="rounded-3xl border border-white/10 bg-[#101116] p-7"
                >

                    <!-- HEADER -->

                    <div
                        class="flex items-center gap-4 border-b border-white/10 pb-6"
                    >

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-400/10"
                        >

                            <i
                                class="fa-solid fa-language text-xl text-emerald-400"
                            ></i>

                        </div>


                        <div>

                            <Title
                                size="md"
                                class="font-sans text-white"
                            >
                                Langues
                            </Title>


                            <Small
                                class="font-sans text-slate-500"
                            >
                                Mes compétences linguistiques
                            </Small>

                        </div>

                    </div>


                    <!-- LANGUAGES -->

                    <div
                        class="mt-6 space-y-6"
                    >

                        <article
                            v-for="language in languages"
                            :key="language.id"
                            class="group"
                        >

                            <!-- NAME + LEVEL -->

                            <div
                                class="flex items-center justify-between gap-4"
                            >

                                <div
                                    class="flex items-center gap-3"
                                >

                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-400/10"
                                    >

                                        <i
                                            class="fa-solid fa-comment text-sm text-emerald-400"
                                        ></i>

                                    </div>


                                    <Title
                                        size="md"
                                        class="font-sans text-white"
                                    >
                                        {{ language.name }}
                                    </Title>

                                </div>


                                <Small
                                    class="font-sans text-slate-500"
                                >
                                    {{ language.level }}
                                </Small>

                            </div>


                            <!-- BAR -->

                            <div
                                v-if="language.percentage !== null"
                                class="mt-4"
                            >

                                <div
                                    class="h-2 overflow-hidden rounded-full bg-white/5"
                                >

                                    <div
                                        class="h-full rounded-full bg-emerald-400 transition-all duration-700"
                                        :style="{
                                            width: `${Math.min(
                                                Math.max(language.percentage, 0),
                                                100
                                            )}%`,
                                        }"
                                    ></div>

                                </div>


                                <div
                                    class="mt-2 flex justify-between"
                                >

                                    <Small
                                        class="font-sans text-slate-600"
                                    >
                                        Niveau
                                    </Small>


                                    <Small
                                        class="font-sans text-slate-500"
                                    >
                                        {{ language.percentage }}%
                                    </Small>

                                </div>

                            </div>

                        </article>

                    </div>

                </div>

            </div>

        </div>

    </section>

</template>