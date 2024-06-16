<template>
    <div class="message" v-if="visible">{{ message }}</div>
</template>

<script setup>
    import { ref, defineEmits, defineProps, onMounted  } from "vue"
    const props = defineProps({
        message: {
            type: String,
            default: "Успешно",
        },
    });

    const emit = defineEmits(['dismissed']);
    
    const visible = ref(true);
    
    onMounted(() => {
        setTimeout(() => {
            visible.value = false;
            emit('dismissed');
        }, 3000);
    });
</script>

<style>
    .message {
        background-color: var(--clr-tertiary);
        color: var(--clr-primary);
        position: absolute;
        min-width: 250px;
        padding: 10px 25px;
        top: 50px;
        right: 50px;
        z-index: 250;
        text-align: center;
        border-radius: 4px;
    }
</style>