<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
const props = defineProps({ members: Array, plans: Array })
const form = useForm({ member_id: '', plan_id: '', amount: '', start_date: new Date().toISOString().slice(0,10), end_date: '', status: 'active', payment_method: 'cash', notes: '' })
watch(() => form.plan_id, (v) => {
  const p = props.plans.find(p => p.id == v)
  if (p) {
    form.amount = p.price
    const start = new Date(form.start_date)
    const months = p.duration_months || 12
    start.setMonth(start.getMonth() + months)
    form.end_date = start.toISOString().slice(0,10)
  }
})
function submit() { form.post('/subscriptions') }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">اشتراك جديد</h1><Link href="/subscriptions" class="text-gray-600">→ رجوع</Link>
    </div>
    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">العضو *</label>
          <select v-model="form.member_id" required class="w-full border rounded px-3 py-2"><option value="">-</option><option v-for="m in members" :key="m.id" :value="m.id">{{ m.first_name }} {{ m.last_name }}</option></select></div>
        <div><label class="block text-sm mb-1">الخطة *</label>
          <select v-model="form.plan_id" required class="w-full border rounded px-3 py-2"><option value="">-</option><option v-for="p in plans" :key="p.id" :value="p.id">{{ p.name_ar }} ({{ p.price }} د.م)</option></select></div>
        <div><label class="block text-sm mb-1">المبلغ *</label><input v-model="form.amount" type="number" step="0.01" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">طريقة الدفع</label>
          <select v-model="form.payment_method" class="w-full border rounded px-3 py-2"><option value="cash">نقدا</option><option value="bank">بنك</option><option value="check">شيك</option><option value="transfer">تحويل</option></select></div>
        <div><label class="block text-sm mb-1">تاريخ البداية *</label><input v-model="form.start_date" type="date" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">تاريخ النهاية *</label><input v-model="form.end_date" type="date" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الحالة</label>
          <select v-model="form.status" class="w-full border rounded px-3 py-2"><option value="active">نشط</option><option value="expired">منتهي</option><option value="cancelled">ملغى</option></select></div>
      </div>
      <div><label class="block text-sm mb-1">ملاحظات</label><textarea v-model="form.notes" rows="2" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2"><Link href="/subscriptions" class="px-4 py-2">إلغاء</Link><button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button></div>
    </form>
  </AppLayout>
</template>
