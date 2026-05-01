<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
defineProps({ documents: Object })
function destroy(id) { if (confirm('حذف؟')) router.delete('/documents/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">الوثائق</h1><Link href="/documents/create" class="bg-purple-600 text-white px-4 py-2 rounded">+ وثيقة جديدة</Link></div>
    <div class="bg-white rounded shadow p-4">
      <table class="w-full text-sm"><thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">العنوان</th><th class="px-2 py-2">النوع</th><th class="px-2 py-2">الرقم</th><th class="px-2 py-2">التاريخ</th><th class="px-2 py-2">حذف</th></tr></thead>
        <tbody>
          <tr v-for="d in documents.data" :key="d.id" class="border-b"><td class="px-2 py-2">{{ d.title }}</td><td class="px-2 py-2">{{ d.type }}</td><td class="px-2 py-2 text-xs font-mono">{{ d.reference_number }}</td><td class="px-2 py-2 text-xs">{{ d.document_date }}</td><td class="px-2 py-2"><button @click="destroy(d.id)" class="text-red-600 text-xs">حذف</button></td></tr>
          <tr v-if="!documents.data.length"><td colspan="5" class="text-center py-6 text-gray-400">لا توجد وثائق</td></tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
