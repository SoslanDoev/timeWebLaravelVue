<template>
    <div class="notfound">
        <div class="container">
            <div class="notfound__inner">
                <h2 class="title">Страница не найдена</h2>
                <h1 class="notfound__title">404</h1>
                <router-link to="/" class="hover">Вернуться на главную</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from "vue"
</script>

<style>
    .notfound, .notfound__inner {
        height: 100%;
    }
    .notfound__inner {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .notfound__title {
        text-align: center;
        font-size: 9.375rem;
    }
</style>