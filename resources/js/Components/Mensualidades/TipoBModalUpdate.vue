<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/SecondaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    'tipobeca':Object,
});
const emit = defineEmits(['close',]);
const form = useForm({
    id:                 props.tipobeca?.id,
    nombre_tipo_beca:   props.tipobeca?.nombre_tipo_beca,
    dcto:               props.tipobeca?.dcto,
    descripcion:        props.tipobeca?.descripcion,
    estado:             props.tipobeca?.estado,
})
function guardarCambios(){
    form.put(route('tipobecas.update', form.id),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al modificar el curso.");
        }
      });
}
function eliminar(){
    form.estado = !form.estado;
    guardarCambios();
}
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="guardarCambios">
                    <div class="w-fit font-bold text-pewter">
                        <label for="nombre_tipo_beca">Beca: </label>
                        <input id="nombre_tipo_beca" type="text" class="text-slate-900" v-model="form.nombre_tipo_beca">
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_tipo_beca"/>
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter flex">
                        <textarea id="descripcion" type="text" class="ml-1 text-slate-900 h-32 resize-none" v-model="form.descripcion"/>
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.descripcion"/>
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter flex">
                        <label for="dcto">Descuento: </label>
                        <input id="dcto" type="number" class="ml-1 w-40 text-slate-900" v-model="form.dcto"/>
                    </div>
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.dcto"/>
                    <div class="flex">
                        <PrimaryButton type="submit" class="mt-2" :class="{'opacity-25': form.processing}" :disabled="form.processing">
                            Actualizar
                        </PrimaryButton>
                        <div class="ml-3 mt-2 self-center w-fit font-bold text-pewter" @click="eliminar">
                            <div v-if="form.estado" class="bg-green-800">
                                <p class="m-2">Activo</p>
                            </div>
                            <div v-else class=" bg-red-800">
                                <p class="m-2">Inactivo</p>
                            </div>
                        </div>
                    </div>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
