<script setup lang="ts">
    import {
        SidebarGroup,
        SidebarGroupContent,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/Components/ui/sidebar';
    import { Link } from '@inertiajs/vue3';
    import type { Component } from 'vue';

    interface NavItem {
        title: string;
        url: string;
        icon?: Component;
    }

    defineProps<{
        items: NavItem[];
    }>();
</script>

<template>
    <SidebarGroup>
        <SidebarGroupContent class="flex flex-col gap-2">
            <SidebarMenu class="gap-y-2">
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton :tooltip="item.title">
                        <Link :href="item.url" class="flex items-center gap-x-2 py-4">
                            <component :is="item.icon" v-if="item.icon" class="grid size-4 place-content-center" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>
