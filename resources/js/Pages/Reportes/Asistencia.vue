<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    detalles: Object,
    estudiantes: Array,
    cursos: Array,
    asignaturas: Array,
    filtros: Object,
});

const form = ref({
    estudiante_id: props.filtros.estudiante_id || '',
    curso_id: props.filtros.curso_id || '',
    asignatura_id: props.filtros.asignatura_id || '',
    fecha_desde: props.filtros.fecha_desde || '',
    fecha_hasta: props.filtros.fecha_hasta || '',
    valor: props.filtros.valor || '',
});

function aplicarFiltros() {
    router.get(route('reportes.asistencia'), form.value, {
        preserveState: true,
        replace: true,
    });
}

function limpiarFiltros() {
    form.value = {
        estudiante_id: '',
        curso_id: '',
        asignatura_id: '',
        fecha_desde: '',
        fecha_hasta: '',
        valor: '',
    };
    aplicarFiltros();
}
</script>

<template>
  <UserLayout>
    <div class="py-12 flex">
            <div class="mx-auto sm:px-2 lg:px-4 w-full flex">
                <div class="p-6 max-w-5xl m-auto bg-darkblue-700 rounded-md">
                    <h1 class="text-2xl font-bold mb-6">Reporte de Asistencia</h1>
                    <div class="p-3 rounded-md bg-darkblue-800">
                        <!-- Filtros -->
                         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium">Estudiante</label>
                                <select v-model="form.estudiante_id" class="select select-bordered selectReporte">
                                    <option value="">Todos</option>
                                    <option v-for="est in estudiantes" :key="est.id" :value="est.id">
                                        {{ est.nombre_completo }}
                                    </option>
                                </select>
                            </div>
                            <div>
          <label class="block text-sm font-medium">Curso</label>
          <select v-model="form.curso_id" class="select select-bordered selectReporte">
            <option value="">Todos</option>
            <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
              {{ curso.nombre }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Asignatura</label>
          <select v-model="form.asignatura_id" class="select select-bordered selectReporte">
            <option value="">Todas</option>
            <option v-for="asig in asignaturas" :key="asig.id" :value="asig.id">
              {{ asig.nombre }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Asistencia</label>
          <select v-model="form.valor" class="select select-bordered selectReporte">
            <option value="">Todos</option>
            <option value="Presente">Presente</option>
            <option value="Ausente">Ausente</option>
            <option value="Atraso">Atraso</option>
            <option value="Justificado">Justificado</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium">Fecha desde</label>
          <input v-model="form.fecha_desde" type="date" class="input input-bordered selectReporte" />
        </div>
        <div>
          <label class="block text-sm font-medium">Fecha hasta</label>
          <input v-model="form.fecha_hasta" type="date" class="input input-bordered selectReporte" />
        </div>

        <div class="flex items-end space-x-2">
          <PrimaryButton @click="aplicarFiltros">Filtrar</PrimaryButton>
          <button @click="limpiarFiltros" class="btn btn-ghost">Limpiar</button>
        </div>
      </div>

                </div></div></div></div>
    <div class="p-6 max-w-7xl mx-auto">

      <div v-if="detalles.data.length === 0" class="text-center py-8 text-gray-500">
        No se encontraron registros.
      </div>

      <div v-else>
        <div class="overflow-x-auto">
          <table class="table table-zebra w-full">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Asignatura</th>
                <th>Docente</th>
                <th>Asistencia</th>
                <th>Observación</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="detalle in detalles.data" :key="detalle.id">
                <td>{{ detalle.asistencia.fecha }}</td>
                <td>
                  {{ detalle.estudiante.apellido_p }} {{ detalle.estudiante.apellido_m }} {{ detalle.estudiante.nombres }}
                </td>
                <td>
                  {{ detalle.asistencia.curso.nro_grado }}° {{ detalle.asistencia.curso.nivel.nombre_nivel }}
                  "{{ detalle.asistencia.curso.paralelo.nombre_paralelo }}"
                </td>
                <td>{{ detalle.asistencia.asignatura.nombre }}</td>
                <td>{{ detalle.asistencia.plantel.nombre }}</td>
                <td>
                  <span :class="{
                    'text-green-600': detalle.valor === 'Presente',
                    'text-red-600': detalle.valor === 'Ausente',
                    'text-yellow-600': detalle.valor === 'Atraso',
                    'text-blue-600': detalle.valor === 'Justificado',
                  }">
                    {{ detalle.valor }}
                  </span>
                </td>
                <td>{{ detalle.observacion_individual || '—' }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <Pagination :links="detalles.links" class="mt-4" />
      </div>
    </div>
  </UserLayout>
</template>
<style scoped>
.selectReporte {
    --tw-bg-opacity: 1;
    background-color: rgb(51 65 85 / var(--tw-bg-opacity)) /* #334155 */;
    border-radius: 0.375rem /* 6px */;
    width: 100%;
}
</style>
