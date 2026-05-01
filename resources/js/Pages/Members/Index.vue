<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
const props = defineProps({ members: Object, filters: Object })
const search = ref(props.filters?.search || '')
const status = ref(props.filters?.status || '')
let timer = null
watch([search, status], () => {
  clearTimeout(timer)
  timer = setTimeout(() => router.get('/members', { search: search.value, status: status.value }, { preserveState: true, replace: true }), 400)
})
function destroy(id) { if (confirm('حذف؟')) router.delete('/members/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">الأعضاء</h1>
      <Link href="/members/create" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">+ إضافة عضو</Link>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="flex gap-3 mb-4">
        <input v-model="search" type="text" placeholder="بحث..." class="flex-1 border rounded px-3 py-2" />
        <select v-model="status" class="border rounded px-3 py-2">
          <option value="">كل الحالات</option>
          <option value="active">نشط</option><option value="inactive">غير نشط</option><option value="suspended">معلق</option>
        </select>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-3 py-2">CIN</th><th class="px-3 py-2">الاسم</th><th class="px-3 py-2">الهاتف</th><th class="px-3 py-2">الدور</th><th class="px-3 py-2">الحالة</th><th class="px-3 py-2">إجراءات</th></tr></thead>
        <tbody>
          <tr v-for="m in members.data" :key="m.id" class="border-b hover:bg-gray-50">
            <td class="px-3 py-2 font-mono text-xs">{{ m.cin || '-' }}</td>
            <td class="px-3 py-2 font-medium">{{ m.name }} {{ m.lastname }}</td>
            <td class="px-3 py-2">{{ m.phone || '-' }}</td>
            <td class="px-3 py-2">{{ m.role_in_assoc || '-' }}</td>
            <td class="px-3 py-2"><span class="px-2 py-1 text-xs rounded" :class="m.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'">{{ m.status }}</span></td>
            <td class="px-3 py-2 space-x-1 space-x-reverse">
              <Link :href="`/members/${m.id}`" class="text-blue-600 hover:underline text-xs">عرض</Link>
              <Link :href="`/members/${m.id}/edit`" class="text-purple-600 hover:underline text-xs">تعديل</Link>
              <button @click="destroy(m.id)" class="text-red-600 hover:underline text-xs">حذف</button>
            </td>
          </tr>
          <tr v-if="!members.data.length"><td colspan="6" class="text-center py-6 text-gray-400">لا توجد نتائج</td></tr>
        </tbody>
      </table>
      <div class="mt-4 flex flex-wrap gap-1">
        <Link v-for="link in members.links" :key="link.label" :href="link.url || '#'" v-html="link.label" class="px-3 py-1 text-sm border rounded" :class="link.active ? 'bg-purple-600 text-white' : 'bg-white text-gray-700'" />
      </div>
    </div>
  </AppLayout>
</template>
