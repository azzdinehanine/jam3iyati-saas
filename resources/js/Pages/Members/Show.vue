<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
defineProps({ member: Object })
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">{{ member.name }} {{ member.lastname }}</h1><div class="flex gap-2"><Link :href="`/members/${member.id}/edit`" class="bg-purple-600 text-white px-4 py-2 rounded">تعديل</Link><Link href="/members" class="px-4 py-2">رجوع</Link></div></div>
    <div class="bg-white rounded shadow p-6 grid grid-cols-2 gap-4 text-sm">
      <div><span class="text-gray-500">CIN:</span> {{ member.cin || '-' }}</div>
      <div><span class="text-gray-500">البريد:</span> {{ member.email || '-' }}</div>
      <div><span class="text-gray-500">الهاتف:</span> {{ member.phone || '-' }}</div>
      <div><span class="text-gray-500">تاريخ الازدياد:</span> {{ member.birthdate || '-' }}</div>
      <div><span class="text-gray-500">الجنس:</span> {{ member.gender === 'M' ? 'ذكر' : 'أنثى' }}</div>
      <div><span class="text-gray-500">تاريخ الانخراط:</span> {{ member.join_date }}</div>
      <div><span class="text-gray-500">الدور:</span> {{ member.role_in_assoc || '-' }}</div>
      <div><span class="text-gray-500">الحالة:</span> {{ member.status }}</div>
      <div class="col-span-2"><span class="text-gray-500">العنوان:</span> {{ member.address || '-' }}</div>
    </div>
  </AppLayout>
</template>
