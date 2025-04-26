<template>
  <div class="flex flex-col items-center justify-center gap-6 p-4">
    <Card class="w-full max-w-md text-center space-y-4">
      <CardContent class="p-6 flex flex-col items-center gap-4">
        <div class="flex justify-center items-center h-[300px]">
          <Button
            class="w-48 h-48 rounded-full text-white text-xl font-bold bg-red-600 hover:bg-red-700 shadow-lg transition"
            @click="callHelp">
            Call Help
          </Button>
        </div>

        <!-- MAP container (selalu dirender, hanya disembunyikan) -->
        <div v-show="location" ref="mapContainer" class="rounded-xl overflow-hidden w-full border shadow"
          style="height: 300px" />

        <div v-if="estimatedTime" class="text-base font-semibold text-green-600">
          ⏱️ Estimated arrival: <strong>{{ estimatedTime }} minute(s)</strong>
        </div>
      </CardContent>
    </Card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { router } from '@inertiajs/vue3';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import echo from '@/echo';

interface Location {
  latitude: number;
  longitude: number;
}

interface Emergency {
  eta?: number;
}

const location = ref<Location | null>(null);
const estimatedTime = ref<number | null>(null);
const map = ref<L.Map | null>(null);
const mapContainer = ref<HTMLElement | null>(null);

const props = defineProps<{
  emergency: Emergency;
}>();

echo.channel('emergency')
  .listen('EmergencyCalled', (e: any) => {
    estimatedTime.value = e.emergency.eta|0 || null;
  });

const callHelp = () => {
  if (!navigator.geolocation) {
    alert("Geolocation tidak didukung.");
    return;
  }

  navigator.geolocation.getCurrentPosition(
    async (pos) => {
      const { latitude, longitude } = pos.coords;
      location.value = { latitude, longitude };

      router.post('/emergency', {
        latitude,
        longitude,
      });

      await nextTick(); // pastikan elemen mapContainer sudah aktif
      if (!map.value && mapContainer.value) {
        map.value = L.map(mapContainer.value).setView([latitude, longitude], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map.value as L.Map);

        L.marker([latitude, longitude])
          .addTo(map.value as L.Map)
          .bindPopup('Lokasi Anda')
          .openPopup();
      }
    },
    () => alert("Gagal mendapatkan lokasi.")
  );
};
</script>