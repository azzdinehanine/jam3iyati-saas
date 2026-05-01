<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const form = useForm({ title: '', type: 'pv', description: '', reference_number: '', document_date: new Date().toISOString().slice(0,10) })
function submit() { form.post('/documents') }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">وثيقة جديدة</h1><Link href="/documents" class="text-gray-600">→ رجوع</Link></div>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">العنوان *</label><input v-model="form.title" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">النوع *</label><select v-model="form.type" class="w-full border rounded px-3 py-2"><option value="pv">محضر</option><option value="contract">عقد</option><option value="report">تقرير</option><option value="letter">رسالة</option><option value="other">أخرى</option></select></div>
        <div><label class="block text-sm mb-1">رقم المرجع</label><input v-model="form.reference_number" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">تاريخ الوثيقة</label><input v-model="form.document_date" type="date" class="w-full border rounded px-3 py-2" /></div>
      </div>
      <div><label class="block text-sm mb-1">الوصف</label><textarea v-model="form.description" rows="4" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2"><Link href="/documents" class="px-4 py-2">إلغاء</Link><button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button></div>
    </form>
  </AppLayout>
</template>
