<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ transaction: Object, members: Array })
const isEdit = !!props.transaction
const form = useForm({
  type: props.transaction?.type || 'income',
  category: props.transaction?.category || '',
  amount: props.transaction?.amount || '',
  description: props.transaction?.description || '',
  transaction_date: props.transaction?.transaction_date || new Date().toISOString().slice(0,10),
  member_id: props.transaction?.member_id || '',
  payment_method: props.transaction?.payment_method || 'cash',
  reference: props.transaction?.reference || '',
})
function submit() {
  if (isEdit) form.put('/transactions/' + props.transaction.id)
  else form.post('/transactions')
}
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">{{ isEdit ? 'تعديل عملية' : 'عملية جديدة' }}</h1>
      <Link href="/transactions" class="text-gray-600">→ رجوع</Link>
    </div>
    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">النوع</label>
          <select v-model="form.type" class="w-full border rounded px-3 py-2"><option value="income">مدخول</option><option value="expense">مصروف</option></select></div>
        <div><label class="block text-sm mb-1">الفئة *</label><input v-model="form.category" required class="w-full border rounded px-3 py-2" placeholder="اشتراك / تبرع / كراء..." /></div>
        <div><label class="block text-sm mb-1">المبلغ *</label><input v-model="form.amount" type="number" step="0.01" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">التاريخ *</label><input v-model="form.transaction_date" type="date" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">طريقة الدفع</label>
          <select v-model="form.payment_method" class="w-full border rounded px-3 py-2"><option value="cash">نقدا</option><option value="bank">بنك</option><option value="check">شيك</option><option value="transfer">تحويل</option></select></div>
        <div><label class="block text-sm mb-1">العضو (اختياري)</label>
          <select v-model="form.member_id" class="w-full border rounded px-3 py-2"><option value="">-</option><option v-for="m in members" :key="m.id" :value="m.id">{{ m.first_name }} {{ m.last_name }} ({{ m.member_code }})</option></select></div>
        <div><label class="block text-sm mb-1">المرجع</label><input v-model="form.reference" class="w-full border rounded px-3 py-2" /></div>
      </div>
      <div><label class="block text-sm mb-1">الوصف</label><textarea v-model="form.description" rows="3" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2">
        <Link href="/transactions" class="px-4 py-2 text-gray-700">إلغاء</Link>
        <button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button>
      </div>
    </form>
  </AppLayout>
</template>
