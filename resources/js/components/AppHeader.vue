<template>
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <RouterLink class="header__logo" to="/">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" fill="#fff" width="24px" height="24px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M256,246.296c-64.182,0-116.398-52.216-116.398-116.398S191.818,13.5,256,13.5s116.398,52.216,116.398,116.398  S320.182,246.296,256,246.296z M256,38.5c-50.397,0-91.398,41.001-91.398,91.398s41.001,91.398,91.398,91.398  s91.398-41.001,91.398-91.398S306.397,38.5,256,38.5z M403.196,498.5H108.804c-31.754,0-57.588-25.834-57.588-57.588v-36.027  c0-74.966,60.989-135.955,135.955-135.955h137.657c74.966,0,135.955,60.989,135.955,135.955v36.027  C460.784,472.666,434.95,498.5,403.196,498.5z M187.171,293.93c-61.181,0-110.955,49.774-110.955,110.955v36.027  c0,17.969,14.619,32.588,32.588,32.588h294.392c17.969,0,32.588-14.619,32.588-32.588v-36.027  c0-61.181-49.774-110.955-110.955-110.955H187.171z"/></svg>
                    {{ user?.name }}
                </RouterLink>
                <nav class="header__menu">
                    <ul class="header__list">
                        <RouterLink to="/" v-if="user && user.role === 0">Главная</RouterLink>
                        <RouterLink to="/create-test" v-if="user && user.role === 1">Добавление теста</RouterLink>
                        <RouterLink to="/admin" v-if="user && user.role === 1">Админ</RouterLink>
                        <a href="#"
                            v-if="user" 
                            class="header__list-item hover" @click.prevent="logoutFunc">
                            Выход
                        </a>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
</template>

<script setup>
    import { ref, computed } from "vue"
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';
    import { useRouter } from 'vue-router'
    const router = useRouter()
    const store = useStore()
    const user = computed(() => store.state.user)
    const logoutFunc = async () => {
        await store.dispatch('logout')
        router.push({ name: 'Login' })
    }
</script>

<style>
    .header {
        margin: 0 0 20px;
        background-color: var(--clr-secondary);
    }
    .header__inner {
        padding: 10px 5px;
        color: var(--clr-primary);
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom-left-radius: var(--border-radius-default);
        border-bottom-right-radius: var(--border-radius-default);
    }
    .header__logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .header__list {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .header__list-item {
        cursor: pointer;
    }
</style>