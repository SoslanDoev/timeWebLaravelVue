<template>
    <div class="onload">
        <div class="container">
            <div class="onload__inner">
                <div class="onload__el"></div>
                <h2 class="onload__text">Загрузка...</h2>
            </div>
        </div>
    </div>
</template>

<style>
    .onload {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background-color: var(--clr-primary);
    }
    .onload__inner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100vh;
        width: 100%;
        align-items: center;
    }
    .onload__el {
        width: 150px;
        height: 150px;
        background-color: var(--clr-secondary);
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        animation: onload 5s linear infinite;
        margin: 0 0 50px;
    }
    @keyframes onload {
        0% {
            background-color: var(--clr-secondary);
            transform: rotate(0deg);
        } 
        50% {
            background-color: var(--clr-tertiary);
        }
        100% {
            background-color: var(--clr-secondary);
            transform: rotate(360deg);
        }
    }
</style>