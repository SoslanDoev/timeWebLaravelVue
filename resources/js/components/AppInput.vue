<template>
    <input 
        class="input"
        :type="type" 
        :placeholder="placeholder" 
        :id="id" 
        :value="value" 
        @input="$emit('input', $event.target.value)"
    >
</template>

<script setup>
    import { ref, defineEmits, defineProps } from "vue"
    const props = defineProps({
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            default: ''
        },
        id: {
            type: String,
            required: true
        },
        value: {
            type: [String, Number],
            default: ''
        }
    });
    const inputValue = ref("")
    // const emitValue = () => {
    //     emit('input-value', inputValue.value)
    // }
    // const emit = defineEmits(['input-value'])
</script>

<style>

</style>