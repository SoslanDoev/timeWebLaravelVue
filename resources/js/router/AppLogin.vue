<template>
    <AppAuthSection>
        <AppActive
            v-for="(msg, index) in messages"
            :key="index"
            :message="msg"
            @dismissed="removeMessage(index)"
        />
        <h2 class="title">Авторизация</h2>
        <input id="email" type="email" v-model="form.email" class="input" placeholder="Введите почту">
        <p v-if="errors && errors.email">{{ errors.email }}</p>
        <input id="password" type="password" v-model="form.password" class="input" placeholder="Введите пароль">
        <button @click.prevent="formFunc" class="button hover" type="submit">Отправить</button>
        <p v-if="errors && errors.password">{{ errors.password }}</p>
        <RouterLink to="/register">Регистрация</RouterLink>
    </AppAuthSection>
</template>

<script setup>
    import { ref } from "vue"
    import { useRouter } from 'vue-router'
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';
    import axios from "axios"
    
    import AppActive from "../components/AppActive.vue";
    import AppAuthSection from "../components/AppAuthSection.vue" // Section Auth
    
    const router = useRouter()
    const store = useStore();
    
    const messages = ref([]);
    const removeMessage = (index) => { // Удаление сообщений
        messages.value.splice(index, 1);
    }

    const errors = ref({})
    const form = ref({"email": "", "password": ""}) // Форма авторизации

    const formFunc = () => {
        errors.value = {}
        // Функция для передачи данных на сервер для авторизации
        axios.post("/api/auth/login", {
            email: form.value.email, password: form.value.password,
        }).then((res) => {
            console.log("auth", res)
            localStorage.setItem("access_token", res.data.access_token)
            store.commit('setAuth', res.data.access_token)
            return store.dispatch('login')
        }).then(() => {
            messages.value.push('Вы успешно авторизировались');
            router.push({ name: 'Home' })
        }).catch((err) => {
            errors.value = err.response.data.errors
            console.log("err", err)
            messages.value.push('Ошибка регистрации');
        })
    }
</script>