<script setup>
import { Head, usePage, Link, router } from '@inertiajs/vue3';
const props = defineProps({ stats: Object });
const page = usePage();
const t = (ar, fr) => page.props.locale === 'ar' ? ar : fr;
const logout = () => router.post('/logout');
</script>
<template>
  <Head title="Dashboard" />
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
      <div class="text-xl font-bold text-emerald-700">Jam3iyati</div>
      <div class="flex items-center gap-3">
        <span class="text-sm text-gray-600">{{ page.props.auth?.user?.name }}</span>
        <button @click="logout" class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200">{{ t('خروج','Déconnexion') }}</button>
      </div>
    </nav>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">{{ t('لوحة التحكم','Tableau de bord') }}</h1>
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('الأعضاء','Membres') }}</div><div class="text-3xl font-bold text-emerald-600">{{ stats.members }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('المداخيل','Revenus') }}</div><div class="text-3xl font-bold text-blue-600">{{ stats.income }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('المصاريف','Dépenses') }}</div><div class="text-3xl font-bold text-red-600">{{ stats.expenses }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('الرصيد','Solde') }}</div><div class="text-3xl font-bold text-purple-600">{{ stats.balance }}</div></div>
        <div class="bg-white rounded-xl p-5 shadow"><div class="text-gray-500 text-sm">{{ t('الاجتماعات','Réunions') }}</div><div class="text-3xl font-bold text-orange-600">{{ stats.meetings }}</div></div>
      </div>
    </div>
  </div>
</template>
