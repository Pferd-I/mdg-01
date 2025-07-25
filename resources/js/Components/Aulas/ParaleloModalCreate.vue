<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['parClose','parCrear'])
const form = useForm({
    nombre_paralelo: '',
})
function crearParalelo() {
    form.post(route('paralelos.store'),{
        onSuccess: () => {
            emit('parClose')
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el nivel.");
        }
      });
};
</script>
<template>
    <div class="modal-overlay z-40">
        <div class="p-1 bg-darkblue rounded-md w-min">
            <div class="z-50" @click="$emit('parClose',false)">X</div>
            <div class="p-1 bg-pewter rounded-md">
                <div class="modal-content p-4 w-auto h-1/5 bg-darkblue">
                    <form @submit.prevent="crearParalelo" class="text-slate-900 overflow-hidden">
                        <div class="mt-1 w-fit font-bold">
                            <label class="text-pewter" for="nombre_paralelo">Paralelo: </label>
                            <input class="w-32" id="nombre_paralelo" type="text" v-model="form.nombre_paralelo">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Crear
                            </PrimaryButton>
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_paralelo" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
