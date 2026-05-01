<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
defineProps({ subscriptions: Object, filters: Object })
function destroy(id) { if (confirm('حذف؟')) router.delete('/subscriptions/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">الاشتراكات</h1>
      <Link href="/subscriptions/create" class="bg-purple-600 text-white px-4 py-2 rounded">+ اشتراك جديد</Link>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">العضو</th><th class="px-2 py-2">الخطة</th><th class="px-2 py-2">المبلغ</th><th class="px-2 py-2">البداية</th><th class="px-2 py-2">النهاية</th><th class="px-2 py-2">الحالة</th><th class="px-2 py-2">إجراءات</th></tr></thead>
        <tbody>
          <tr v-for="s in subscriptions.data" :key="s.id" class="border-b">
            <td class="px-2 py-2">{{ s.member?.first_name }} {{ s.member?.last_name }}</td>
            <td class="px-2 py-2">{{ s.plan?.name_ar }}</td>
            <td class="px-2 py-2 font-bold">{{ Number(s.amount).toFixed(2) }}</td>
            <td class="px-2 py-2 text-xs">{{ s.start_date }}</td>
            <td class="px-2 py-2 text-xs">{{ s.end_date }}</td>
            <td class="px-2 py-2"><span class="px-2 py-1 text-xs rounded" :class="s.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100'">{{ s.status }}</span></td>
            <td class="px-2 py-2"><button @click="destroy(s.id)" class="text-red-600 text-xs">حذف</button></td>
          </tr>
          <tr v-if="!subscriptions.data.length"><td colspan="7" class="text-center py-6 text-gray-400">لا توجد اشتراكات</td></tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
