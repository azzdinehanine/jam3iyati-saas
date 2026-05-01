<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
defineProps({ meetings: Object })
function destroy(id) { if (confirm('حذف؟')) router.delete('/meetings/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">الاجتماعات</h1><Link href="/meetings/create" class="bg-purple-600 text-white px-4 py-2 rounded">+ اجتماع جديد</Link></div>
    <div class="bg-white rounded shadow p-4">
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">العنوان</th><th class="px-2 py-2">النوع</th><th class="px-2 py-2">التاريخ</th><th class="px-2 py-2">المكان</th><th class="px-2 py-2">الحالة</th><th class="px-2 py-2">إجراءات</th></tr></thead>
        <tbody>
          <tr v-for="m in meetings.data" :key="m.id" class="border-b hover:bg-gray-50">
            <td class="px-2 py-2 font-medium">{{ m.title }}</td><td class="px-2 py-2">{{ m.type }}</td><td class="px-2 py-2">{{ m.meeting_date }}</td><td class="px-2 py-2">{{ m.location || '-' }}</td>
            <td class="px-2 py-2"><span class="px-2 py-1 text-xs rounded" :class="m.status === 'completed' ? 'bg-green-100 text-green-700' : m.status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'">{{ m.status }}</span></td>
            <td class="px-2 py-2 space-x-1 space-x-reverse">
              <Link :href="`/meetings/${m.id}`" class="text-blue-600 text-xs">عرض</Link>
              <Link :href="`/meetings/${m.id}/edit`" class="text-purple-600 text-xs">تعديل</Link>
              <button @click="destroy(m.id)" class="text-red-600 text-xs">حذف</button>
            </td>
          </tr>
          <tr v-if="!meetings.data.length"><td colspan="6" class="text-center py-6 text-gray-400">لا توجد اجتماعات</td></tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
