<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['close',]);
const form = useForm({
    id:               '',
    nombre_tipo_beca: '',
    dcto:             0,
    descripcion:      '',
})
function crearBeca(){
    form.post(route('tipobecas.store'),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al crear la beca.");
        }
      });
}
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="crearBeca">
                    <div class="w-fit font-bold text-pewter">
                        <label for="nombre_tipo_beca">Beca: </label>
                        <input id="nombre_tipo_beca" type="text" class="text-slate-900" v-model="form.nombre_tipo_beca">
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_tipo_beca"/>
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter flex">
                        <textarea id="descripcion" type="text" class="ml-1 text-slate-900 h-32 resize-none" v-model="form.descripcion" placeholder="Escribe alguna descripción."/>
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.descripcion"/>
                    </div>
                    <div class="ml-1 mt-2 w-fit font-bold text-pewter flex">
                        <label for="dcto">Descuento:</label>
                        <input id="dcto" type="number" class="ml-1 w-28 text-slate-900" v-model="form.dcto"/>
                    </div>
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.dcto"/>
                    <PrimaryButton type="submit" class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
