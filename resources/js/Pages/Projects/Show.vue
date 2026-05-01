<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ project: Object })
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">{{ project.name }}</h1><Link href="/projects" class="text-gray-700">→ رجوع</Link></div>
    <div class="bg-white rounded shadow p-6 grid grid-cols-2 gap-4 text-sm">
      <div><span class="text-gray-500">المسؤول:</span> {{ project.manager || '-' }}</div>
      <div><span class="text-gray-500">الميزانية:</span> {{ project.budget || '-' }}</div>
      <div><span class="text-gray-500">البداية:</span> {{ project.start_date }}</div>
      <div><span class="text-gray-500">النهاية:</span> {{ project.end_date || '-' }}</div>
      <div><span class="text-gray-500">الحالة:</span> {{ project.status }}</div>
      <div class="col-span-2"><span class="text-gray-500">الوصف:</span> {{ project.description || '-' }}</div>
    </div>
  </AppLayout>
</template>
