<script setup>
import {ref, watch, onBeforeUnmount, computed} from 'vue';
import { Head, Link, useForm, router, usePage} from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import PrimaryButton from '@/Components/PrimaryButtonModal.vue';
import Table from '@/Components/Table/Table.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableHeaderCell from '@/Components/Table/TableHeader.vue';
import TableDataCell from '@/Components/Table/TableDataCell.vue';
import Toast from '@/Components/AlertMessage.vue';

const props = defineProps({
    carga_academica: Array,
});

const fecha = ref(new Date().toISOString().split('T')[0]);
const estudiantes = ref([]);
const asistencias = ref({});
const obsGeneral = ref('');

const selectedCargaId = ref(null);
const selectedCarga = computed(() => {
  return props.carga_academica.find(c => c.id === selectedCargaId.value) || null;
});

watch(selectedCargaId, async (idCarga) => {
    if (!idCarga) {
        estudiantes.value = [];
        asistencias.value = {};
        return;
    }

    const carga = props.carga_academica.find(c => c.id === idCarga);
    if (!carga) return;

    const response = await fetch(route('asistencia.estudiantes', { curso: carga.id_curso }), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    const data = await response.json();
    estudiantes.value = data;

    asistencias.value = {};
    data.forEach(est => {
        asistencias.value[est.id] = { valor: 'Presente', observacion_individual: '' };
    });
});

function registrarAsistencia() {
    const carga = props.carga_academica.find(c => c.id === selectedCargaId.value);
    if (!carga) return;

    const payload = {
        id_curso: carga.id_curso,
        id_asignatura: carga.id_asignatura,
        fecha: fecha.value,
        observaciones: obsGeneral.value || null,
        estudiantes: estudiantes.value.map(est => {
            const asist = asistencias.value[est.id] || { valor: 'Presente', observacion_individual: '' };
            return {
                id: est.id,
                valor: asist.valor,
                observacion_individual: asist.observacion_individual,
            };
        })
        /*estudiantes: estudiantes.value.map(est => ({
            id: est.id,
            asistencia: asistencias.value[est.id]?.asistencia || 'Presente',
            observacion_individual: asistencias.value[est.id]?.observacion_individual || null,
        }))*/
    };

    router.post(route('asistencia.store'), payload);
}
//Mensaje flash
const page = usePage();
const flashMessage = ref(page.props.flash?.success || null);
watch(
  () => page.props.flash?.success,
  (val) => {
    flashMessage.value = val;
    if (val) {
      setTimeout(() => (flashMessage.value = null), 4000);
    }
  }
);
</script>

<template>
    <Head title="Asistencias" />

    <UserLayout>
        <Toast v-if="page.props.flash.error" :message="page.props.flash.error" type="error" />
        <Toast v-if="page.props.flash.success" :message="page.props.flash.success" type="success" />
        <div class="py-12 flex">
            <div class="mx-auto sm:px-2 lg:px-4 w-full flex">
                <div class="p-6 max-w-5xl m-auto bg-darkblue-700 rounded-md">
                    <h1 class="text-2xl font-bold mb-6">Registro de Asistencia</h1>
                    <div class="p-3 rounded-md bg-darkblue-800">
                    <!-- Selección de carga académica -->
                        <div class="mb-4">
                            <select v-model="selectedCargaId" class="select select-bordered rounded-md w-full bg-slate-700">
                            <option :value="null">-- Seleccione la clase--</option>
                            <option v-for="carga in carga_academica" :key="carga.id" :value="carga.id">
                                {{ carga.asignatura.nombre }} - {{ carga.curso.nro_grado }}° de {{ carga.curso.nivel.nombre_nivel }} "{{ carga.curso.paralelo.nombre_paralelo }}"
                            </option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2">Fecha de la clase:</label>
                            <input v-model="fecha" type="date" class="input input-bordered rounded-md w-full bg-slate-700" :max="new Date().toISOString().split('T')[0]" />
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2">Observaciones generales (opcional):</label>
                            <textarea v-model="obsGeneral" class="textarea textarea-bordered rounded-md w-full bg-slate-700 resize-none" rows="2"></textarea>
                        </div>

                    </div>
                </div>
                <div class="p-6 max-w-5xl m-auto bg-darkblue-700 rounded-md w-1/2">
                    <div class="mt-2 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-md w-auto h-min p-2">
                        <Table>
                            <template #header>
                                <TableRow>
                                    <TableHeaderCell class="border-r-2">Estudiante</TableHeaderCell>
                                    <TableHeaderCell>Asistencia</TableHeaderCell>
                                </TableRow>
                            </template>
                            <template #default>
                                <TableRow v-for="est in estudiantes"  :key="est.id" class="border-b">
                                    <TableDataCell>{{ est.apellido_p }} {{ est.apellido_m }} {{ est.nombres }}</TableDataCell>
                                    <TableDataCell>
                                        <div class="flex gap-2 items-center">
                                            <label class="flex items-center gap-1 cursor-pointer">
                                                <input class="radio radio-success" type="radio" :name="'asistencia_' + est.id" value="Presente"
                                                    v-model="asistencias[est.id].valor"/>
                                                <span class="text-xs">P</span>
                                            </label>
                                            <label class="flex items-center gap-1 cursor-pointer">
                                                <input class="radio radio-error" type="radio" :name="'asistencia_' + est.id" value="Ausente"
                                                    v-model="asistencias[est.id].valor"/>
                                                <span class="text-xs">F</span>
                                            </label>
                                            <label class="flex items-center gap-1 cursor-pointer">
                                                <input class="radio radio-warning" type="radio" :name="'asistencia_' + est.id" value="Atraso"
                                                    v-model="asistencias[est.id].valor"/>
                                                <span class="text-xs">A</span>
                                            </label>
                                            <label class="flex items-center gap-1 cursor-pointer">
                                                <input class="radio radio-info" type="radio" :name="'asistencia_' + est.id" value="Justificado"
                                                    v-model="asistencias[est.id].valor"/>
                                                <span class="text-xs">J</span>
                                            </label>
                                            <input class="input input-xs input-bordered w-28 ml-2 rounded-sm text-darkblue-800"
                                                v-if="['Atraso','Justificado'].includes(asistencias[est.id].valor)" type="text" placeholder="Motivo"
                                                v-model="asistencias[est.id].observacion_individual"/>
                                        </div>
                                    </TableDataCell>
                                </TableRow>
                            </template>
                        </Table>
                        <PrimaryButton
                        v-if="selectedCarga"
                        @click="registrarAsistencia"
                        class="mt-4"
                        :disabled="!fecha || estudiantes.length === 0"
                        >
                        Registrar Asistencia
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
