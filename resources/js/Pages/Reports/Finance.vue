<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
const props = defineProps({ transactions: Array })
const totalIncome = computed(() => props.transactions.filter(t => t.type === 'income').reduce((s, t) => s + Number(t.amount), 0))
const totalExpense = computed(() => props.transactions.filter(t => t.type === 'expense').reduce((s, t) => s + Number(t.amount), 0))
function printPage() { window.print() }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4 print:hidden"><h1 class="text-2xl font-bold">التقرير المالي</h1><div class="flex gap-2"><button @click="printPage" class="bg-blue-600 text-white px-4 py-2 rounded">🖨️ طباعة</button><Link href="/reports" class="px-4 py-2">رجوع</Link></div></div>
    <div class="bg-white rounded shadow p-6">
      <div class="grid grid-cols-3 gap-4 mb-4"><div class="bg-green-50 p-3 rounded"><p class="text-xs text-gray-600">إجمالي المداخيل</p><p class="text-2xl font-bold text-green-600">{{ totalIncome.toFixed(2) }} د.م</p></div><div class="bg-red-50 p-3 rounded"><p class="text-xs text-gray-600">إجمالي المصاريف</p><p class="text-2xl font-bold text-red-600">{{ totalExpense.toFixed(2) }} د.م</p></div><div class="bg-blue-50 p-3 rounded"><p class="text-xs text-gray-600">الرصيد الصافي</p><p class="text-2xl font-bold text-blue-600">{{ (totalIncome - totalExpense).toFixed(2) }} د.م</p></div></div>
      <table class="w-full text-sm border">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2 border">التاريخ</th><th class="px-2 py-2 border">الفئة</th><th class="px-2 py-2 border">الوصف</th><th class="px-2 py-2 border">العضو</th><th class="px-2 py-2 border">النوع</th><th class="px-2 py-2 border">المبلغ</th></tr></thead>
        <tbody>
          <tr v-for="t in transactions" :key="t.id" class="border-b"><td class="px-2 py-1 border text-xs">{{ t.transaction_date }}</td><td class="px-2 py-1 border">{{ t.category }}</td><td class="px-2 py-1 border">{{ t.description || '-' }}</td><td class="px-2 py-1 border text-xs">{{ t.member ? t.member.first_name + ' ' + t.member.last_name : '-' }}</td><td class="px-2 py-1 border">{{ t.type === 'income' ? 'مدخول' : 'مصروف' }}</td><td class="px-2 py-1 border font-bold" :class="t.type === 'income' ? 'text-green-600' : 'text-red-600'">{{ Number(t.amount).toFixed(2) }}</td></tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
