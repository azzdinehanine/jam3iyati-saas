<script setup>
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ plans: Array })
const form = useForm({ association_name: '', admin_first_name: '', admin_last_name: '', admin_email: '', admin_password: '', admin_password_confirmation: '', admin_phone: '', plan_id: props.plans[0]?.id || '' })
function submit() { form.post('/register') }
</script>
<template>
  <div dir="rtl" class="min-h-screen bg-gradient-to-br from-purple-100 to-purple-300 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl">
      <h1 class="text-3xl font-bold text-center text-purple-800 mb-2">جمعيتي</h1>
      <p class="text-center text-gray-600 mb-6">إنشاء حساب جديد لجمعيتك</p>
      <form @submit.prevent="submit" class="space-y-4">
        <div><label class="block text-sm font-medium mb-1">اسم الجمعية *</label><input v-model="form.association_name" required class="w-full border rounded-lg px-4 py-2" /><div v-if="form.errors.association_name" class="text-red-600 text-xs">{{ form.errors.association_name }}</div></div>
        <div class="grid grid-cols-2 gap-3">
          <div><label class="block text-sm font-medium mb-1">اسم المسير *</label><input v-model="form.admin_first_name" required class="w-full border rounded-lg px-4 py-2" /></div>
          <div><label class="block text-sm font-medium mb-1">اللقب *</label><input v-model="form.admin_last_name" required class="w-full border rounded-lg px-4 py-2" /></div>
        </div>
        <div><label class="block text-sm font-medium mb-1">البريد الإلكتروني *</label><input v-model="form.admin_email" type="email" required class="w-full border rounded-lg px-4 py-2" /><div v-if="form.errors.admin_email" class="text-red-600 text-xs">{{ form.errors.admin_email }}</div></div>
        <div><label class="block text-sm font-medium mb-1">الهاتف</label><input v-model="form.admin_phone" class="w-full border rounded-lg px-4 py-2" /></div>
        <div class="grid grid-cols-2 gap-3">
          <div><label class="block text-sm font-medium mb-1">كلمة المرور *</label><input v-model="form.admin_password" type="password" required class="w-full border rounded-lg px-4 py-2" /><div v-if="form.errors.admin_password" class="text-red-600 text-xs">{{ form.errors.admin_password }}</div></div>
          <div><label class="block text-sm font-medium mb-1">تأكيد *</label><input v-model="form.admin_password_confirmation" type="password" required class="w-full border rounded-lg px-4 py-2" /></div>
        </div>
        <div><label class="block text-sm font-medium mb-2">اختر الخطة *</label>
          <div class="grid grid-cols-2 gap-3">
            <label v-for="p in plans" :key="p.id" class="border-2 rounded-lg p-3 cursor-pointer hover:bg-purple-50" :class="form.plan_id == p.id ? 'border-purple-600 bg-purple-50' : 'border-gray-200'">
              <input type="radio" v-model="form.plan_id" :value="p.id" class="sr-only" />
              <div class="font-bold">{{ p.name_ar }}</div>
              <div class="text-2xl font-bold text-purple-700">{{ p.price }} د.م</div>
              <div class="text-xs text-gray-500">/ {{ p.duration_months }} أشهر</div>
              <div class="text-xs mt-1">{{ p.max_members }} عضو كحد أقصى</div>
            </label>
          </div>
        </div>
        <button type="submit" :disabled="form.processing" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg">{{ form.processing ? '...' : 'إنشاء الحساب' }}</button>
        <p class="text-center text-sm">لديك حساب بالفعل؟ <Link href="/login" class="text-purple-600 hover:underline">تسجيل دخول</Link></p>
      </form>
    </div>
  </div>
</template>
