<script setup>
const props = defineProps({
  estado: '',
});
</script>
<template>
    <div class="ml-3 w-fit font-bold text-lg text-pewter cursor-pointer">
        <div v-if="props?.estado" class="bg-green-700 p-2 rounded-md">
            <p>Activo</p>
        </div>
        <div v-else class=" bg-red-800 p-2 rounded-md">
            <p>Inactivo</p>
        </div>
    </div>
</template>
