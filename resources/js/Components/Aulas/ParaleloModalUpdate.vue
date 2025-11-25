<script setup>
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/SecondaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';
import btnDelete from '@/Components/Aulas/SubComponentes/btnDelete.vue';

const props = defineProps({
    paralelo: Object
});
const emit = defineEmits(['close'])
const form = useForm({
    id:                 props.paralelo?.id,
    nombre_paralelo:    props.paralelo?.nombre_paralelo,
    estado:             props.paralelo?.estado,
})
function guardarCambios() {
    form.put(route('paralelos.update', form.id),{
        onSuccess: () => emit('close')
      });
};
function eliminar(){
    form.estado = !form.estado;
    guardarCambios();
    //emit('parClose');
}
</script>
<template>
    <div class="modal-overlay z-40" @click.self="$emit('close')">
        <div class="p-1 bg-darkblue rounded-md w-min">
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
                            <btnDelete  :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="eliminar"/>
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombre_paralelo" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }
</style>
