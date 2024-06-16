<template>
    <button class="btn hover">
        <slot></slot>
    </button>
</template>

<script setup>
    import { ref } from "vue"
</script>

<style>
    .btn {
        cursor: pointer;
        padding: 10px;
        background-color: var(--clr-secondary);
        border-radius: var(--border-radius-default);
        color: var(--clr-primary);
        border: none;
        box-shadow: 5px 5px 5px 5px var(--clr-tertiary);
        transition: var(--transition-default);
        opacity: 1;
    }
</style>