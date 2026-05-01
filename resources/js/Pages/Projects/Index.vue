<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
defineProps({ projects: Object })
function destroy(id) { if (confirm('حذف؟')) router.delete('/projects/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">المشاريع</h1><Link href="/projects/create" class="bg-purple-600 text-white px-4 py-2 rounded">+ مشروع جديد</Link></div>
    <div class="bg-white rounded shadow p-4">
      <table class="w-full text-sm"><thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">الاسم</th><th class="px-2 py-2">المسؤول</th><th class="px-2 py-2">الميزانية</th><th class="px-2 py-2">البداية</th><th class="px-2 py-2">النهاية</th><th class="px-2 py-2">الحالة</th><th class="px-2 py-2">إجراءات</th></tr></thead>
        <tbody>
          <tr v-for="p in projects.data" :key="p.id" class="border-b"><td class="px-2 py-2 font-medium">{{ p.name }}</td><td class="px-2 py-2">{{ p.manager || '-' }}</td><td class="px-2 py-2">{{ p.budget ? Number(p.budget).toFixed(2) : '-' }}</td><td class="px-2 py-2 text-xs">{{ p.start_date }}</td><td class="px-2 py-2 text-xs">{{ p.end_date || '-' }}</td><td class="px-2 py-2"><span class="px-2 py-1 text-xs rounded" :class="p.status === 'completed' ? 'bg-green-100 text-green-700' : p.status === 'active' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100'">{{ p.status }}</span></td>
            <td class="px-2 py-2 space-x-1 space-x-reverse"><Link :href="`/projects/${p.id}`" class="text-blue-600 text-xs">عرض</Link><Link :href="`/projects/${p.id}/edit`" class="text-purple-600 text-xs">تعديل</Link><button @click="destroy(p.id)" class="text-red-600 text-xs">حذف</button></td></tr>
          <tr v-if="!projects.data.length"><td colspan="7" class="text-center py-6 text-gray-400">لا توجد مشاريع</td></tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
