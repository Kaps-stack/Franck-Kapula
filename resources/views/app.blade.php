<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<!-- ========================================================= -->
<!-- BING WEBMASTER TOOLS -->
<!-- ========================================================= -->

<meta
    name="msvalidate.01"
    content="4B8D68EF1D15A7F3B628F9BD9592C4D4"
>

<!-- ========================================================= -->
<!-- SEO -->
<!-- ========================================================= -->

<title inertia>
    Franck Kapula — Développeur Full Stack | Portfolio
</title>

<meta
    name="description"
    content="Portfolio officiel de Franck Kapula, développeur Full Stack. Découvrez ses projets, expériences, compétences, formations et réalisations."
>

<meta
    name="robots"
    content="index, follow"
>

<link
    rel="canonical"
    href="https://franck-kapula.onrender.com/"
>

<!-- ========================================================= -->
<!-- OPEN GRAPH -->
<!-- ========================================================= -->

<meta
    property="og:type"
    content="website"
>

<meta
    property="og:title"
    content="Franck Kapula — Développeur Full Stack | Portfolio"
>

<meta
    property="og:description"
    content="Portfolio officiel de Franck Kapula, développeur Full Stack. Découvrez ses projets, expériences, compétences, formations et réalisations."
>

<meta
    property="og:url"
    content="https://franck-kapula.onrender.com/"
>

<meta
    property="og:site_name"
    content="Franck Kapula — Portfolio"
>

<meta
    property="og:locale"
    content="fr_FR"
>

<!-- ========================================================= -->
<!-- X / TWITTER -->
<!-- ========================================================= -->

<meta
    name="twitter:card"
    content="summary"
>

<meta
    name="twitter:title"
    content="Franck Kapula — Développeur Full Stack | Portfolio"
>

<meta
    name="twitter:description"
    content="Portfolio officiel de Franck Kapula, développeur Full Stack. Découvrez ses projets, expériences, compétences, formations et réalisations."
>

<!-- ========================================================= -->
<!-- STRUCTURED DATA -->
<!-- ========================================================= -->

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Franck Kapula",
    "url": "https://franck-kapula.onrender.com/",
    "jobTitle": "Développeur Full Stack",
    "sameAs": [
        "https://www.linkedin.com/in/franck-kapula-3bbb1a414",
        "https://github.com/Kaps-stack",
        "https://www.instagram.com/f_.kaps",
        "https://x.com/kapulafranck"
    ]
}
</script>

<!-- ========================================================= -->
<!-- FONT AWESOME -->
<!-- ========================================================= -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
/>

<!-- ========================================================= -->
<!-- GOOGLE FONTS -->
<!-- ========================================================= -->

<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Bitcount+Prop+Single:wght@100..900&family=Spinnaker&display=swap"
    rel="stylesheet"
>

<!-- ========================================================= -->
<!-- LARAVEL / INERTIA / VITE -->
<!-- ========================================================= -->

@routes

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

@inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
