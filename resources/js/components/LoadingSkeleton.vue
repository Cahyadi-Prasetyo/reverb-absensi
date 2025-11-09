<script setup lang="ts">
interface Props {
    type?: 'card' | 'table' | 'list';
    rows?: number;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'card',
    rows: 3,
});
</script>

<template>
    <!-- Card Skeleton -->
    <div v-if="type === 'card'" class="animate-pulse">
        <div class="bg-gray-200 dark:bg-gray-700 h-32 rounded-lg"></div>
    </div>

    <!-- Table Skeleton -->
    <div v-else-if="type === 'table'" class="animate-pulse space-y-4">
        <div class="h-10 bg-gray-200 dark:bg-gray-700 rounded"></div>
        <div v-for="i in rows" :key="i" class="h-16 bg-gray-100 dark:bg-gray-800 rounded"></div>
    </div>

    <!-- List Skeleton -->
    <div v-else-if="type === 'list'" class="animate-pulse space-y-3">
        <div v-for="i in rows" :key="i" class="flex items-center space-x-4">
            <div class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
            <div class="flex-1 space-y-2">
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                <div class="h-3 bg-gray-100 dark:bg-gray-600 rounded w-1/2"></div>
            </div>
        </div>
    </div>
</template>
