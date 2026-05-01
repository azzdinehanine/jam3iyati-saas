<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
const props = defineProps({ user: Object })
const profileForm = useForm({ first_name: props.user.first_name, last_name: props.user.last_name, email: props.user.email, phone: props.user.phone || '' })
const pwdForm = useForm({ current_password: '', password: '', password_confirmation: '' })
function updateProfile() { profileForm.patch('/profile') }
function updatePassword() { pwdForm.patch('/profile/password', { onSuccess: () => pwdForm.reset() }) }
</script>
<template>
  <AppLayout>
    <h1 class="text-2xl font-bold mb-4">الملف الشخصي</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <form @submit.prevent="updateProfile" class="bg-white rounded shadow p-6 space-y-3">
        <h3 class="font-bold border-b pb-2">المعلومات الشخصية</h3>
        <div><label class="block text-sm mb-1">الاسم الأول</label><input v-model="profileForm.first_name" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الاسم العائلي</label><input v-model="profileForm.last_name" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">البريد الإلكتروني</label><input v-model="profileForm.email" type="email" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">الهاتف</label><input v-model="profileForm.phone" class="w-full border rounded px-3 py-2" /></div>
        <button :disabled="profileForm.processing" class="bg-purple-600 text-white px-6 py-2 rounded">حفظ</button>
      </form>
      <form @submit.prevent="updatePassword" class="bg-white rounded shadow p-6 space-y-3">
        <h3 class="font-bold border-b pb-2">تغيير كلمة المرور</h3>
        <div><label class="block text-sm mb-1">الكلمة الحالية</label><input v-model="pwdForm.current_password" type="password" required class="w-full border rounded px-3 py-2" /><div v-if="pwdForm.errors.current_password" class="text-red-600 text-xs">{{ pwdForm.errors.current_password }}</div></div>
        <div><label class="block text-sm mb-1">الكلمة الجديدة</label><input v-model="pwdForm.password" type="password" required class="w-full border rounded px-3 py-2" /></div>
        <div><label class="block text-sm mb-1">تأكيد الكلمة</label><input v-model="pwdForm.password_confirmation" type="password" required class="w-full border rounded px-3 py-2" /></div>
        <button :disabled="pwdForm.processing" class="bg-purple-600 text-white px-6 py-2 rounded">تغيير</button>
      </form>
    </div>
  </AppLayout>
</template>
