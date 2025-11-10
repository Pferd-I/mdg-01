<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ButtonX from '@/Components/Subcomponents/ModalOberlayXButton.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue'
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['close'])
const form = useForm({
    nombre_paralelo: '',
})
function crearParalelo() {
    form.post(route('paralelos.store'),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al actualizar el nivel.");
        }
      });
};
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="crearParalelo">
                    <label class="text-pewter" for="nombre_paralelo">Paralelo: </label>
                    <input class="w-32" id="nombre_paralelo" type="text" v-model="form.nombre_paralelo">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear
                    </PrimaryButton>
                    <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_paralelo" />
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
