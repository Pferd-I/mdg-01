<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import SidebarLink from '@/Components/SidebarLink.vue'
import IconPapers from '@/Components/Subcomponents/IconPapers.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="w-full h-full -z-40">
        <aside class="ml-[-100%] fixed z-10 top-0 pb-3 px-6 w-full flex flex-col justify-between h-screen border-r bg-pewter transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]">
            <div>
                <div class="-mx-6 px-6 py-4 bg-white flex items-center">
                    <a href="#" title="home">
                        <img src="/images/logo.png" class="w-32" alt="tailus logo">
                    </a>
                </div>
                <ul class="space-y-2 tracking-wide mt-8 text-xl">
                    <li >
                        <SidebarLink
                            href="/dashboard"
                            :active="false">
                            <svg class="-ml-1 h-6 w-6" viewBox="0 0 24 24" fill="none">
                                <path d="M6 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8ZM6 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-1Z" class="fill-current text-cyan-400 dark:fill-slate-600"></path>
                                <path d="M13 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2V8Z" class="fill-current text-cyan-200 group-hover:text-cyan-300"></path>
                                <path d="M13 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-1Z" class="fill-current group-hover:text-sky-300"></path>
                            </svg>
                            <span class="-mr-1 font-medium">Dashboard</span>
                        </SidebarLink>
                    </li>
                    <li>
                        <SidebarLink
                            :href="route('kardex.index')"
                            :active="route().current('kardex.index')">
                            <IconPapers class="-ml-1 h-6 w-6"/>
                            <span class="-mr-1 font-medium">Kárdex</span>
                        </SidebarLink>
                    </li>
                    <li>
                        <SidebarLink
                            :href="route('reportes.asistencia')"
                            :active="route().current('reportes.asistencia')">
                            <IconPapers class="-ml-1 h-6 w-6"/>
                            <span>Reporte de Asistencia</span>
                        </SidebarLink>
                    </li>
                </ul>
            </div>

            <div class="px-6 -mx-6 pt-4 flex justify-between items-center border-t">
                <Link :href="route('logout')" method="post" as="button"
                class="px-4 py-3 flex items-center space-x-4 rounded-md text-gray-600 group hover:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="group-hover:text-red-400">Logout</span>
                </Link>
            </div>
        </aside>
        <div class="ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%] bg-bluegray">
            <div class="sticky z-10 top-0 h-16 border-b bg-yellow lg:py-2.5">
                <div class="px-6 flex items-center justify-between space-x-4 2xl:container">
                    <h5 hidden class="text-3xl text-gray-600 font-bold lg:block">Bienvenido, {{ $page.props.auth.user.name }}</h5>
                    <button class="w-12 h-16 -mr-2 border-r lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex space-x-4">
                        <button aria-label="chat" class=" font-bold px-4 h-10 rounded-xl border bg-darkblue-700 focus:bg-gray-100 active:bg-gray-200">
                            {{ $page.props.auth.user.name }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 pt-6 2xl:container">
                <slot/>
            </div>
        </div>
    </div>
</template>
