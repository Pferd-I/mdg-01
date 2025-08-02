<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/SecondaryButtonModal.vue';

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
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="guardarCambios">
                    <div class="w-fit font-bold text-pewter">
                        <label for="nombre_tipo_beca">Beca: </label>
                        <input id="nombre_tipo_beca" type="text" class="text-slate-900" v-model="form.nombre_tipo_beca">
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter flex">
                        <textarea id="descripcion" type="text" class="ml-1 text-slate-900 h-32 resize-none" v-model="form.descripcion"/>
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter flex">
                        <label for="dcto">Descuento: </label>
                        <input id="dcto" type="number" class="ml-1 w-40 text-slate-900" v-model="form.dcto"/>
                    </div>
                    <PrimaryButton type="submit" class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
