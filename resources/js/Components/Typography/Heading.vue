<script setup>
defineProps({
    size: {
        type: String,
        default: 'xl'
    }
})
</script>

<template>
    <h1
        :class="{
            'text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight': size === 'xl',
            'text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight': size === 'lg',
            'text-2xl sm:text-3xl md:text-4xl font-bold': size === 'md',
        }"
    >
        <slot />
    </h1>
</template>
