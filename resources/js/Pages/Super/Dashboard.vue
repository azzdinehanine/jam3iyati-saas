<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
const props = defineProps({ stats: Object, tenants: Array });
const page = usePage();
const t = (ar, fr) => page.props.locale === 'ar' ? ar : fr;
const logout = () => router.post('/logout');
</script>
<template>
  <Head title="Super Admin" />
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-purple-700 text-white px-6 py-4 flex justify-between items-center">
      <div class="text-xl font-bold">Jam3iyati — Super Admin</div>
      <button @click="logout" class="px-3 py-1 bg-purple-900 rounded hover:bg-purple-800">{{ t('خروج','Déconnexion') }}</button>
    </nav>
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('الجمعيات','Associations') }}</div><div class="text-3xl font-bold text-purple-700">{{ stats.tenants }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('النشطة','Actives') }}</div><div class="text-3xl font-bold text-emerald-600">{{ stats.active }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('المستخدمون','Utilisateurs') }}</div><div class="text-3xl font-bold text-blue-600">{{ stats.users }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('الخطط','Plans') }}</div><div class="text-3xl font-bold text-orange-600">{{ stats.plans }}</div></div>
      </div>
      <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-lg font-semibold mb-4">{{ t('آخر الجمعيات','Dernières associations') }}</h2>
        <table class="w-full text-sm"><thead><tr class="text-gray-500 border-b"><th class="py-2 text-start">Name</th><th class="text-start">Plan</th><th class="text-start">Status</th></tr></thead>
        <tbody><tr v-for="t in tenants" :key="t.id" class="border-b"><td class="py-2">{{ t.name }}</td><td>{{ t.plan?.name }}</td><td><span :class="t.is_active?'text-emerald-600':'text-red-600'">{{ t.is_active ? '✓' : '✗' }}</span></td></tr></tbody></table>
      </div>
    </div>
  </div>
</template>
