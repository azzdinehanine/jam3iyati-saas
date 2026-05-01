<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ stats: Object, monthlyIncome: Object, monthlyExpense: Object })
const months = ['يناير','فبراير','مارس','أبريل','ماي','يونيو','يوليوز','غشت','شتنبر','أكتوبر','نونبر','دجنبر']
</script>
<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-6">التقارير</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">الأعضاء الإجمالي</p><p class="text-3xl font-bold text-purple-600">{{ stats.members.total }}</p><p class="text-xs">نشط: {{ stats.members.active }} | غير نشط: {{ stats.members.inactive }}</p></div>
      <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">الرصيد الصافي</p><p class="text-3xl font-bold text-blue-600">{{ Number(stats.finance.income - stats.finance.expense).toFixed(2) }} د.م</p><p class="text-xs">دخل: {{ Number(stats.finance.income).toFixed(2) }} | صرف: {{ Number(stats.finance.expense).toFixed(2) }}</p></div>
      <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">الاجتماعات</p><p class="text-3xl font-bold text-orange-600">{{ stats.meetings.total }}</p><p class="text-xs">منجز: {{ stats.meetings.completed }}</p></div>
      <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">المشاريع</p><p class="text-3xl font-bold text-green-600">{{ stats.projects.total }}</p><p class="text-xs">نشط: {{ stats.projects.active }} | منجز: {{ stats.projects.completed }}</p></div>
    </div>
    <div class="bg-white rounded shadow p-6 mb-6">
      <h3 class="font-bold mb-4">تحليل مالي شهري ({{ new Date().getFullYear() }})</h3>
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">الشهر</th><th class="px-2 py-2">المداخيل</th><th class="px-2 py-2">المصاريف</th><th class="px-2 py-2">الصافي</th></tr></thead>
        <tbody>
          <tr v-for="(m, i) in months" :key="i" class="border-b">
            <td class="px-2 py-2">{{ m }}</td>
            <td class="px-2 py-2 text-green-600">{{ Number(monthlyIncome[String(i+1).padStart(2,'0')] || 0).toFixed(2) }}</td>
            <td class="px-2 py-2 text-red-600">{{ Number(monthlyExpense[String(i+1).padStart(2,'0')] || 0).toFixed(2) }}</td>
            <td class="px-2 py-2 font-bold">{{ (Number(monthlyIncome[String(i+1).padStart(2,'0')] || 0) - Number(monthlyExpense[String(i+1).padStart(2,'0')] || 0)).toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <Link href="/reports/members" class="bg-white rounded shadow p-6 hover:bg-purple-50"><h3 class="font-bold text-lg">📖 تقرير الأعضاء</h3><p class="text-sm text-gray-500 mt-2">لائحة تفصيلية بكل الأعضاء</p></Link>
      <Link href="/reports/finance" class="bg-white rounded shadow p-6 hover:bg-purple-50"><h3 class="font-bold text-lg">💰 التقرير المالي</h3><p class="text-sm text-gray-500 mt-2">كل العمليات المالية</p></Link>
    </div>
  </AppLayout>
</template>
