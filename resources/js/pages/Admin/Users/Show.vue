<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Edit, Trash2, Calendar, Clock, TrendingUp } from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
    email: string;
    employee_id: string | null;
    role: string;
    department: string | null;
    created_at: string;
    attendances: Attendance[];
}

interface Attendance {
    id: number;
    check_in: string;
    check_out: string | null;
    status: string;
    work_duration: string | null;
}

interface Stats {
    total_attendances: number;
    on_time: number;
    late: number;
    this_month: number;
}

interface Props {
    user: User;
    stats: Stats;
}

const props = defineProps<Props>();

const formatDate = (datetime: string) => {
    return new Date(datetime).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};

const formatTime = (datetime: string) => {
    return new Date(datetime).toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    });
};

const deleteUser = () => {
    if (confirm(`Are you sure you want to delete ${props.user.name}?`)) {
        router.delete(route('admin.users.destroy', props.user.id));
    }
};
</script>

<template>
    <AdminLayout :title="`User: ${user.name}`">
        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ user.name }}</h2>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><span class="font-medium">Email:</span> {{ user.email }}</p>
                            <p v-if="user.employee_id">
                                <span class="font-medium">Employee ID:</span> {{ user.employee_id }}
                            </p>
                            <p v-if="user.department">
                                <span class="font-medium">Department:</span> {{ user.department }}
                            </p>
                            <p>
                                <span class="font-medium">Role:</span>
                                <span
                                    :class="[
                                        user.role === 'admin'
                                            ? 'bg-purple-100 text-purple-800'
                                            : user.role === 'manager'
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-gray-100 text-gray-800',
                                        'ml-2 inline-flex rounded-full px-2 py-1 text-xs font-semibold capitalize',
                                    ]"
                                >
                                    {{ user.role }}
                                </span>
                            </p>
                            <p>
                                <span class="font-medium">Joined:</span> {{ formatDate(user.created_at) }}
                            </p>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <Link
                            :href="route('admin.users.edit', user.id)"
                            class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-700"
                        >
                            <Edit class="mr-2 h-5 w-5" />
                            Edit
                        </Link>
                        <button
                            @click="deleteUser"
                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                        >
                            <Trash2 class="mr-2 h-5 w-5" />
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="rounded-lg bg-blue-100 p-3">
                        <Calendar class="h-6 w-6 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Attendances</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ stats.total_attendances }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="rounded-lg bg-green-100 p-3">
                        <TrendingUp class="h-6 w-6 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">On Time</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ stats.on_time }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="rounded-lg bg-red-100 p-3">
                        <Clock class="h-6 w-6 text-red-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Late</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ stats.late }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="rounded-lg bg-purple-100 p-3">
                        <Calendar class="h-6 w-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">This Month</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ stats.this_month }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Attendances -->
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Attendances</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check In
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Check Out
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="attendance in user.attendances"
                            :key="attendance.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ formatDate(attendance.check_in) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ formatTime(attendance.check_in) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ attendance.check_out ? formatTime(attendance.check_out) : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ attendance.work_duration || '-' }}
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
                        <tr v-if="user.attendances.length === 0">
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No attendance records yet
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
