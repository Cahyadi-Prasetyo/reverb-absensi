<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutDashboard, Users, Calendar, Settings, LogOut, Menu } from 'lucide-vue-next';
import FlashMessage from '@/components/FlashMessage.vue';

interface Props {
    title?: string;
}

const props = defineProps<Props>();

const page = usePage();
const user = computed(() => page.props.auth.user);

const navigation = [
    { name: 'Dashboard', href: '/admin', icon: LayoutDashboard },
    { name: 'Users', href: '/admin/users', icon: Users },
    { name: 'Attendances', href: '/admin/attendances', icon: Calendar },
    { name: 'Settings', href: '/admin/settings', icon: Settings },
];

const isActive = (href: string) => {
    return page.url.startsWith(href);
};
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex h-full flex-col">
                <!-- Logo -->
                <div class="flex h-16 items-center border-b px-6">
                    <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 px-3 py-4">
                    <Link
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        :class="[
                            isActive(item.href)
                                ? 'bg-blue-50 text-blue-600'
                                : 'text-gray-700 hover:bg-gray-50',
                            'group flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors',
                        ]"
                    >
                        <component
                            :is="item.icon"
                            :class="[
                                isActive(item.href) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600',
                                'mr-3 h-5 w-5 flex-shrink-0',
                            ]"
                        />
                        {{ item.name }}
                    </Link>
                </nav>

                <!-- User Menu -->
                <div class="border-t p-4">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                            <p class="text-xs text-gray-500">{{ user.email }}</p>
                        </div>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
                        >
                            <LogOut class="h-5 w-5" />
                        </Link>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="pl-64">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex h-16 items-center justify-between px-8">
                    <h2 class="text-2xl font-semibold text-gray-900">{{ title }}</h2>
                    
                    <div class="flex items-center space-x-4">
                        <Link
                            :href="route('dashboard')"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            Back to App
                        </Link>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                <slot />
            </main>
        </div>

        <!-- Flash Messages -->
        <FlashMessage />
    </div>
</template>
