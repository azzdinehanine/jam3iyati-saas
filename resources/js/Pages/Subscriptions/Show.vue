<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ subscription: Object })
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">تفاصيل الاشتراك</h1><Link href="/subscriptions" class="text-gray-700">→ رجوع</Link></div>
    <div class="bg-white rounded shadow p-6 grid grid-cols-2 gap-4 text-sm">
      <div><span class="text-gray-500">العضو:</span> {{ subscription.member?.first_name }} {{ subscription.member?.last_name }}</div>
      <div><span class="text-gray-500">الخطة:</span> {{ subscription.plan?.name_ar }}</div>
      <div><span class="text-gray-500">المبلغ:</span> {{ Number(subscription.amount).toFixed(2) }}</div>
      <div><span class="text-gray-500">الحالة:</span> {{ subscription.status }}</div>
      <div><span class="text-gray-500">البداية:</span> {{ subscription.start_date }}</div>
      <div><span class="text-gray-500">النهاية:</span> {{ subscription.end_date }}</div>
    </div>
  </AppLayout>
</template>
