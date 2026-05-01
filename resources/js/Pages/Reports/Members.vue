<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ members: Array })
function printPage() { window.print() }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4 print:hidden"><h1 class="text-2xl font-bold">تقرير الأعضاء</h1><div class="flex gap-2"><button @click="printPage" class="bg-blue-600 text-white px-4 py-2 rounded">🖨️ طباعة</button><Link href="/reports" class="px-4 py-2">رجوع</Link></div></div>
    <div class="bg-white rounded shadow p-6">
      <h2 class="text-xl font-bold text-center mb-4">لائحة الأعضاء ({{ members.length }})</h2>
      <table class="w-full text-sm border">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2 border">#</th><th class="px-2 py-2 border">الرمز</th><th class="px-2 py-2 border">الاسم</th><th class="px-2 py-2 border">الهاتف</th><th class="px-2 py-2 border">الانخراط</th><th class="px-2 py-2 border">الحالة</th></tr></thead>
        <tbody>
          <tr v-for="(m, i) in members" :key="m.id" class="border-b">
            <td class="px-2 py-1 border">{{ i+1 }}</td><td class="px-2 py-1 border font-mono text-xs">{{ m.member_code }}</td><td class="px-2 py-1 border">{{ m.first_name }} {{ m.last_name }}</td><td class="px-2 py-1 border">{{ m.phone || '-' }}</td><td class="px-2 py-1 border text-xs">{{ m.join_date }}</td><td class="px-2 py-1 border">{{ m.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
