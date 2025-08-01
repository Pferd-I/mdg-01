<script setup>
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Aulas/SubComponentes/ModalOverlay.vue';
import ButtonX from '@/Components/Aulas/SubComponentes/ModalOberlayXButton.vue';
import ModalContent from '@/Components/Aulas/SubComponentes/ModalContent.vue';
import ModalForm from '@/Components/Aulas/SubComponentes/ModalForm.vue';
import PrimaryButton from '@/Components/SecondaryButtonModal.vue';

const props = defineProps({
    curso: Object,
    niveles: Array,
    paralelos: Array,
});
const emit = defineEmits(['close']);
const form = useForm({
    id: props.curso?.id,
    grado: props.curso?.grado,
    nro_grado: props.curso?.nro_grado,
    id_nivel: props.curso?.id_nivel,
    id_paralelo: props.curso?.id_paralelo,
    gestion: props.curso?.gestion,
    estado: props.curso?.estado,
});
function guardarCambios(){
    form.put(route('cursos.update', form.id),{
        onSuccess: () => {
            emit('close')
        }, onError: () => {
            console.error("Ocurrió un error al modificar el curso.");
        }
      });
};
function eliminarCurso(){
    form.estado = !form.estado;
    guardarCambios();
}
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="guardarCambios">
                    <div class="flex">
                        <input class="w-32" id="grado" type="text" v-model="form.grado" placeholder="Curso">
                        <input class="ml-1 w-16" v-if="form.id_nivel != 1" id="nro_grado" type="text" v-model="form.nro_grado" placeholder="Nro">
                        <div class="ml-3 w-fit font-bold text-pewter" @click="eliminarCurso">
                            <div v-if="form.estado" class="bg-green-800">
                                <p class="m-2">Activo</p>
                            </div>
                            <div v-else class=" bg-red-800">
                                <p class="m-2">Inactivo</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 w-fit font-bold text-pewter flex">
                        <div class="mb-1">
                            <label for="nombre_paralelo">Paralelo: </label>
                            <select id="nombre_paralelo" v-model="form.id_paralelo" class="text-slate-900">
                                <option v-for="p in paralelos" :value="p.id">
                                    <p v-if="p.estado">{{ p.nombre_paralelo }}</p>
                                </option>
                            </select>
                        </div>
                        <div class="ml-2 mb-1">
                            <label for="nombre_nivel">Nivel: </label>
                            <select id="nombre_nivel" v-model="form.id_nivel" class="text-slate-900">
                                <option v-for="N in niveles" :value="N.id">
                                    <p v-if="N.estado == 1" >{{ N.nombre_nivel }}</p>
                                </option>
                            </select>
                        </div>
                    </div>
                        <label class="text-pewter" for="gestion">Gestión: </label>
                        <input class="w-32" id="gestion" type="number" v-model="form.gestion" placeholder="Gestión">
                    <PrimaryButton class="mt-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Actualizar
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
