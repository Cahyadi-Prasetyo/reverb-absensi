<script setup lang="ts">
import { computed } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Users, Calendar, Clock, TrendingUp } from 'lucide-vue-next';

interface Stats {
    total_users: number;
    total_attendances: number;
    today_attendances: number;
    on_time_today: number;
    late_today: number;
}

interface Attendance {
    id: number;
    check_in: string;
    check_out: string | null;
    status: string;
    user: {
        name: string;
        email: string;
    };
}

interface Props {
    stats: Stats;
    recent_attendances: Attendance[];
}

const props = defineProps<Props>();

const statCards = computed(() => [
    {
        name: 'Total Users',
        value: props.stats.total_users,
        icon: Users,
        color: 'blue',
    },
    {
        name: 'Total Attendances',
        value: props.stats.total_attendances,
        icon: Calendar,
        color: 'green',
    },
    {
        name: 'Today Check-ins',
        value: props.stats.today_attendances,
        icon: Clock,
        color: 'purple',
    },
    {
        name: 'On Time Today',
        value: props.stats.on_time_today,
        icon: TrendingUp,
        color: 'emerald',
    },
]);

const formatTime = (datetime: string) => {
    return new Date(datetime).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    });
};

const formatDate = (datetime: string) => {
    return new Date(datetime).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <AdminLayout title="Dashboard">
        <!-- Welcome Banner -->
        <div class="mb-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
            <h1 class="text-2xl font-bold mb-2">Welcome back, Admin! 👋</h1>
            <p class="text-blue-100">Here's what's happening with your attendance system today.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div
                v-for="stat in statCards"
                :key="stat.name"
                class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4"
                :class="`border-${stat.color}-500`"
            >
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ stat.name }}</p>
                        <p class="text-3xl font-bold text-gray-900">{{ stat.value }}</p>
                    </div>
                    <div
                        :class="[
                            `bg-${stat.color}-100`,
                            'rounded-full p-4',
                        ]"
                    >
                        <component
                            :is="stat.icon"
                            :class="[
                                `text-${stat.color}-600`,
                                'h-8 w-8',
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Attendances -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Attendances</h3>
                    <span class="text-sm text-gray-500">Real-time updates</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check In
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check Out
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="attendance in recent_attendances"
                            :key="attendance.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ attendance.user.name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ attendance.user.email }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ formatDate(attendance.check_in) }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ formatTime(attendance.check_in) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div v-if="attendance.check_out" class="text-sm text-gray-900">
                                    {{ formatTime(attendance.check_out) }}
                                </div>
                                <div v-else class="text-sm text-gray-500">-</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="[
                                        attendance.status === 'on_time'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                        'inline-flex rounded-full px-2 py-1 text-xs font-semibold',
                                    ]"
                                >
                                    {{ attendance.status === 'on_time' ? 'On Time' : 'Late' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
