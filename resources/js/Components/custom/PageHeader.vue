<script lang="ts" setup>
    defineProps<{
        title: string;
    }>();
</script>
<template>
    <div class="mb-16 flex min-h-10 w-full flex-row items-center justify-between">
        <h3 class="text-2xl font-medium">{{ title }}</h3>
        <slot />
    </div>
</template>
