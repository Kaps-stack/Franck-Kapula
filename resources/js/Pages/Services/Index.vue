<script setup>
import { Link } from "@inertiajs/vue3";
import { Motion } from "motion-v";

import Layout from "@/Layouts/PortfolioLayout.vue";

import Heading from "@/Components/Typography/Heading.vue";
import Title from "@/Components/Typography/Title.vue";
import Body from "@/Components/Typography/Body.vue";
import Small from "@/Components/Typography/Small.vue";

defineOptions({
    layout: Layout,
});

const props = defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});

const services = props.services;

const featuredServices = services.filter(
    (service) => service.featured === true || service.featured === 1
);


const isImageIcon = (service) => {
    if (!service.icon) {
        return false;
    }

    return (
        service.icon.startsWith("/") ||
        service.icon.startsWith("http://") ||
        service.icon.startsWith("https://") ||
        service.icon.startsWith("storage/") ||
        service.icon.match(/\.(png|jpg|jpeg|gif|svg|webp)$/i)
    );
};


const iconUrl = (service) => {
    return service?.icon || null;
};


const serviceIcon = (service) => {
    if (!service.icon || isImageIcon(service)) {
        return "fa-solid fa-code";
    }

    return service.icon;
};

</script>


<template>

<section
    class="mx-auto overflow-hidden border border-white/10 bg-[#450057]"
>

<div
    class="flex flex-col items-center gap-10 px-7 py-12 sm:px-10 lg:flex-row lg:px-14 lg:py-16"
>


<!-- TEXT -->

<Motion
    class="w-full max-w-2xl lg:w-1/2"
    :initial="{
        opacity: 0,
        x: -120,
        scale: 0.95
    }"
    :whileInView="{
        opacity: 1,
        x: 0,
        scale: 1
    }"
    :viewport="{
        once: true,
        amount: 0.3
    }"
    :transition="{
        duration: 0.8,
        ease: 'easeOut'
    }"
>


<div class="mt-16">

<Heading
    class="font-sans text-4xl text-white sm:text-5xl"
>
    Mes services
</Heading>

</div>


<div class="mt-6">

<Body
    class="font-sans leading-8 text-white/60"
>
    Découvrez les services que je propose pour concevoir,
    développer et améliorer des solutions numériques
    adaptées à vos besoins.
</Body>

</div>


</Motion>



<!-- IMAGE -->

<Motion
    class="mt-4 flex w-full items-center justify-center lg:w-1/2"
    :initial="{
        opacity: 0,
        x: 120,
        rotate: 8,
        scale: 0.9
    }"
    :whileInView="{
        opacity: 1,
        x: 0,
        rotate: 0,
        scale: 1
    }"
    :viewport="{
        once: true,
        amount: 0.3
    }"
    :transition="{
        duration: 0.9,
        ease: 'easeOut'
    }"
>


<div
    class="h-64 w-64 sm:h-80 sm:w-80 lg:h-[24rem] lg:w-[24rem]"
>

<img
    src="../../assets/icons/services.png"
    alt="Mes services"
    class="h-full w-full object-contain"
/>

</div>


</Motion>


</div>

</section>




<!-- SERVICES PRINCIPAUX -->


<section
v-if="featuredServices.length"
class="bg-[#00574b] px-7 py-14 sm:px-10 lg:px-14"
>


<Motion
    class="mx-auto mb-16 max-w-7xl px-6"
    :initial="{
        opacity:0,
        y:50
    }"
    :whileInView="{
        opacity:1,
        y:0
    }"
    :viewport="{
        once:true
    }"
    :transition="{
        duration:0.7
    }"
>


<Small
    class="font-sans uppercase tracking-[0.2em] text-emerald-300"
>
    Mes domaines d'intervention
</Small>


<div class="mt-4">

<Title class="font-sans text-white">
    Services principaux
</Title>

</div>


<div class="mt-4">

<Body
    class="max-w-2xl font-sans leading-7 text-slate-300"
>
    Les services sur lesquels je me concentre
    particulièrement dans mes projets professionnels.
</Body>

</div>


</Motion>



<div
class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 md:grid-cols-2 lg:grid-cols-3"
>


<Motion
v-for="(service,index) in featuredServices"
:key="service.id"

:initial="{
    opacity:0,
    y:80,
    scale:0.85
}"

:whileInView="{
    opacity:1,
    y:0,
    scale:1
}"

:viewport="{
    once:true,
    amount:0.2
}"

:transition="{
    type:'spring',
    stiffness:120,
    damping:12,
    delay:index * 0.12
}"
>


<article
class="group relative overflow-hidden rounded-3xl border border-white/10 bg-[#101116] p-8 shadow-lg shadow-black/20 transition duration-300 hover:-translate-y-2 hover:border-emerald-300/40 hover:shadow-xl hover:shadow-black/30"
>


<div class="flex items-center justify-between">


<div
class="flex h-9 min-w-9 items-center justify-center rounded-full bg-emerald-400/10 px-3"
>

<Small class="font-sans font-semibold text-emerald-300">
{{ String(index + 1).padStart(2,"0") }}
</Small>

</div>


<Small
class="font-sans uppercase tracking-[0.15em] text-slate-600"
>
Service
</Small>


</div>


<div class="mt-8">

<div
class="flex h-20 w-20 items-center justify-center rounded-2xl bg-emerald-400/10"
>


<img
v-if="isImageIcon(service)"
:src="iconUrl(service)"
:alt="service.title"
class="h-11 w-11 object-contain"
/>


<i
v-else
:class="serviceIcon(service)"
class="text-3xl text-emerald-300"
></i>


</div>

</div>


<div class="mt-7">

<Title
size="md"
class="font-sans text-xl text-white"
>
{{ service.title }}
</Title>

</div>


<div
v-if="service.description"
class="mt-4"
>

<Body class="font-sans leading-7 text-slate-400">
{{ service.description }}
</Body>

</div>


<div
class="mt-8 flex items-center justify-between border-t border-white/10 pt-5"
>

<Small class="font-sans text-slate-600">
Domaine d'expertise
</Small>


<span
class="h-2 w-2 rounded-full bg-emerald-400"
></span>


</div>


</article>


</Motion>


</div>

</section>
<!-- ========================================================= -->
<!-- SECTION 3 — TOUS LES SERVICES -->
<!-- ========================================================= -->


<section
    v-if="services.length"
    class="bg-[#00574b] px-7 py-14 sm:px-10 lg:px-14"
>


<div
    class="mx-auto mb-16 max-w-7xl px-6"
>


<Motion
    :initial="{
        opacity:0,
        x:-60
    }"
    :whileInView="{
        opacity:1,
        x:0
    }"
    :viewport="{
        once:true
    }"
    :transition="{
        duration:0.7
    }"
>


<Small
    class="font-sans uppercase tracking-[0.2em] text-indigo-300"
>
    Mon savoir-faire
</Small>


<div class="mt-4">

<Title class="font-sans text-white">
    Tous mes services
</Title>

</div>


<div class="mt-4">

<Body
    class="max-w-2xl font-sans leading-7 text-slate-300"
>
    Retrouvez l'ensemble des services que je peux
    proposer dans le cadre de projets numériques.
</Body>

</div>


</Motion>


</div>





<!-- GRID -->


<div
    class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 md:grid-cols-2 lg:grid-cols-3"
>


<Motion
    v-for="(service,index) in services"
    :key="service.id"

    :initial="{
        opacity:0,
        y:70,
        scale:0.9
    }"

    :whileInView="{
        opacity:1,
        y:0,
        scale:1
    }"

    :viewport="{
        once:true,
        amount:0.2
    }"

    :transition="{
        type:'spring',
        stiffness:110,
        damping:14,
        delay:index * 0.08
    }"
>


<article
    class="group relative rounded-2xl border border-white/10 bg-[#101116] p-6 transition duration-300 hover:-translate-y-6 hover:border-indigo-400/40 hover:bg-[#14151c]"
>


<div
    class="flex items-center justify-between"
>


<Small
    class="font-sans font-semibold text-indigo-400"
>
{{ String(index + 1).padStart(2,"0") }}
</Small>



<Small
    v-if="service.featured"
    class="rounded-full bg-emerald-400/10 px-3 py-1 font-sans text-emerald-400"
>
Principal
</Small>


</div>





<div class="mt-6">


<div
    class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/5 transition duration-300 group-hover:bg-indigo-400/10"
>


<img
    v-if="isImageIcon(service)"
    :src="iconUrl(service)"
    :alt="service.title"
    class="h-8 w-8 object-contain"
/>



<i
    v-else
    :class="serviceIcon(service)"
    class="text-xl text-indigo-400"
></i>


</div>


</div>





<div class="mt-6">


<Title
    size="md"
    class="font-sans text-white"
>
{{ service.title }}
</Title>


</div>





<div
    v-if="service.description"
    class="mt-3"
>


<Body
    class="font-sans leading-7 text-slate-400"
>
{{ service.description }}
</Body>


</div>


</article>


</Motion>


</div>


</section>







<!-- ========================================================= -->
<!-- EMPTY -->
<!-- ========================================================= -->


<section
    v-if="!services.length"
    class="mx-auto bg-[#101116] px-7 py-16 text-center sm:px-10"
>


<div
    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5"
>


<i
    class="fa-solid fa-briefcase text-2xl text-slate-500"
></i>


</div>



<div class="mt-6">


<Title
    size="md"
    class="font-sans text-white"
>
Aucun service disponible
</Title>


</div>




<div
    class="mx-auto mt-3 max-w-md"
>


<Body
    class="font-sans text-slate-500"
>
Les services seront bientôt disponibles.
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


</template>

