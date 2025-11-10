<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import  Option  from '@/Components/Dashboard/OptionMenu.vue'
import Modal from '@/Components/Dashboard/Modal.vue'

defineProps(['posts']);


const showModal = ref(false);
const selectedPerson = ref(null);

const openModal = (post) => {
  selectedPerson.value = post;
  showModal.value = true;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="  py-24 px-4 lg:px-16">
                        <div class="container mx-auto px-[12px] md:px-24 xl:px-12 max-w-[1300px] nanum2">
                            <!--<h1 class="text-center text-5xl pb-12">Industries we serve</h1>-->
                            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-x-4 gap-y-28 lg:gap-y-16">
                                <a  class="block"><Option>
                                    <template #img>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-full h-full">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                        </svg>
                                    </template>
                                    <template #opcion>Mensualidades</template>
                                </Option></a>
                                <a :href="route('posts.index')" class="block"><Option>
                                    <template #img>
                                        <img src="https://epicpadprinting.com/public/img/indus/Promotional.png"
                                                    class="w-36 h-36  mt-6 m-auto" alt="Promotional" title="Promotional" loading="lazy"
                                                    width="200" height="200">
                                    </template>
                                    <template #opcion>Comunicados</template>
                                </Option></a>
                                <a :href="route('estudiantes.index')" class="block"><Option>
                                    <template #img>
                                        <img src="https://epicpadprinting.com/public/img/indus/Stationery.png"
                                                    class="w-36 h-36  mt-6 m-auto" alt="Stationery" title="Stationery" loading="lazy"
                                                    width="200" height="200">
                                    </template>
                                    <template #opcion>Alumnos</template>
                                </Option></a>
                                <a :href="route('admin.index')" class="block"><Option>
                                    <template #img>
                                        <img src="https://epicpadprinting.com/public/img/indus/Tools.png"
                                                    class="w-36 h-36  mt-6 m-auto" alt="Tools" title="Tools" loading="lazy" width="200"
                                                    height="200">
                                    </template>
                                    <template #opcion>Configuración</template>
                                </Option></a>
                                <a :href="route('ppffs.index')" class="block"><Option>
                                    <template #img>
                                        <img src="https://epicpadprinting.com/public/img/indus/Promotional.png"
                                                    class="w-36 h-36  mt-6 m-auto" alt="Promotional" title="Promotional" loading="lazy"
                                                    width="200" height="200">
                                    </template>
                                    <template #opcion>PPFF</template>
                                </Option></a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="mt-3 p-2 text-gray-900 dark:text-gray-100 font-extrabold text-3xl text-center">Comunicados</div>
                    <div class="m-3 p-3 shadow-sm sm:rounded-lg bg-yellow">

                        <div class="my-2 p-2 shadow-sm sm:rounded-lg bg-pewter" v-for="post in posts" :key="post.id">
                            <div class="p-3 h-15 bg-bluegray font-extrabold text-2xl text-center" @click.prevent="openModal(post)">
                                {{ post.title }} {{ post.subtitle }}
                            </div>
                            <div>
                            <!--<ul>
                                  <li v-for="post in posts" :key="post.id">
                                    <a href="#" @click.prevent="openModal(post)">{{ post.title }}</a>
                                  </li>
                                </ul>-->
                                <Modal :isOpen="showModal" :post="selectedPerson" @close="showModal = false" />
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.bg-bluegray{
    --tw-bg-opacity: 1;
    background-color: #90adc6;
}
.bg-pewter{
    --tw-bg-opacity: 1;
    background-color: #e9eaec;
}
.bg-yellow{
    --tw-bg-opacity: 1;
    background-color: #fad02c;
}
.bg-darkblue{
    --tw-bg-opacity: 1;
    background-color: #333652;
}
</style>
