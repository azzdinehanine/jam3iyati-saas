<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ transaction: Object })
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">وصل رقم: {{ transaction.receipt_number }}</h1>
      <div class="flex gap-2">
        <a :href="`/transactions/${transaction.id}/pdf`" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded">طباعة</a>
        <Link href="/transactions" class="text-gray-700 px-4 py-2 hover:bg-gray-100 rounded">رجوع</Link>
      </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div><span class="text-gray-500">الفئة:</span> {{ transaction.category }}</div>
        <div><span class="text-gray-500">النوع:</span> {{ transaction.type === 'income' ? 'مدخول' : 'مصروف' }}</div>
        <div><span class="text-gray-500">المبلغ:</span> <strong>{{ Number(transaction.amount).toFixed(2) }} د.م</strong></div>
        <div><span class="text-gray-500">التاريخ:</span> {{ transaction.transaction_date }}</div>
        <div><span class="text-gray-500">طريقة الدفع:</span> {{ transaction.payment_method }}</div>
        <div><span class="text-gray-500">العضو:</span> {{ transaction.member ? transaction.member.first_name + ' ' + transaction.member.last_name : '-' }}</div>
        <div class="col-span-2"><span class="text-gray-500">الوصف:</span> {{ transaction.description || '-' }}</div>
      </div>
    </div>
  </AppLayout>
</template>
