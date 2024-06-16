<template>
    <section class="auth">
        <div class="auth__inner">
            <slot></slot>
        </div>
    </section>
</template>

<script setup>
</script>

<style>
    .auth {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .auth__inner {
        max-width: 500px;
        width: 100%;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
</style>