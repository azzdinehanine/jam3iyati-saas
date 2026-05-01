<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ meeting: Object })
const isEdit = !!props.meeting
const form = useForm({
  title: props.meeting?.title || '', type: props.meeting?.type || 'board',
  meeting_date: props.meeting?.meeting_date || new Date().toISOString().slice(0,16),
  location: props.meeting?.location || '', agenda: props.meeting?.agenda || '',
  minutes: props.meeting?.minutes || '', status: props.meeting?.status || 'scheduled',
})
function submit() { isEdit ? form.put('/meetings/' + props.meeting.id) : form.post('/meetings') }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">{{ isEdit ? 'تعديل' : 'جديد' }} - اجتماع</h1><Link href="/meetings" class="text-gray-600">→ رجوع</Link></div>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">العنوان *</label><input v-model="form.title" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">النوع</label><select v-model="form.type" class="w-full border rounded px-3 py-2"><option value="general_assembly">جمع عام</option><option value="board">مكتب مسير</option><option value="committee">لجنة</option><option value="other">أخرى</option></select></div>
        <div><label class="block text-sm mb-1">التاريخ *</label><input v-model="form.meeting_date" type="datetime-local" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">المكان</label><input v-model="form.location" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الحالة</label><select v-model="form.status" class="w-full border rounded px-3 py-2"><option value="scheduled">مجدول</option><option value="completed">منجز</option><option value="cancelled">ملغى</option></select></div>
      </div>
      <div><label class="block text-sm mb-1">جدول الأعمال</label><textarea v-model="form.agenda" rows="3" class="w-full border rounded px-3 py-2"></textarea></div>
      <div><label class="block text-sm mb-1">محضر الاجتماع</label><textarea v-model="form.minutes" rows="5" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2"><Link href="/meetings" class="px-4 py-2">إلغاء</Link><button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button></div>
    </form>
  </AppLayout>
</template>
