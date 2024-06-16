<template>
    <div class="text__block hover">
        <slot></slot>
    </div>
</template>

<style>
    .text__block {
        cursor: pointer;
        padding: 10px;
        background-color: var(--clr-primary);
        color: var(--clr-secondary);
        border-radius: var(--border-radius-default);
        border: 3px solid var(--clr-secondary);
    }
</style>