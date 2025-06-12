<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputErrorL from '@/Components/InputErrorLightContainer.vue';

const form= useForm({
    cionit: "",
    nombre: "",
    direccion: "",
    telf: "",
})
</script>

<template>
    <Head title="Registro de PPFF" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 pt-4 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 text-2xl">Registrar Padre de Familia o Tutor</h1>
                        <Link :href="route('ppffs.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class="mt-4 mx-3 mb-3 bg-slate-400 p-2 rounded-md">
                        <form @submit.prevent="form.post(route('ppffs.store'))" class=" px-4">
                            <div class="flex flex-wrap">
                                <!--Ci o NIT-->
                                <div class="mr-4 mt-2">
                                    <InputLabel for="cionit" value="CI/NIT:" class="dark:text-slate-900 *:text-lg" />
                                    <TextInput
                                        id="cionit" type="text" class="mt-1 block w-48"
                                        v-model="form.cionit" autofocus autocomplete="cionit"
                                        oninvalid="this.setCustomValidity('Por favor ingrese el CI o NIT')"
                                        oninput="setCustomValidity('')"/>
                                    <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.cionit" />
                                </div>
                                <!--Nombre-->
                                <div class="mt-2">
                                    <InputLabel for="nombre" value="Nombre:" class="dark:text-slate-900 *:text-lg" />
                                    <TextInput
                                        id="nombre" type="text" class="mt-1 block w-96"
                                        v-model="form.nombre" autofocus autocomplete="nombre"
                                        oninvalid="this.setCustomValidity('Por favor ingrese el nombre')"
                                        oninput="setCustomValidity('')"/>
                                    <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.nombre" />
                                </div>
                                <!--Dirección-->
                                <div class="mr-4 mt-2">
                                    <InputLabel for="direccion" value="Direccion:" class="dark:text-slate-900 *:text-lg" />
                                    <TextInput
                                        id="direccion" type="text" class="mt-1 block w-96"
                                        v-model="form.direccion" autofocus autocomplete="direccion"
                                        oninvalid="this.setCustomValidity('Por favor ingrese la dirección')"
                                        oninput="setCustomValidity('')"/>
                                    <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.direccion" />
                                </div>
                                <!--Teléfono-->
                                <div class="mt-2">
                                    <InputLabel for="telf" value="Nro. de Contacto:" class="dark:text-slate-900 *:text-lg" />
                                    <TextInput
                                        id="telf" type="text" class="mt-1 block w-52"
                                        v-model="form.telf" autofocus autocomplete="telf"
                                        oninvalid="this.setCustomValidity('Por favor ingrese el nro. de contacto')"
                                        oninput="setCustomValidity('')"/>
                                    <InputErrorL class="mt-2 dark:text-slate-950 dark:text-bold" :message="form.errors.telf" />
                                </div>
                            </div>
                            <div class="flex items-center mt-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
