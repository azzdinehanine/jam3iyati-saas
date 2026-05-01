<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ stats: Object, recent_members: Array, recent_transactions: Array })
</script>
<template>
  <AppLayout>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">لوحة التحكم</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-white p-5 rounded-lg shadow border-r-4 border-purple-500">
        <p class="text-gray-500 text-sm">إجمالي الأعضاء</p>
        <p class="text-3xl font-bold text-purple-700">{{ stats.members_total }}</p>
        <p class="text-xs text-gray-400 mt-1">نشطين: {{ stats.members_active }}</p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border-r-4 border-green-500">
        <p class="text-gray-500 text-sm">المداخيل</p>
        <p class="text-3xl font-bold text-green-600">{{ Number(stats.income_total).toFixed(2) }}</p>
        <p class="text-xs text-gray-400 mt-1">د.م</p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border-r-4 border-red-500">
        <p class="text-gray-500 text-sm">المصاريف</p>
        <p class="text-3xl font-bold text-red-600">{{ Number(stats.expense_total).toFixed(2) }}</p>
        <p class="text-xs text-gray-400 mt-1">د.م</p>
      </div>
      <div class="bg-white p-5 rounded-lg shadow border-r-4 border-blue-500">
        <p class="text-gray-500 text-sm">الرصيد</p>
        <p class="text-3xl font-bold" :class="stats.balance >= 0 ? 'text-blue-600' : 'text-red-600'">{{ Number(stats.balance).toFixed(2) }}</p>
        <p class="text-xs text-gray-400 mt-1">د.م</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500 text-sm">الاجتماعات</p>
        <p class="text-2xl font-bold">{{ stats.meetings_count }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500 text-sm">مشاريع نشطة</p>
        <p class="text-2xl font-bold">{{ stats.projects_active }}</p>
      </div>
      <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500 text-sm">اشتراكات نشطة</p>
        <p class="text-2xl font-bold">{{ stats.subscriptions_active }}</p>
      </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b flex justify-between">
          <h3 class="font-bold">أحدث الأعضاء</h3>
          <Link href="/members" class="text-sm text-purple-600 hover:underline">عرض الكل</Link>
        </div>
        <table class="w-full text-sm">
          <tbody>
            <tr v-for="m in recent_members" :key="m.id" class="border-b">
              <td class="px-4 py-2">{{ m.first_name }} {{ m.last_name }}</td>
              <td class="px-4 py-2 text-gray-500">{{ m.member_code }}</td>
              <td class="px-4 py-2"><span class="px-2 py-1 text-xs rounded" :class="m.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'">{{ m.status }}</span></td>
            </tr>
            <tr v-if="!recent_members?.length"><td class="px-4 py-4 text-gray-400 text-center">لا يوجد أعضاء بعد</td></tr>
          </tbody>
        </table>
      </div>
      <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b flex justify-between">
          <h3 class="font-bold">أحدث المعاملات</h3>
          <Link href="/transactions" class="text-sm text-purple-600 hover:underline">عرض الكل</Link>
        </div>
        <table class="w-full text-sm">
          <tbody>
            <tr v-for="t in recent_transactions" :key="t.id" class="border-b">
              <td class="px-4 py-2">{{ t.category }}</td>
              <td class="px-4 py-2" :class="t.type === 'income' ? 'text-green-600' : 'text-red-600'">{{ t.type === 'income' ? '+' : '-' }}{{ Number(t.amount).toFixed(2) }}</td>
              <td class="px-4 py-2 text-gray-500 text-xs">{{ t.transaction_date }}</td>
            </tr>
            <tr v-if="!recent_transactions?.length"><td class="px-4 py-4 text-gray-400 text-center">لا توجد معاملات بعد</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
