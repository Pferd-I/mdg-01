<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    paralelo: Object
});
const emit = defineEmits(['parClose','parCrear'])
const form = useForm({
    id:                 props.paralelo?.id,
    nombre_paralelo:    props.paralelo?.nombre_paralelo,
    estado:             props.paralelo?.estado,
})
function guardarCambios() {
    form.put(route('paralelos.update', form.id),{
        onSuccess: () => emit('parClose')
      });
};
function eliminar(){
    form.delete(route('paralelos.destroy', form.id));
    emit('parClose')
}
</script>
<template>
    <div class="modal-overlay z-40">
        <div class="p-1 bg-darkblue rounded-md w-min">
            <div class="z-50" @click="$emit('parClose',false)">X</div>
            <div class="p-1 bg-pewter rounded-md">
                <div class="modal-content p-4 w-auto h-1/5 bg-darkblue">
                    <form @submit.prevent="guardarCambios" class="text-slate-900 overflow-hidden">
                        <div class="mt-1 w-fit font-bold">
                            <div>
                                <label class="text-pewter" for="nombre_paralelo">Paralelo: </label>
                                <input class="w-32" id="nombre_paralelo" type="text" v-model="form.nombre_paralelo">
                            </div>
                            <div class="flex items-center">
                                <label for="nombre_paralelo" class="text-pewter mr-1">Estado: </label>
                                <div class="w-fit font-bold text-pewter">
                                    <div v-if="form.estado" class="bg-green-800">
                                        <p class="m-2">Activo</p>
                                    </div>
                                    <div v-else class=" bg-red-800">
                                        <p class="m-2">Inactivo</p>
                                    </div>
                                </div>
                            </div>
                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Actualizar
                            </PrimaryButton>
                            <input class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md
                                    font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    type="button" value="Eliminar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="eliminar">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_paralelo" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
