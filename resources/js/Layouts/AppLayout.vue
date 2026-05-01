<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
const page = usePage()
const user = computed(() => page.props.auth?.user)
const flash = computed(() => page.props.flash || {})
const sidebarOpen = ref(true)
const nav = [
  { name: 'لوحة التحكم', href: '/dashboard', icon: '⌂' },
  { name: 'الأعضاء', href: '/members', icon: '人' },
  { name: 'المعاملات المالية', href: '/transactions', icon: '₣' },
  { name: 'الاشتراكات', href: '/subscriptions', icon: '★' },
  { name: 'الاجتماعات', href: '/meetings', icon: '✎' },
  { name: 'المشاريع', href: '/projects', icon: '⚒' },
  { name: 'الوثائق', href: '/documents', icon: '☰' },
  { name: 'التقارير', href: '/reports', icon: '▤' },
]
function logout() { router.post('/logout') }
</script>
<template>
  <div dir="rtl" class="min-h-screen bg-gray-50">
    <!-- Top navbar -->
    <nav class="bg-purple-700 text-white shadow-md">
      <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center gap-3">
          <button @click="sidebarOpen = !sidebarOpen" class="text-2xl hover:bg-purple-800 px-2 rounded">☰</button>
          <Link href="/dashboard" class="text-xl font-bold">جمعيتي</Link>
        </div>
        <div class="flex items-center gap-4">
          <Link href="/profile" class="hover:underline">{{ user?.first_name }} {{ user?.last_name }}</Link>
          <button @click="logout" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">خروج</button>
        </div>
      </div>
    </nav>
    <div class="flex">
      <!-- Sidebar -->
      <aside v-if="sidebarOpen" class="w-64 bg-white shadow-md min-h-screen">
        <nav class="p-4 space-y-1">
          <Link v-for="item in nav" :key="item.href" :href="item.href"
            class="flex items-center gap-3 px-3 py-2 rounded text-gray-700 hover:bg-purple-50 hover:text-purple-700">
            <span class="text-lg">{{ item.icon }}</span>
            <span>{{ item.name }}</span>
          </Link>
        </nav>
      </aside>
      <!-- Main content -->
      <main class="flex-1 p-6">
        <div v-if="flash.success" class="mb-4 bg-green-100 border-r-4 border-green-500 text-green-800 p-3 rounded">{{ flash.success }}</div>
        <div v-if="flash.error" class="mb-4 bg-red-100 border-r-4 border-red-500 text-red-800 p-3 rounded">{{ flash.error }}</div>
        <slot />
      </main>
    </div>
  </div>
</template>
