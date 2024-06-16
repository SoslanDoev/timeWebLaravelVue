<template>
    <div class="tests">
        <div class="container">
            <div class="tests__inner">
                <div class="tests__disc-main">
                    <h2 class="title">Тесты которые можно пройти</h2>
                    <div class="tests__disc">
                        <AppTextBlock v-for="item in 5">
                            Название теста или предмет
                        </AppTextBlock>
                    </div>
                </div>
                <div class="tests__res-main">
                    <h2 class="title">Результаты прошлого тестирования</h2>
                    <div>
                        Результаты прошлого тестирования
                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>

<script setup>
    import AppTextBlock from "../components/AppTextBlock.vue"
</script>

<style>
    .tests__disc {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin: 0 0 15px;
    }
    .tests__res {

    }
</style>