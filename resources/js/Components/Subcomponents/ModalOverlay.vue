<script setup>
import ButtonX from '@/Components/Subcomponents/ModalOberlayXButton.vue';
const emit = defineEmits([
    'cerrar',
]);
</script>
<template>
    <div class="modal-overlay z-40" @click.self="$emit('cerrar')">
        <div class="p-1 bg-darkblue rounded-md w-min">
            <slot/>
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
