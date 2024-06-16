<template>
    <label :for="to" class="label hover">
        <slot></slot>
    </label>
</template>

<script setup>
    import { defineProps } from 'vue'
    const props = defineProps({
        to: {
            type: String,
            default: "",
        }
    })
</script>

<style>
    .label {
        text-align: left;
        font-weight: 600;
        cursor: pointer;
    }
</style>