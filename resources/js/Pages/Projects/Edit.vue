<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ project: Object })
const isEdit = !!props.project
const form = useForm({
  name: props.project?.name || '', description: props.project?.description || '',
  budget: props.project?.budget || '', start_date: props.project?.start_date || new Date().toISOString().slice(0,10),
  end_date: props.project?.end_date || '', status: props.project?.status || 'planning', manager: props.project?.manager || '',
})
function submit() { isEdit ? form.put('/projects/' + props.project.id) : form.post('/projects') }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4"><h1 class="text-2xl font-bold">{{ isEdit ? 'تعديل' : 'جديد' }} - مشروع</h1><Link href="/projects" class="text-gray-600">→ رجوع</Link></div>
    <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm mb-1">الاسم *</label><input v-model="form.name" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">المسؤول</label><input v-model="form.manager" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الميزانية</label><input v-model="form.budget" type="number" step="0.01" class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الحالة</label><select v-model="form.status" class="w-full border rounded px-3 py-2"><option value="planning">تخطيط</option><option value="active">نشط</option><option value="completed">منجز</option><option value="cancelled">ملغى</option></select></div>
        <div><label class="block text-sm mb-1">تاريخ البداية *</label><input v-model="form.start_date" type="date" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">تاريخ النهاية</label><input v-model="form.end_date" type="date" class="w-full border rounded px-3 py-2" /></div>
      </div>
      <div><label class="block text-sm mb-1">الوصف</label><textarea v-model="form.description" rows="4" class="w-full border rounded px-3 py-2"></textarea></div>
      <div class="flex justify-end gap-2"><Link href="/projects" class="px-4 py-2">إلغاء</Link><button :disabled="form.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button></div>
    </form>
  </AppLayout>
</template>
