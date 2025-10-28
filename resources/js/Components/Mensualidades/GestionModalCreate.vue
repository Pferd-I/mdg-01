<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalForm.vue';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';

const emit = defineEmits(['close',]);
const form = useForm({
    gestion: '',
    monto: 500.00,
})
function crearGestion(){
    form.get(route('gestion.mensualidades.create'),{
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
                <modal-form @submit.prevent="crearGestion">
                    <div class="w-fit font-bold text-pewter">
                        <label for="gestion">Gestión: </label>
                        <input id="gestion" type="text" class="text-slate-900" v-model="form.gestion" placeholder="Año">
                        <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.gestion"/>
                    </div>
                    <div class="mt-2 w-fit font-bold text-pewter">
                        <label for="monto">Monto: </label>
                        <input id="monto" type="number" class="ml-2 w-28 text-slate-900" v-model="form.monto">
                    </div>
                    <PrimaryButton type="submit" class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
