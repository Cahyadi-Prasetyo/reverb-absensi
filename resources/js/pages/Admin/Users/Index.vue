<script setup lang="ts">
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Plus, Search, Edit, Trash2, Eye } from 'lucide-vue-next';
import { useDebounceFn } from '@vueuse/core';

interface User {
    id: number;
    name: string;
    email: string;
    employee_id: string | null;
    role: string;
    department: string | null;
    created_at: string;
}

interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<{ url: string | null; label: string; active: boolean }>;
}

interface Props {
    users: PaginatedData<User>;
    filters: {
        search?: string;
        role?: string;
        department?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const role = ref(props.filters.role || '');

const debouncedSearch = useDebounceFn(() => {
    router.get(
        '/admin/users',
        { search: search.value, role: role.value },
        { preserveState: true, replace: true }
    );
}, 300);

watch([search, role], debouncedSearch);

const deleteUser = (user: User) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        router.delete(`/admin/users/${user.id}`);
    }
};
</script>

<template>
    <AdminLayout title="User Management">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">User Management</h1>
            <p class="text-gray-600">Manage system users, roles, and permissions</p>
        </div>

        <!-- Header Actions -->
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full sm:w-auto">
                <!-- Search -->
                <div class="relative flex-1 sm:flex-initial">
                    <Search class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search users..."
                        class="w-full sm:w-64 rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                    />
                </div>

                <!-- Role Filter -->
                <select
                    v-model="role"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                >
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="employee">Employee</option>
                </select>
            </div>

            <Link
                :href="route('admin.users.create')"
                class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-200"
            >
                <Plus class="mr-2 h-5 w-5" />
                Add User
            </Link>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employee ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                <div class="text-sm text-gray-500">{{ user.email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ user.employee_id || '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                :class="[
                                    user.role === 'admin'
                                        ? 'bg-purple-100 text-purple-800'
                                        : user.role === 'manager'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-100 text-gray-800',
                                    'inline-flex rounded-full px-2 py-1 text-xs font-semibold capitalize',
                                ]"
                            >
                                {{ user.role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ user.department || '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <Link
                                    :href="route('admin.users.show', user.id)"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    <Eye class="h-5 w-5" />
                                </Link>
                                <Link
                                    :href="route('admin.users.edit', user.id)"
                                    class="text-yellow-600 hover:text-yellow-900"
                                >
                                    <Edit class="h-5 w-5" />
                                </Link>
                                <button
                                    @click="deleteUser(user)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    <Trash2 class="h-5 w-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing {{ users.data.length }} of {{ users.total }} users
                    </div>
                    <div class="flex space-x-2">
                        <Link
                            v-for="link in users.links"
                            :key="link.label"
                            :href="link.url || '#'"
                            :class="[
                                link.active
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-white text-gray-700 hover:bg-gray-50',
                                !link.url && 'opacity-50 cursor-not-allowed',
                                'rounded-lg border px-3 py-2 text-sm font-medium',
                            ]"
                            :disabled="!link.url"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
