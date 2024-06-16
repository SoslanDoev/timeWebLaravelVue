<template>
    <section class="login__active">
        <div class="container">
            <div class="login__active-inner">
                <h1 class="title login__active-title">Вы уже авторизованы</h1>
                <RouterLink to="/">Перейти на главную</RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup>

</script>

<style>
    .login__active,
    .login__active-inner {
        height: 100%;
    }
    .login__active-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 25px;
    }
</style>