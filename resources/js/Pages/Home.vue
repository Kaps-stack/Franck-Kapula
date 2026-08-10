<script setup>
import { ref, watch, onMounted, onUnmounted, onBeforeUnmount, nextTick } from "vue";
import { Motion } from "motion-v";
import { Head, Link } from "@inertiajs/vue3";

import PhotoCarousel from "@/Components/PhotoCarousel.vue";
import Body from "@/Components/Typography/Body.vue";
import Heading from "@/Components/Typography/Heading.vue";
import Small from "@/Components/Typography/Small.vue";
import Title from "@/Components/Typography/Title.vue";

import Layout from "@/Layouts/PortfolioLayout.vue";

import lottie from "lottie-web";

import codingManAnimation from "../assets/animations/coding_man.json";
import splashAnimation from "../assets/animations/splash.json";

defineOptions({
    layout: Layout,
});

// =========================================================
// PROPS (Une seule déclaration)
// =========================================================
const props = defineProps({
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

// =========================================================
// BIO TYPEWRITER
// =========================================================
const typedBio = ref("");
const isTyping = ref(false);
let typingInterval = null;

const startTyping = () => {
    const text =
        props.profile?.bio?.substring(0, 500) + "..." ||
        "Je transforme des idées en expériences numériques utiles, modernes et accessibles.";

    typedBio.value = "";
    let index = 0;
    isTyping.value = true;

    if (typingInterval) clearInterval(typingInterval);

    typingInterval = setInterval(() => {
        typedBio.value += text[index];
        index++;

        if (index >= text.length) {
            clearInterval(typingInterval);
            isTyping.value = false;
        }
    }, 35);
};

// Lancement automatique dès que profile.bio est disponible
watch(
    () => props.profile?.bio,
    (newBio) => {
        if (newBio) {
            startTyping();
        }
    },
    { immediate: true }
);

// =========================================================
// LOTTIE & LIFECYCLE
// =========================================================
const animationSplash = ref(null);
const animationCodingMan = ref(null);

let splash = null;
let codingMan = null;

onMounted(async () => {
    await nextTick();

    if (animationSplash.value) {
        splash = lottie.loadAnimation({
            container: animationSplash.value,
            renderer: "svg",
            loop: true,
            autoplay: true,
            animationData: splashAnimation,
        });
    }

    if (animationCodingMan.value) {
        codingMan = lottie.loadAnimation({
            container: animationCodingMan.value,
            renderer: "svg",
            loop: true,
            autoplay: true,
            animationData: codingManAnimation,
        });
    }
});

// Clean-up unique pour éviter la duplication des hooks
onBeforeUnmount(() => {
    if (typingInterval) clearInterval(typingInterval);
    if (splash) splash.destroy();
    if (codingMan) codingMan.destroy();
});
</script>


<template>


<Head :title="profile?.full_name || 'Franck Kapula'" />


<div class="bg-[#08090d] text-white">



<!-- ========================================================= -->
<!-- HERO -->
<!-- ========================================================= -->


<section
class="relative flex min-h-screen items-center overflow-hidden bg-[#001d3d] px-6 pt-24"
>


<div
class="relative z-10 mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-12 lg:flex-row"
>



<!-- ================= TEXT ================= -->


<div
class="relative z-20 mt-6 w-full max-w-3xl text-center lg:text-left"
>



<Motion

:initial="{
opacity:0,
y:50,
filter:'blur(10px)'
}"

:whileInView="{
opacity:1,
y:0,
filter:'blur(0px)'
}"

:viewport="{
once:true
}"

:transition="{
duration:0.9,
ease:'easeOut'
}"

>


<Small
class="inline-flex items-center gap-3 rounded-xl bg-[#6B21A8]/20 px-4 py-2 text-white"
>



<Motion

:animate="{

scale:[1,1.2,1],

rotate:[0,-15,15,-8,8,0]

}"

:transition="{

duration:2,

repeat:Infinity,

ease:'easeInOut'

}"

>


<i class="fa-solid fa-hand-peace text-amber-100"></i>


</Motion>



Hi, je suis

{{ profile?.full_name || "Franck Kapula" }}


</Small>


</Motion>





<Motion

class="mt-7"

:initial="{

opacity:0,

scale:0.8,

y:40

}"

:whileInView="{

opacity:1,

scale:1,

y:0

}"

:transition="{

type:'spring',

stiffness:90,

damping:12

}"

>


<h1 class="bitcount text-4xl text-white">


<span class="text-[#ff02ab]">

Un

</span>


{{ profile?.title || "Software Developer" }}



<span class="text-[#ff02ab]">

Qui transforme vos idées en solutions concrètes

</span>


</h1>


</Motion>





<!-- BIO -->

<!-- BIO -->
<Motion
  class="mx-auto mt-6 max-w-3xl lg:mx-0"
  :initial="{ opacity: 0 }"
  :whileInView="{ opacity: 1 }"
  :transition="{ duration: 0.5 }"
>
  <div class="flex items-start">
    <Body class="font-sans text-justify text-white/80">
      {{ typedBio }}
    </Body>

    <!-- Le crayon ne s'affiche QUE pendant la frappe (v-if) -->
    <Motion
      v-if="isTyping"
      class="ml-3 mt-1 inline-block"
      :animate="{
        rotate: [-20, 10, -20],
        y: [0, -4, 0]
      }"
      :transition="{
        duration: 0.8,
        repeat: Infinity
      }"
    >
      <i class="fa-solid fa-pencil text-amber-200"></i>
    </Motion>
  </div>
</Motion>




<!-- BUTTONS -->


<div
class="mt-10 flex flex-wrap justify-center gap-4 lg:justify-start"
>


<Motion

:whileHover="{

scale:1.05,

y:-5

}"

>


<Link
href="/game"

class="inline-flex items-center gap-3 rounded-full bg-white px-7 py-4 text-slate-900"
>


<Small class="text-slate-900">

Explorer mon univers

</Small>


<span>

→

</span>


</Link>


</Motion>




<Motion

v-if="profile?.cv"

:whileHover="{

scale:1.05,

y:-5

}"

>


<a

:href="profile.cv"

target="_blank"

download

class="inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-7 py-4"

>


<i class="fa-solid fa-download"></i>


<Small>

Télécharger mon CV

</Small>


</a>


</Motion>


</div>


</div>





<!-- ================= LOTTIE ================= -->


<Motion

class="flex w-full justify-center lg:w-[42%]"

:animate="{

y:[0,-15,0]

}"

:transition="{

duration:4,

repeat:Infinity,

ease:'easeInOut'

}"

>


<div

ref="animationCodingMan"

class="h-64 w-64 sm:h-80 sm:w-80 lg:h-[28rem] lg:w-[28rem]"

></div>


</Motion>



</div>


</section>
<!-- ========================================================= -->
<!-- CAROUSEL -->
<!-- ========================================================= -->

<PhotoCarousel />



<!-- ========================================================= -->
<!-- PROJECTS -->
<!-- ========================================================= -->


<section
id="projects"
class="relative bg-[#00574b] px-6 py-32"
>


<div class="mx-auto max-w-7xl">



<Motion

:initial="{
opacity:0,
y:60
}"

:whileInView="{
opacity:1,
y:0
}"

:viewport="{
once:true,
amount:0.3
}"

:transition="{
duration:0.8
}"

>


<div
class="mb-16 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
>


<div>

<Title class="font-sans text-white">

01 — Mes projets

</Title>


</div>


<Body
class="max-w-md text-slate-400 sm:text-right"
>

Quelques projets sur lesquels j'ai travaillé et les solutions que j'ai développées.

</Body>


</div>


</Motion>




<div
v-if="projects?.length"
class="grid grid-cols-1 gap-8 lg:grid-cols-2"
>



<Motion

v-for="(project,index) in projects"

:key="project.id"


:initial="{

opacity:0,

y:80,

scale:0.9,

rotateX:-15

}"


:whileInView="{

opacity:1,

y:0,

scale:1,

rotateX:0

}"


:viewport="{

once:true,

amount:0.2

}"


:transition="{

type:'spring',

stiffness:90,

damping:15,

delay:index*0.15

}"

>




<article

class="group overflow-hidden rounded-3xl border border-white/10 bg-[#02302a] transition hover:-translate-y-3"

>


<div

class="relative aspect-[16/10] overflow-hidden"

>


<img

v-if="project.image"

:src="project.image"

:alt="project.title"

class="h-full w-full object-cover transition duration-700 group-hover:scale-110"

/>



</div>




<div class="p-6 sm:p-8">


<Title

size="md"

class="font-sans text-white"

>

{{project.title}}

</Title>



<div class="mt-4">

<Body class="text-slate-400">

{{project.description}}

</Body>


</div>




<div class="mt-7 flex flex-wrap gap-3">

    <!-- DÉMO DISPONIBLE -->
    <a
        v-if="project.demo_url"
        :href="project.demo_url"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm text-slate-900 transition hover:bg-slate-200"
    >

        <i class="fa-solid fa-arrow-up-right-from-square"></i>

        Démo

    </a>


    <!-- PAS DE DÉMO -->
    <span
        v-else
        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm text-slate-400"
    >

        <i class="fa-solid fa-eye-slash"></i>

        Démo non disponible

    </span>


    <!-- GITHUB SI DISPONIBLE -->
    <a
        v-if="project.github_url"
        :href="project.github_url"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-5 py-2.5 text-sm text-white transition hover:bg-white hover:text-slate-900"
    >

        <i class="fa-brands fa-github"></i>

        GitHub

    </a>

</div>
</div>


</article>



</Motion>


</div>



</div>


</section>







<!-- ========================================================= -->
<!-- EXPERIENCE -->
<!-- ========================================================= -->


<section

id="experience"

class="border-y border-white/10 bg-[#0d0e13] px-6 py-32"

>


<div class="mx-auto max-w-7xl">



<Motion

:initial="{

opacity:0,

x:-60

}"

:whileInView="{

opacity:1,

x:0

}"

:viewport="{once:true}"

>


<Title class="text-white">

02 — Experience

</Title>


<Heading class="mt-4 text-indigo-400">

Mon parcours professionnel

</Heading>


</Motion>





<div

v-if="experiences?.length"

class="relative mt-20 ml-2 border-l border-white/10"

>



<Motion

v-for="(experience,index) in experiences"

:key="experience.id"


:initial="{

opacity:0,

x:-60

}"

:whileInView="{

opacity:1,

x:0

}"

:viewport="{

once:true,

amount:0.3

}"

:transition="{

delay:index*0.15,

duration:0.7

}"


>


<article

class="relative pb-16 pl-8 sm:pl-12"

>


<span

class="absolute -left-[5px] top-1 h-2.5 w-2.5 rounded-full bg-indigo-400"

/>



<Title size="md">

{{experience.position}}

</Title>


<Small class="text-indigo-400">

{{experience.company}}

</Small>



<div class="mt-5 max-w-2xl">

<Body class="text-slate-400">

{{experience.description}}

</Body>


</div>


</article>


</Motion>



</div>



</div>


</section>







<!-- ========================================================= -->
<!-- EDUCATION -->
<!-- ========================================================= -->


<section

id="education"

class="bg-[#00574b] px-6 py-32"

>


<div class="mx-auto max-w-7xl">



<Motion

:initial="{

opacity:0,

scale:0.9

}"

:whileInView="{

opacity:1,

scale:1

}"

:viewport="{once:true}"

>


<Title class="text-white">

03 — Education

</Title>


<Heading class="mt-4 text-indigo-400">

Formation

</Heading>


</Motion>





<div

v-if="education?.length"

class="mt-16 divide-y divide-white/10 border-y border-white/10"

>



<Motion

v-for="(item,index) in education"

:key="item.id"


:initial="{

opacity:0,

scale:0.95,

y:40

}"

:whileInView="{

opacity:1,

scale:1,

y:0

}"

:viewport="{

once:true

}"

:transition="{

delay:index*0.15

}"


>


<article

class="grid gap-6 py-10 md:grid-cols-[100px_1fr_2fr]"

>


<Small class="text-slate-500">

{{String(index+1).padStart(2,"0")}}

</Small>



<div>

<Title size="md">

{{item.degree}}

</Title>


<Small class="text-indigo-400">

{{item.institution}}

</Small>


</div>




<Body class="text-slate-400">

{{item.description}}

</Body>


</article>


</Motion>



</div>



</div>


</section>





</div>



</template>




<style scoped>

.lottie-coding{

width:100%;

height:100%;

}


.lottie-coding :deep(svg){

width:100%!important;

height:100%!important;

overflow:visible!important;

}



</style>