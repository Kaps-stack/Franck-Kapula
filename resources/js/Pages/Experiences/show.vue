```vue
<script setup>
import { Head, Link } from "@inertiajs/vue3";

import Layout from "@/Layouts/PortfolioLayout.vue";

import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

defineOptions({
    layout: Layout,
});

defineProps({
    experience: {
        type: Object,
        required: true,
    },
});

const formatDate = (date) => {
    if (!date) {
        return "";
    }

    const value = new Date(date);

    if (Number.isNaN(value.getTime())) {
        return "";
    }

    return new Intl.DateTimeFormat("fr-FR", {
        month: "2-digit",
        year: "numeric",
    }).format(value);
};

const getPeriod = (experience) => {
    const start = formatDate(experience.start_date);

    if (experience.current || !experience.end_date) {
        return `${start} — Présent`;
    }

    return `${start} — ${formatDate(experience.end_date)}`;
};
</script>

<template>
    <Head
        :title="`${experience.position} — ${experience.company}`"
    />

    <div class="min-h-screen bg-[#08090d] text-white">

        <!-- ================================================= -->
        <!-- HERO -->
        <!-- ================================================= -->

        <section
            class="relative overflow-hidden bg-[#300050] px-6 pb-24 pt-32 sm:pb-32"
        >
            <div class="mx-auto max-w-5xl">

                <!-- Back -->

                <Link
                    href="/experiences"
                    class="inline-flex items-center gap-3 font-sans text-sm text-white/50 transition hover:text-white"
                >
                    <span>←</span>

                    Retour aux expériences
                </Link>


                <!-- Label -->

                <div class="mt-14">
                    <Small
                        class="font-sans uppercase tracking-[0.25em] text-indigo-200"
                    >
                        Expérience professionnelle
                    </Small>
                </div>


                <!-- Position -->

                <div class="mt-5 max-w-4xl">
                    <Heading
                        class="font-sans text-4xl text-white sm:text-6xl"
                    >
                        {{ experience.position }}
                    </Heading>
                </div>


                <!-- Company -->

                <div class="mt-5">
                    <Title
                        class="font-sans text-xl text-[#ff02ab] sm:text-2xl"
                    >
                        {{ experience.company }}
                    </Title>
                </div>


                <!-- Meta -->

                <div
                    class="mt-8 flex flex-col gap-4 text-sm sm:flex-row sm:flex-wrap sm:items-center sm:gap-6"
                >

                    <div class="flex items-center gap-2">
                        <i
                            class="fa-regular fa-calendar text-indigo-300"
                        ></i>

                        <span class="font-sans text-white/60">
                            {{ getPeriod(experience) }}
                        </span>
                    </div>


                    <div
                        v-if="experience.location"
                        class="flex items-center gap-2"
                    >
                        <i
                            class="fa-solid fa-location-dot text-indigo-300"
                        ></i>

                        <span class="font-sans text-white/60">
                            {{ experience.location }}
                        </span>
                    </div>


                    <div
                        v-if="experience.type"
                        class="flex items-center gap-2"
                    >
                        <i
                            class="fa-solid fa-briefcase text-indigo-300"
                        ></i>

                        <span class="font-sans text-white/60">
                            {{ experience.type }}
                        </span>
                    </div>

                </div>


                <!-- Current -->

                <div
                    v-if="experience.current"
                    class="mt-8 inline-flex items-center gap-2 rounded-full border border-[#ff02ab]/20 bg-[#ff02ab]/10 px-4 py-2"
                >
                    <span
                        class="h-2 w-2 rounded-full bg-[#ff02ab]"
                    ></span>

                    <Small
                        class="font-sans text-[#ff02ab]"
                    >
                        Poste actuel
                    </Small>
                </div>

            </div>
        </section>


        <!-- ================================================= -->
        <!-- CONTENT -->
        <!-- ================================================= -->

        <section
            class="bg-[#08090d] px-6 py-24 sm:py-32"
        >
            <div
                class="mx-auto grid max-w-5xl gap-14 lg:grid-cols-[1fr_280px]"
            >

                <!-- MAIN -->

                <div>

                    <Small
                        class="font-sans text-indigo-400"
                    >
                        01 — À propos de cette expérience
                    </Small>

                    <div class="mt-6">
                        <Heading
                            class="font-sans text-3xl text-white sm:text-4xl"
                        >
                            Mon rôle chez
                            {{ experience.company }}
                        </Heading>
                    </div>

                    <div
                        v-if="experience.description"
                        class="mt-8"
                    >
                        <Body
                            class="font-sans whitespace-pre-line text-lg leading-9 text-slate-400"
                        >
                            {{ experience.description }}
                        </Body>
                    </div>

                    <div
                        v-else
                        class="mt-8"
                    >
                        <Body class="font-sans text-slate-500">
                            Aucune description disponible pour cette
                            expérience.
                        </Body>
                    </div>

                </div>


                <!-- SIDEBAR -->

                <aside>

                    <div
                        class="sticky top-10 rounded-[2rem] border border-white/10 bg-[#111216] p-6"
                    >

                        <Small
                            class="font-sans uppercase tracking-[0.2em] text-slate-500"
                        >
                            Informations
                        </Small>


                        <div class="mt-6 space-y-5">

                            <!-- Company -->

                            <div>

                                <Small class="font-sans text-slate-500">
                                    Entreprise
                                </Small>

                                <p
                                    class="mt-1 font-sans text-sm font-bold text-white"
                                >
                                    {{ experience.company }}
                                </p>

                            </div>


                            <!-- Position -->

                            <div>

                                <Small class="font-sans text-slate-500">
                                    Poste
                                </Small>

                                <p
                                    class="mt-1 font-sans text-sm font-bold text-white"
                                >
                                    {{ experience.position }}
                                </p>

                            </div>


                            <!-- Period -->

                            <div>

                                <Small class="font-sans text-slate-500">
                                    Période
                                </Small>

                                <p
                                    class="mt-1 font-sans text-sm font-bold text-white"
                                >
                                    {{ getPeriod(experience) }}
                                </p>

                            </div>


                            <!-- Location -->

                            <div v-if="experience.location">

                                <Small class="font-sans text-slate-500">
                                    Localisation
                                </Small>

                                <p
                                    class="mt-1 font-sans text-sm font-bold text-white"
                                >
                                    {{ experience.location }}
                                </p>

                            </div>


                            <!-- Type -->

                            <div v-if="experience.type">

                                <Small class="font-sans text-slate-500">
                                    Type
                                </Small>

                                <p
                                    class="mt-1 font-sans text-sm font-bold text-white"
                                >
                                    {{ experience.type }}
                                </p>

                            </div>

                        </div>


                        <!-- Company URL -->

                        <a
                            v-if="experience.company_url"
                            :href="experience.company_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-8 flex w-full items-center justify-center gap-3 rounded-xl bg-white px-5 py-3 font-sans text-sm font-bold text-slate-900 transition hover:bg-[#ff02ab] hover:text-white"
                        >
                            Visiter l'entreprise

                            <i
                                class="fa-solid fa-arrow-up-right-from-square text-xs"
                            ></i>
                        </a>

                    </div>

                </aside>

            </div>
        </section>


    </div>
</template>
```
