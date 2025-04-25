<script setup lang="ts">

import { ref, computed } from 'vue'
import StatusCard from '@/components/StatusCard.vue'
import Echo from '@/echo';

const statuses = ['waiting', 'dispatched', 'completed']
const currentFilter = ref('all')

const props = defineProps({
    emergencies: {
        type: Array as () => Array<{
            id: number;
            status: string;
            latitude: number;
            longitude: number;
            created_at: string;
            updated_at: string
        }>,
        default: () => []
    }
})

const filteredItems = computed(() => {
    if (currentFilter.value === 'all') {
        return props.emergencies
    }
    return props.emergencies.filter(item => item.status === currentFilter.value)
})

Echo.channel('emergency')
    .listen('EmergencyCalled', (e) => {
        const index = props.emergencies.findIndex(item => item.id === e.emergency.id)
        if (index !== -1) {
            props.emergencies[index] = e.emergency
        } else {
            props.emergencies.unshift(e.emergency)
        }
    })
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
        <div class="mx-auto max-w-3xl">
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Emergency Status Tracker</h1>
                <p class="mt-2 text-gray-600">Track the status of emergency in real-time</p>
            </header>

            <div class="mb-6 flex flex-wrap gap-3">
                <button @click="currentFilter = 'all'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition-colors" :class="currentFilter === 'all'
                        ? 'bg-secondary text-secondary-foreground'
                        : 'bg-primary text-primary-foreground hover:bg-primary/80'">
                    All Emergencies
                </button>
                <button v-for="status in statuses" :key="status" @click="currentFilter = status"
                    class="rounded-full px-4 py-2 text-sm font-medium transition-colors" :class="currentFilter === status
                        ? 'bg-secondary text-secondary-foreground'
                        : 'bg-primary text-primary-foreground hover:bg-primary/80'">
                    {{ status.charAt(0).toUpperCase() + status.slice(1) }}
                </button>
            </div>

            <div class="space-y-4">
                <StatusCard v-for="item in filteredItems" :key="item.id" :item="item"
                    class="transform transition-all duration-300 hover:translate-y-[-2px]" />
            </div>

            <div v-if="filteredItems.length === 0" class="mt-8 text-center">
                <p class="text-lg text-gray-500">No deliveries found with the selected status.</p>
            </div>
        </div>
    </div>
</template>