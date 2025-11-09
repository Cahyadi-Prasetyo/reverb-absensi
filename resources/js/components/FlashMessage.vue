<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { CheckCircle, XCircle, X } from 'lucide-vue-next';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref<'success' | 'error'>('success');

const showFlash = () => {
    const flash = page.props.flash as { success?: string; error?: string };
    
    if (flash.success) {
        message.value = flash.success;
        type.value = 'success';
        show.value = true;
        autoHide();
    } else if (flash.error) {
        message.value = flash.error;
        type.value = 'error';
        show.value = true;
        autoHide();
    }
};

const autoHide = () => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
};

const close = () => {
    show.value = false;
};

watch(() => page.props.flash, showFlash, { deep: true });

onMounted(showFlash);
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="translate-y-2 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-2 opacity-0"
    >
        <div
            v-if="show"
            :class="[
                type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200',
                'fixed top-4 right-4 z-50 flex items-center gap-3 rounded-lg border px-4 py-3 shadow-lg max-w-md',
            ]"
        >
            <component
                :is="type === 'success' ? CheckCircle : XCircle"
                :class="[
                    type === 'success' ? 'text-green-600' : 'text-red-600',
                    'h-5 w-5 flex-shrink-0',
                ]"
            />
            <p
                :class="[
                    type === 'success' ? 'text-green-800' : 'text-red-800',
                    'text-sm font-medium flex-1',
                ]"
            >
                {{ message }}
            </p>
            <button
                @click="close"
                :class="[
                    type === 'success'
                        ? 'text-green-600 hover:text-green-800'
                        : 'text-red-600 hover:text-red-800',
                    'flex-shrink-0',
                ]"
            >
                <X class="h-5 w-5" />
            </button>
        </div>
    </Transition>
</template>
