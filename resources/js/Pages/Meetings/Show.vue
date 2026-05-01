<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
const props = defineProps({ meeting: Object, allMembers: Array })
function mark(memberId, status) { router.post(`/meetings/${props.meeting.id}/attend`, { member_id: memberId, status }) }
function getStatus(memberId) { const a = props.meeting.attendances?.find(a => a.member_id === memberId); return a?.status }
</script>
<template>
  <AppLayout>
    <div class="flex justify-between mb-4">
      <h1 class="text-2xl font-bold">{{ meeting.title }}</h1>
      <div class="flex gap-2"><Link :href="`/meetings/${meeting.id}/edit`" class="bg-purple-600 text-white px-4 py-2 rounded">تعديل</Link><Link href="/meetings" class="px-4 py-2">رجوع</Link></div>
    </div>
    <div class="bg-white rounded shadow p-6 mb-4">
      <div class="grid grid-cols-2 gap-4 text-sm mb-4"><div><span class="text-gray-500">النوع:</span> {{ meeting.type }}</div><div><span class="text-gray-500">التاريخ:</span> {{ meeting.meeting_date }}</div><div><span class="text-gray-500">المكان:</span> {{ meeting.location || '-' }}</div><div><span class="text-gray-500">الحالة:</span> {{ meeting.status }}</div></div>
      <div class="mb-3"><h3 class="font-bold mb-1">جدول الأعمال</h3><p class="text-sm whitespace-pre-line">{{ meeting.agenda || '-' }}</p></div>
      <div><h3 class="font-bold mb-1">المحضر</h3><p class="text-sm whitespace-pre-line">{{ meeting.minutes || '-' }}</p></div>
    </div>
    <div class="bg-white rounded shadow p-6">
      <h3 class="font-bold mb-3">لائحة الحضور</h3>
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-right"><tr><th class="px-2 py-2">العضو</th><th class="px-2 py-2">الحالة</th><th class="px-2 py-2">تغيير</th></tr></thead>
        <tbody>
          <tr v-for="m in allMembers" :key="m.id" class="border-b">
            <td class="px-2 py-2">{{ m.first_name }} {{ m.last_name }}</td>
            <td class="px-2 py-2"><span class="px-2 py-1 text-xs rounded" :class="getStatus(m.id) === 'present' ? 'bg-green-100 text-green-700' : getStatus(m.id) === 'absent' ? 'bg-red-100 text-red-700' : 'bg-gray-100'">{{ getStatus(m.id) || 'غير محدد' }}</span></td>
            <td class="px-2 py-2 space-x-1 space-x-reverse">
              <button @click="mark(m.id, 'present')" class="px-2 py-1 text-xs bg-green-600 text-white rounded">حاضر</button>
              <button @click="mark(m.id, 'absent')" class="px-2 py-1 text-xs bg-red-600 text-white rounded">غائب</button>
              <button @click="mark(m.id, 'excused')" class="px-2 py-1 text-xs bg-yellow-600 text-white rounded">معتذر</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
