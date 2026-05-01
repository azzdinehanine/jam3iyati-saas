<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
const props = defineProps({ transactions: Object, filters: Object, stats: Object })
const search = ref(props.filters?.search || '')
const type = ref(props.filters?.type || '')
let timer = null
watch([search, type], () => { clearTimeout(timer); timer = setTimeout(() => router.get('/transactions', { search: search.value, type: type.value }, { preserveState: true, replace: true }), 400) })
function destroy(id) { if (confirm('حذف؟')) router.delete('/transactions/' + id) }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">المعاملات المالية</h1>
      <Link href="/transactions/create" class="bg-purple-600 text-white px-4 py-2 rounded">+ عملية جديدة</Link>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-4">
      <div class="bg-white p-4 rounded shadow border-r-4 border-green-500"><p class="text-gray-500 text-sm">المداخيل</p><p class="text-2xl font-bold text-green-600">{{ Number(stats.income).toFixed(2) }} د.م</p></div>
      <div class="bg-white p-4 rounded shadow border-r-4 border-red-500"><p class="text-gray-500 text-sm">المصاريف</p><p class="text-2xl font-bold text-red-600">{{ Number(stats.expense).toFixed(2) }} د.م</p></div>
      <div class="bg-white p-4 rounded shadow border-r-4 border-blue-500"><p class="text-gray-500 text-sm">الرصيد</p><p class="text-2xl font-bold text-blue-600">{{ Number(stats.balance).toFixed(2) }} د.م</p></div>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="flex gap-3 mb-4">
        <input v-model="search" placeholder="بحث..." class="flex-1 border rounded px-3 py-2" />
        <select v-model="type" class="border rounded px-3 py-2"><option value="">الكل</option><option value="income">مداخيل</option><option value="expense">مصاريف</option></select>
      </div>
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">رقم الوصل</th><th class="px-2 py-2">الفئة</th><th class="px-2 py-2">النوع</th><th class="px-2 py-2">المبلغ</th><th class="px-2 py-2">التاريخ</th><th class="px-2 py-2">العضو</th><th class="px-2 py-2">إجراءات</th></tr></thead>
        <tbody>
          <tr v-for="t in transactions.data" :key="t.id" class="border-b hover:bg-gray-50">
            <td class="px-2 py-2 font-mono text-xs">{{ t.receipt_number }}</td>
            <td class="px-2 py-2">{{ t.category }}</td>
            <td class="px-2 py-2"><span class="px-2 py-1 text-xs rounded" :class="t.type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">{{ t.type === 'income' ? 'مدخول' : 'مصروف' }}</span></td>
            <td class="px-2 py-2 font-bold" :class="t.type === 'income' ? 'text-green-600' : 'text-red-600'">{{ Number(t.amount).toFixed(2) }}</td>
            <td class="px-2 py-2 text-xs">{{ t.transaction_date }}</td>
            <td class="px-2 py-2 text-xs">{{ t.member ? t.member.first_name + ' ' + t.member.last_name : '-' }}</td>
            <td class="px-2 py-2 space-x-1 space-x-reverse">
              <Link :href="`/transactions/${t.id}`" class="text-blue-600 text-xs">عرض</Link>
              <Link :href="`/transactions/${t.id}/edit`" class="text-purple-600 text-xs">تعديل</Link>
              <button @click="destroy(t.id)" class="text-red-600 text-xs">حذف</button>
            </td>
          </tr>
          <tr v-if="!transactions.data.length"><td colspan="7" class="text-center py-6 text-gray-400">لا توجد معاملات</td></tr>
        </tbody>
      </table>
      <div class="mt-4 flex flex-wrap gap-1">
        <Link v-for="link in transactions.links" :key="link.label" :href="link.url || '#'" v-html="link.label" class="px-3 py-1 text-sm border rounded" :class="link.active ? 'bg-purple-600 text-white' : 'bg-white'" />
      </div>
    </div>
  </AppLayout>
</template>
