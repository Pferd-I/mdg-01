<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3';
import ModalOverlay from '@/Components/Subcomponents/ModalOverlay.vue';
import ButtonX from '@/Components/Subcomponents/ModalOberlayXButton.vue';
import ModalContent from '@/Components/Subcomponents/ModalContent.vue';
import ModalForm from '@/Components/Subcomponents/ModalFormOverfVis.vue'
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import InputError from '@/Components/InputError.vue';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

const emit = defineEmits(['close'])
const props = defineProps({
  tipos_beca: Array,
  cursos: Array,
});
const form = useForm({
    ci: '',
    rude: '',
    apellido_p: '',
    apellido_m: '',
    nombres: '',
    id_curso: 1,
    id_tipo_beca: 1,
})

//Seleccionar Curso
const selectedCurso = ref(props.cursos.length ? props.cursos[0] : null);
watch(selectedCurso, (nuevo) => {
  form.id_curso = nuevo ? nuevo.id : ''
});

//Seleccionar Beca
const selectedBeca = ref(props.tipos_beca.length ? props.tipos_beca[0] : null);
watch(selectedBeca, (nuevo) => {
  form.id_tipo_beca = nuevo ? nuevo.id : ''
});

function crearEstudiante() {
    form.post(route('estudiantes.store'), {
        onSuccess: () => {
            emit('close')
            form.reset()
        },
        onError: () => {
            console.error('Ocurrió un error al crear el estudiante.')
        }
    })
};
</script>
<template>
    <modal-overlay @cerrar="$emit('close')">
        <modal-content>
            <template #default>
                <modal-form @submit.prevent="crearEstudiante">
                    <div class="flex">
                        <div class="w-fit font-bold text-pewter">
                            <label for="ci">CI: </label>
                            <input id="ci" type="text" class="inputs" v-model="form.ci">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.ci"/>
                        </div><pre>  </pre>
                        <div class="w-fit font-bold text-pewter">
                            <label for="rude">RUDE: </label>
                            <input id="rude" type="text" class="inputs" v-model="form.rude">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.rude"/>
                        </div>
                    </div>
                    <div class="flex py-2">
                        <div class="w-fit font-bold text-pewter">
                            <label for="apellido_p">Estudiante: </label>
                            <input id="apellido_p" type="text" class="inputs" v-model="form.apellido_p" placeholder="Apellido Paterno">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.apellido_p"/>
                        </div><pre> </pre>
                        <div class="w-fit font-bold text-pewter">
                            <label for="apellido_m"></label>
                            <input id="apellido_m" type="text" class="inputs" v-model="form.apellido_m" placeholder="Apellido Materno">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.apellido_m"/>
                        </div><pre> </pre>
                        <div class="w-fit font-bold text-pewter">
                            <label for="nombres"></label>
                            <input id="nombres" type="text" class="inputs" v-model="form.nombres" placeholder="Nombres">
                            <InputError class="mt-2 text-red-600 dark:text-bold" :message="form.errors.nombres"/>
                        </div>
                    </div>
                    <div class="flex">
                        <!--Cursos-->
                        <div class="flex p-2 w-1/3">
                            <div class="w-full font-bold text-pewter">
                                <label>Curso: </label>
                                <Multiselect
                                    v-model="selectedCurso" :options="cursos"
                                    placeholder="Seleccionar curso..." class="w-60"
                                >
                                    <template #option="{ option }">
                                        <template v-if="['Inicial'].includes(option.nivel.nombre_nivel)">
                                            {{ option.nro_grado }} de {{ option.nivel.nombre_nivel }} '{{ option.paralelo.nombre_paralelo}}'
                                        </template>
                                        <template v-else>{{ option.nro_grado }}º de {{ option.nivel.nombre_nivel }} '{{ option.paralelo.nombre_paralelo}}'</template>
                                    </template>
                                    <template #singleLabel="{ option }">
                                        {{ option.nro_grado }} de {{ option.nivel.nombre_nivel }} '{{ option.paralelo.nombre_paralelo}}'
                                    </template>
                                </Multiselect>
                            </div>
                        </div>
                        <!--Tipos de Beca-->
                        <div class="flex p-2 w-1/3">
                            <div class="w-full font-bold text-pewter">
                                <label>Becas: </label>
                                <Multiselect
                                    v-model="selectedBeca" :options="tipos_beca"
                                    label="nombre_tipo_beca" track-by="id"
                                    placeholder="Seleccionar beca..." class="w-60"
                                >
                                </Multiselect>
                            </div>
                        </div>
                    </div>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear
                    </PrimaryButton>
                </modal-form>
            </template>
        </modal-content>
    </modal-overlay>
</template>
<style scoped>
.inputs{
    --tw-text-opacity: 1;
    color: rgb(15 23 42 / var(--tw-text-opacity)) /* #0f172a */;
    border-radius: 0.375rem /* 6px */;
}
</style>
