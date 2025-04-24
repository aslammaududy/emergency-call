<template>
    <Card class="w-full transition-all duration-300 hover:shadow-md">
      <CardHeader class="flex flex-row items-center justify-between pb-2">
        <CardTitle class="text-lg md:text-xl">Emergency</CardTitle>
        <div class="flex items-center gap-2">
          <span 
            class="inline-block h-2.5 w-2.5 rounded-full" 
            :class="getStatusDotColor(item.status)"
          ></span>
          <span 
            class="rounded-full px-3 py-1 text-xs font-medium"
            :class="getStatusColor(item.status)"
          >
            {{ item.status }}
          </span>
        </div>
      </CardHeader>
      <CardContent>
        <div class="flex flex-col space-y-2">
          <div class="flex items-center text-sm text-muted-foreground">
            <ClockIcon class="mr-1 h-4 w-4" />
            {{ formatRelativeTime(item.created_at) }}
          </div>
          <div class="flex items-center text-sm text-muted-foreground">
            <MapPinIcon class="mr-1 h-4 w-4" />
            Location: {{ item.latitude.toFixed(4) }}, {{ item.longitude.toFixed(4) }}
          </div>
        </div>
      </CardContent>
    </Card>
  </template>
  
  <script setup lang="ts">
  import { ClockIcon, MapPinIcon } from 'lucide-vue-next'
  import { formatRelativeTime, getStatusColor, getStatusDotColor } from '@/lib/utils'
  import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
  
  defineProps<{
    item: {
      id: number
      latitude: number
      longitude: number
      status: string
      created_at: string
      updated_at: string
    }
  }>()
  </script>