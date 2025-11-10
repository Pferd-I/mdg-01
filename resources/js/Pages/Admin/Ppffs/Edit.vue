<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputErrorL from '@/Components/InputErrorLightContainer.vue';

const props = defineProps({
    ppff: {
        type: Object,
        required: true,
    }
})

const form = useForm({
    cionit: props.ppff.cionit,
    nombre: props.ppff.nombre,
    contactos: props.ppff.contactos ?? []
});

//Contacto
const nuevoContacto = () => {
  form.contactos.push({ nro_telf: '', direccion: '' });
};
const removeContacto = (index) => {
  form.contactos.splice(index, 1);
};

// Guardar cambios
const submit = () => {
  form.put(route('ppffs.update', ppff.id));
};
</script>

<template>
    <Head title="Editar PPFF" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                        <h1 class="ml-3 text-2xl">Editar Datos de PPFF o Tutor</h1>
                        <Link :href="route('ppffs.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Volver</Link>
                    </div>
                    <div class="mt-6 mx-3 mb-3 bg-slate-400 p-2 rounded-md">
                        <form @submit.prevent="submit" class="space-y-6 bg-slate-800 p-6 rounded-lg shadow">

                            <!-- Datos del padre -->
                            <div class="flex">
                                <div class=" w-1/4">
                                    <label class="block text-sm font-medium text-gray-200">CI / NIT</label>
                                    <input v-model="form.cionit" type="text" class="w-full rounded p-2 text-black" />
                                </div>
                                <div class="mx-2 w-1/2">
                                <label class="block text-sm font-medium text-gray-200">Nombre</label>
                                <input v-model="form.nombre" type="text" class=" w-3/4 rounded p-2 text-black" />
                                </div>
                            </div>

                            <!-- Contactos -->
                            <div class="w-2/3">
                                <div class="flex justify-between items-center mb-2">
                                    <h2 class="text-lg font-semibold text-gray-100">Contactos</h2>
                                    <button type="button" @click="nuevoContacto"
                                    class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                    + Agregar contacto
                                    </button>
                                </div>

                                <div v-for="(contacto, index) in form.contactos" :key="index" class="flex gap-3 mb-3 items-center">
                                    <input v-model="contacto.tipo_contacto" type="text" placeholder="Correo electrónico" class="contactClass" />
                                    <input v-model="contacto.direccion" type="text" placeholder="Correo electrónico" class="contactClass" />
                                    <input v-model="contacto.nro_telf" type="text" placeholder="Teléfono" class="contactClass" />
                                    <button type="button" @click="removeContacto(index)" class="text-red-400 hover:text-red-600 text-xl font-bold"> × </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-800 text-white px-4 py-2 rounded-lg"
                                    :disabled="form.processing">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<style scope>
.contactClass{
    flex: 1 1 0%;
    border-radius: 0.25rem /* 4px */;
    padding: 0.5rem /* 8px */;
    --tw-text-opacity: 1;
    color: rgb(0 0 0 / var(--tw-text-opacity)) /* #000000 */;
}
</style>
