# 🚀 Pengembangan dengan Inertia.js + Vue 3

> Panduan lengkap untuk mengembangkan fitur baru dengan stack Inertia.js

---

## 📋 Tech Stack

**Backend:**
- Laravel 12
- Laravel Reverb (WebSocket)
- Laravel Fortify (Authentication)
- MySQL 8.0
- Redis 7

**Frontend:**
- Inertia.js 2.0
- Vue 3 (Composition API)
- TypeScript
- Tailwind CSS 4
- Reka UI (Component Library)

---

## 🎯 Rekomendasi Pengembangan

Berdasarkan proyek Anda, berikut prioritas pengembangan yang disarankan:

### 1. **Admin Panel** (High Priority)
Untuk HR/Manager mengelola sistem

**Fitur:**
- User management (CRUD)
- Attendance reports & analytics
- Leave approval workflow
- System settings
- Export data (Excel/PDF)

**Estimasi:** 2-3 minggu

### 2. **Leave Management** (Medium Priority)
Sistem cuti/izin karyawan

**Fitur:**
- Request cuti/izin
- Approval workflow
- Leave balance tracking
- Calendar view
- Notifications

**Estimasi:** 1-2 minggu

### 3. **Analytics & Reports** (Medium Priority)
Dashboard analytics yang lebih detail

**Fitur:**
- Attendance statistics
- Charts & visualizations
- Custom date range
- Department comparison
- Export reports

**Estimasi:** 1-2 minggu

### 4. **Geolocation + Photo** (Enhancement)
Validasi lokasi dan foto saat absen

**Fitur:**
- GPS validation
- Camera capture
- Location history
- Photo gallery

**Estimasi:** 1 minggu

---

## 🛠️ Struktur Pengembangan

### Backend (Laravel)

#### 1. Controllers
```php
// app/Http/Controllers/AdminController.php
class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => $this->getStats(),
            'users' => User::paginate(10),
        ]);
    }
}
```

#### 2. API Endpoints
```php
// routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('leaves', LeaveController::class);
});
```

#### 3. Broadcasting Events
```php
// app/Events/LeaveRequested.php
class LeaveRequested implements ShouldBroadcast
{
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin'),
            new PrivateChannel('user.' . $this->leave->user_id),
        ];
    }
}
```

### Frontend (Vue 3 + Inertia)

#### 1. Pages Structure
```
resources/js/pages/
├── Admin/
│   ├── Dashboard.vue
│   ├── Users/
│   │   ├── Index.vue
│   │   ├── Create.vue
│   │   └── Edit.vue
│   └── Leaves/
│       ├── Index.vue
│       └── Approve.vue
├── Leave/
│   ├── Index.vue
│   ├── Create.vue
│   └── History.vue
└── Analytics/
    └── Dashboard.vue
```

#### 2. Component Example
```vue
<!-- resources/js/pages/Admin/Dashboard.vue -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import Echo from 'laravel-echo';

interface Props {
    stats: {
        totalUsers: number;
        totalAttendances: number;
        pendingLeaves: number;
    };
    users: PaginatedData<User>;
}

const props = defineProps<Props>();

// Real-time updates
onMounted(() => {
    window.Echo.private('admin')
        .listen('.leave.requested', (e) => {
            // Update UI
            router.reload({ only: ['stats'] });
        });
});
</script>

<template>
    <AppLayout title="Admin Dashboard">
        <div class="grid grid-cols-3 gap-4">
            <StatCard title="Total Users" :value="stats.totalUsers" />
            <StatCard title="Attendances" :value="stats.totalAttendances" />
            <StatCard title="Pending Leaves" :value="stats.pendingLeaves" />
        </div>
        
        <UserTable :users="users" />
    </AppLayout>
</template>
```

---

## 🔄 Real-Time dengan Inertia.js

### Pattern 1: Polling (Simple)
```vue
<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

let interval: NodeJS.Timeout;

onMounted(() => {
    // Reload data setiap 5 detik
    interval = setInterval(() => {
        router.reload({ only: ['attendances'] });
    }, 5000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>
```

### Pattern 2: Laravel Echo (Recommended)
```vue
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
    window.Echo.channel('attendances')
        .listen('.attendance.created', (e) => {
            // Reload hanya data yang berubah
            router.reload({ 
                only: ['attendances', 'stats'],
                preserveScroll: true 
            });
        });
});
</script>
```

### Pattern 3: Manual Update (Optimal)
```vue
<script setup lang="ts">
import { ref, onMounted } from 'vue';

const attendances = ref(props.attendances);

onMounted(() => {
    window.Echo.channel('attendances')
        .listen('.attendance.created', (e) => {
            // Update langsung tanpa reload
            attendances.value.unshift(e.attendance);
        });
});
</script>
```

---

## 📦 Reusable Components

### 1. Data Table Component
```vue
<!-- resources/js/components/DataTable.vue -->
<script setup lang="ts" generic="T">
interface Props {
    data: PaginatedData<T>;
    columns: Column[];
}

const props = defineProps<Props>();
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th v-for="col in columns" :key="col.key">
                        {{ col.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.id">
                    <td v-for="col in columns" :key="col.key">
                        <slot :name="`cell-${col.key}`" :item="item">
                            {{ item[col.key] }}
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <Pagination :data="data" />
    </div>
</template>
```

### 2. Modal Component
```vue
<!-- resources/js/components/Modal.vue -->
<script setup lang="ts">
interface Props {
    show: boolean;
    maxWidth?: 'sm' | 'md' | 'lg' | 'xl';
}

const props = withDefaults(defineProps<Props>(), {
    maxWidth: 'md'
});

const emit = defineEmits<{
    close: [];
}>();
</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="fixed inset-0 z-50">
                <div class="fixed inset-0 bg-black/50" @click="emit('close')" />
                
                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div :class="[
                            'relative bg-white rounded-lg shadow-xl',
                            maxWidth === 'sm' && 'max-w-sm',
                            maxWidth === 'md' && 'max-w-md',
                            maxWidth === 'lg' && 'max-w-lg',
                            maxWidth === 'xl' && 'max-w-xl',
                        ]">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
```

---

## 🎨 UI Development Tips

### 1. Gunakan Reka UI Components
```vue
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
</script>

<template>
    <form @submit.prevent="submit">
        <Input v-model="form.name" label="Name" />
        <Select v-model="form.status" :options="statusOptions" />
        <Button type="submit">Save</Button>
    </form>
</template>
```

### 2. Form Handling dengan Inertia
```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    role: 'employee'
});

const submit = () => {
    form.post('/admin/users', {
        onSuccess: () => {
            // Success handling
        },
        onError: (errors) => {
            // Error handling
        }
    });
};
</script>
```

---

## 🧪 Testing

### 1. Component Testing
```typescript
// tests/unit/components/DataTable.spec.ts
import { mount } from '@vue/test-utils';
import DataTable from '@/components/DataTable.vue';

describe('DataTable', () => {
    it('renders data correctly', () => {
        const wrapper = mount(DataTable, {
            props: {
                data: mockData,
                columns: mockColumns
            }
        });
        
        expect(wrapper.find('table').exists()).toBe(true);
    });
});
```

### 2. Feature Testing
```php
// tests/Feature/AdminTest.php
public function test_admin_can_view_dashboard()
{
    $admin = User::factory()->admin()->create();
    
    $response = $this->actingAs($admin)
        ->get('/admin');
    
    $response->assertInertia(fn ($page) => 
        $page->component('Admin/Dashboard')
            ->has('stats')
            ->has('users')
    );
}
```

---

## 📈 Performance Optimization

### 1. Lazy Loading
```vue
<script setup lang="ts">
import { defineAsyncComponent } from 'vue';

const HeavyComponent = defineAsyncComponent(() => 
    import('./HeavyComponent.vue')
);
</script>
```

### 2. Partial Reloads
```typescript
router.reload({ 
    only: ['users'],  // Hanya reload data users
    preserveScroll: true,
    preserveState: true
});
```

### 3. Debounce Search
```vue
<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';

const search = ref('');

const debouncedSearch = useDebounceFn(() => {
    router.get('/admin/users', { search: search.value }, {
        preserveState: true,
        replace: true
    });
}, 300);

watch(search, debouncedSearch);
</script>
```

---

## 🚀 Langkah Selanjutnya

### Pilih Fitur untuk Dikembangkan:

1. **Admin Panel** - Mulai dengan user management
2. **Leave Management** - Sistem cuti/izin
3. **Analytics** - Dashboard analytics
4. **Geolocation** - Validasi lokasi

**Mau saya bantu develop fitur mana dulu?** 🎯

---

**Made with ❤️ using Laravel & Inertia.js**
