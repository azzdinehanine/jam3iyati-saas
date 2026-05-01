<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ member: Object })
const isEdit = !!props.member
const form = useForm({
  name: props.member?.name || '', lastname: props.member?.lastname || '',
  cin: props.member?.cin || '', email: props.member?.email || '', phone: props.member?.phone || '',
  birthdate: props.member?.birthdate || '', gender: props.member?.gender || 'M' ,
  address: props.member?.address || '', role_in_assoc: props.member?.role_in_assoc || '',
  status: props.member?.status || 'active', join_date: props.member?.join_date || new Date().toISOString().slice(0,10),
})
function submit() { isEdit ? form.put('/members/' + props.member.id) : form.post('/members') }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4"><h1 class="text-2xl font-bold">{{ isEdit ? 'تعديل العضو' : 'إضافة عضو' }}</h1><Link href="/members" class="text-gray-600">→ رجوع</Link></div>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">الاسم الأول *</label><input v-model="form.name" required class="w-full border rounded px-3 py-2" /><div v-if="form.errors.name" class="text-red-600 text-xs">{{ form.errors.name }}</div></div>
        <div><label class="block text-sm mb-1">الاسم العائلي *</label><input v-model="form.lastname" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">CIN</label><input v-model="form.cin" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">البريد</label><input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الهاتف</label><input v-model="form.phone" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">تاريخ الازدياد</label><input v-model="form.birthdate" type="date" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الجنس</label><select v-model="form.gender" class="w-full border rounded px-3 py-2"><option value="M">ذكر</option><option value="F">أنثى</option></select></div>
        <div><label class="block text-sm mb-1">تاريخ الانخراط *</label><input v-model="form.join_date" type="date" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الدور في الجمعية</label><input v-model="form.role_in_assoc" class="w-full border rounded px-3 py-2" placeholder="عضو / الرئيس / أمين المال..." /></div>
        <div><label class="block text-sm mb-1">الحالة</label><select v-model="form.status" class="w-full border rounded px-3 py-2"><option value="active">نشط</option><option value="inactive">غير نشط</option><option value="suspended">معلق</option></select></div>
      </div>
      <div><label class="block text-sm mb-1">العنوان</label><textarea v-model="form.address" rows="2" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2"><Link href="/members" class="px-4 py-2">إلغاء</Link><button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button></div>
    </form>
  </AppLayout>
</template>
