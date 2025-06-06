<template>
  <Card class="w-full transition-all duration-300 hover:shadow-md">
    <CardHeader class="flex flex-row items-center justify-between pb-2">
      <CardTitle class="text-lg md:text-xl">Emergency # {{ item.id }}</CardTitle>
      <div class="flex items-center gap-2">
        <span class="inline-block h-2.5 w-2.5 rounded-full" :class="getStatusDotColor(item.status)"></span>
        <span class="rounded-full px-3 py-1 text-xs font-medium" :class="getStatusColor(item.status)">
          {{ item.status }}
        </span>
      </div>
    </CardHeader>
    <CardContent>
      <div class="flex flex-row items-center justify-between pb-2">
        <div class="flex flex-col space-y-2">
          <div class="flex items-center text-sm text-muted-foreground">
            <ClockIcon class="mr-1 h-4 w-4" />
            {{ formatRelativeTime(item.created_at) }}
          </div>
          <div class="flex items-center text-sm text-muted-foreground">
            <MapPinIcon class="mr-1 h-4 w-4" />
            Location: {{ item.latitude.toFixed(4) }}, {{ item.longitude.toFixed(4) }}
            <span class="ms-2">Est: {{ item.eta }} minute(s)</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <Button v-if="item.status == 'waiting'" @click="act('dispatched')"
            class="rounded px-5 py-1 bg-amber-100 text-amber-800 border-amber-300">
            Dispatch
          </Button>
          <Button v-if="item.status == 'dispatched'" @click="act('completed')"
            class="rounded px-5 py-1 bg-green-100 text-green-800 border-green-300">
            Complete
          </Button>
        </div>
      </div>
      <hr>
      <div class="flex flex-row items-center py-2">
        <div ref="mapContainer" class="rounded-xl overflow-hidden w-full border shadow"
        style="height: 300px" />
      </div>
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { ClockIcon, MapPinIcon } from 'lucide-vue-next'
import { formatRelativeTime, getStatusColor, getStatusDotColor } from '@/lib/utils'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { router } from '@inertiajs/vue3';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { ref } from 'vue';

const location = ref(null);
const estimatedTime = ref(null);
const map = ref<L.Map | null>(null);
const mapContainer = ref(null);

const props = defineProps<{
  item: {
    id: number
    latitude: number
    longitude: number
    status: string
    eta: number
    created_at: string
    updated_at: string
  }
}>()

function act(status: string) {
  router.patch('/emergency-response/' + props.item.id, {
    status: status
  })
}

import { onMounted, nextTick } from 'vue';

onMounted(() => {
  nextTick(() => {
    if (mapContainer.value) {
      map.value = L.map(mapContainer.value).setView([props.item.latitude, props.item.longitude], 16);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
      }).addTo(map.value as L.Map);

      L.marker([props.item.latitude, props.item.longitude])
        .addTo(map.value as L.Map)
        .bindPopup('Lokasi Anda')
        .openPopup();
    }
  });
});
</script>