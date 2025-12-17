<script lang="ts" setup>
    import NavMain from '@/Components/custom/NavMain.vue';
    import {
        Sidebar,
        SidebarContent,
        SidebarFooter,
        SidebarHeader,
        SidebarMenu,
        SidebarMenuButton,
        SidebarMenuItem,
    } from '@/Components/ui/sidebar';
    import { Van } from 'lucide-vue-next';

    interface Props {
        data: {
            navMain: Array<{
                title: string;
                url: string;
                icon: any;
            }>;
        };
    }

    defineProps<Props>();
</script>
<template>
    <Sidebar>
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton as-child class="data-[slot=sidebar-menu-button]:p-1.5!">
                        <a href="#">
                            <Van class="size-5!" />
                            <span class="text-base font-semibold">Vehease.</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="data.navMain" />
        </SidebarContent>
        <SidebarFooter>
            <!-- <NavUser :user="data.user" /> -->
        </SidebarFooter>
    </Sidebar>
</template>
