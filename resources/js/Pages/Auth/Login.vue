<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
const page = usePage();
const form = useForm({ email: '', password: '', serial_code: '' });
const submit = () => form.post(route('login'));
const switchLocale = (locale) => window.location.href = `/locale/${locale}`;
</script>
<template>
  <Head title="Login" />
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-100 p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
      <div class="flex justify-end gap-2 mb-4">
        <button @click="switchLocale('ar')" class="px-3 py-1 text-sm rounded border" :class="page.props.locale === 'ar' ? 'bg-emerald-600 text-white' : ''">العربية</button>
        <button @click="switchLocale('fr')" class="px-3 py-1 text-sm rounded border" :class="page.props.locale === 'fr' ? 'bg-emerald-600 text-white' : ''">Français</button>
      </div>
      <h1 class="text-3xl font-bold text-center text-emerald-700 mb-2">Jam3iyati</h1>
      <p class="text-center text-gray-500 mb-6">{{ page.props.locale === 'ar' ? 'نظام تسيير الجمعيات' : 'Gestion des associations' }}</p>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input v-model="form.email" type="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500" />
          <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">{{ page.props.locale === 'ar' ? 'كلمة المرور' : 'Mot de passe' }}</label>
          <input v-model="form.password" type="password" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">{{ page.props.locale === 'ar' ? 'الرمز التسلسلي (اختياري للسوبر أدمن)' : 'Code série (optionnel pour SuperAdmin)' }}</label>
          <input v-model="form.serial_code" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500" />
          <div v-if="form.errors.serial_code" class="text-red-600 text-sm mt-1">{{ form.errors.serial_code }}</div>
        </div>
        <button type="submit" :disabled="form.processing" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition">
          {{ page.props.locale === 'ar' ? 'تسجيل الدخول' : 'Se connecter' }}
        </button>
      </form>
    </div>
  </div>
</template>
