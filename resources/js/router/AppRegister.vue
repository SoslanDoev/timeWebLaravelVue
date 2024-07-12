<template>
    <AppAuthSection>
        <!-- {{ form }} -->
        <!-- {{ errors }} -->
        <AppActive
            v-for="(msg, index) in messages"
            :key="index"
            :message="msg"
            @dismissed="removeMessage(index)"
        />
        <h2 class="title">Регистрация</h2>
        <div style="display: flex; gap: 10px; width: 100%;">
            <AppLabel for="role_0">Ученик</AppLabel>
            <input id="role_0" type="radio" class="input" v-model="form['role']" name="role" value="0" checked>
            <AppLabel for="role_1">Преподаватель</AppLabel>
            <input id="role_1" type="radio" class="input" v-model="form['role']" name="role" value="2">
        </div>
        <AppLabel :to="'name'">Введите имя *</AppLabel>
        <input id="name" type="text" v-model="form.name" class="input" placeholder="Введите имя">
        <p v-if="errors.name">{{ errors.name }}</p>
        <AppLabel :to="'surname'">Введите фамилию *</AppLabel>
        <input id="surname" type="text" v-model="form.surname" class="input" placeholder="Введите фамилию">
        <p v-if="errors.surname">{{ errors.surname }}</p>
        <AppLabel :to="'email'">Введите почту *</AppLabel>
        <input id="email" type="email" v-model="form.email" class="input" placeholder="Введите почту">
        <p v-if="errors.email">{{ errors.email }}</p>
        <AppLabel :to="'password'">Введите пароль *</AppLabel>
        <input id="password" type="password" v-model="form.password" class="input" placeholder="Введите пароль">
        <p v-if="errors.password">{{ errors.password }}</p>
        <AppLabel :to="'password_confirmation'">Повторите пароль *</AppLabel>
        <input id="password_confirmation" type="password" v-model="form.password_confirmation" class="input" placeholder="Повторите пароль">
        <p v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
        <button @click.prevent="formFunc" class="button hover" type="submit">Отправить</button>
        <RouterLink to="/login">Авторизация</RouterLink>
    </AppAuthSection>
</template>

<script setup>
    import { ref } from "vue"
    import axios from "axios"
    import { useRouter } from 'vue-router'
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';

    import AppActive from "../components/AppActive.vue";
    import AppAuthSection from "../components/AppAuthSection.vue" // Section Auth
    import AppLabel from "../components/AppLabel.vue"

    const router = useRouter()
    const store = useStore();

    const errors = ref({})

    const messages = ref([]);
    const removeMessage = (index) => { // Удаление сообщений
        messages.value.splice(index, 1);
    }

    const form = ref({
        "name": null,
        "surname": null,
        "role": 0,
        "email": null,
        "password": null,
        "password_confirmation": null,
    }) // Форма авторизации

    const login = async (email, password) => {
        axios.post("/api/auth/login", {
            email: email, password: password,
        }).then((res) => {
            console.log("auth", res)
            localStorage.setItem("access_token", res.data.access_token)
            store.commit('setAuth', res.data.access_token)
            return store.dispatch('login')
        }).then(() => {
            messages.value.push('Вы успешно авторизировались');
            router.push({ name: 'Home' })
        }).catch((err) => {
            console.log("err", err)
            messages.value.push('Ошибка регистрации');
        })
    }

    const formFunc = () => {
        // Функция для передачи данных на сервер для авторизации
        errors.value = {}
        axios.post("/api/users", {
            "name": form.value.name,
            "surname": form.value.surname,
            "role": form.value.role,
            "email": form.value.email,
            "password": form.value.password,
            "password_confirmation": form.value.password_confirmation,
        }).then((res) => {
            login(form.value.email, form.value.password)
        }).catch((err) => {
            console.log(err)
            errors.value = err.response.data.errors
        })
    }
</script>