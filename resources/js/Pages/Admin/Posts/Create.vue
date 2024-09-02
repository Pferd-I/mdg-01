<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputErrorL from '@/Components/InputErrorLightContainer.vue';

const form= useForm({
    title: "",
})
</script>

<template>
    <Head title="Nuevo Post" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1>Crear Nuevo Post</h1>
                        <Link :href="route('posts.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class="mt-6 mx-3 mb-3 bg-slate-400 p-2 rounded-md">
                        <form @submit.prevent="form.post(route('posts.store'))">
                            <div>
                                <InputLabel for="title" value="Título" class="dark:text-slate-900" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    autofocus
                                    autocomplete="title"
                                    oninvalid="this.setCustomValidity('Por favor ingrese el título del Post')"
                                    oninput="setCustomValidity('')"
                                />

                                <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.title" />
                            </div>
                            <div class="flex items-center mt-4">
                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Crear
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
