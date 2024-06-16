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
        <AppLabel :to="'name'">Введите имя *</AppLabel>
        <input id="name" type="text" v-model="form.name" class="input" placeholder="Введите имя">
        <p v-if="errors.name">{{ errors.name }}</p>
        <AppLabel :to="'surname'">Введите фамилию *</AppLabel>
        <input id="surname" type="text" v-model="form.surname" class="input" placeholder="Введите фамилию">
        <p v-if="errors.surname">{{ errors.surname }}</p>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <AppLabel :to="'group'">Выберите группу *</AppLabel>
            <a href="#" @click.prevent="groupsGet">Обновить</a>
        </div>
        <select class="input" id="group" v-model="form.group">
            <template v-if="groups">
                <option
                    v-for="item in groups"
                    :key="item.id"
                    :value="Number(item.id)"
                >
                {{ item.name }}
            </option>
            </template>
            <template v-else>
                <option value="-1">Пусто</option>
            </template>
        </select>
        <p v-if="errors.group_id">{{ errors.group_id }}</p>
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
        "group": null,
        "email": null,
        "password": null,
        "password_confirmation": null,
    }) // Форма авторизации

    const groups = ref([])

    const groupsGet = async () => {
        try {
            const res = await axios.get("api/groups/")
            groups.value = res.data.data
        } catch(err) {
            console.log(err)
        }
    }; groupsGet()

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
            "group_id": form.value.group,
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