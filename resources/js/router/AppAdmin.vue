<template>
    <div class="admin">
        <div class="container">
            <div class="admin__inner">
                <h2 class="title admin__title">Админ панель</h2>
                <div class="admin__content">

                    <div class="admin__view-delete" v-if="viewDestroy.visible === true">
                        <h3 class="title">Вы уверены что хотите удалить?</h3>
                        <div class="admin__view-btn">
                            <a href="#" @click.prevent="adminDestroyBtn(true)">Да</a>
                            <a href="#" @click.prevent="adminDestroyBtn(false)">Нет</a>
                        </div>
                    </div>
                    
                    <AppActive
                        v-for="(msg, index) in messages"
                        :key="index"
                        :message="msg"
                        @dismissed="removeMessage(index)"
                    />
                    <div class="admin__info">
{{ adminForm }}
                        <ul class="admin__info-list">
                        <li 
                                class="admin__info-item" v-for="(item, idx) in admin__list" :key="item.id"
                                @click.prevent="adminForm.activeTitle = item.name"
                            >
                                <AppTextBlock :class="{'admin__info-item--active': item.title === adminForm.active}" @click.prevent="adminSettings(item, idx, item.url)">{{ item.name }}</AppTextBlock>
                                <!-- <ul class="admin__info-item__inner" v-if="item.visible"> -->
                                    <!-- <li class="admin__info-item__item" v-for="el in item.inner" :key="el.id"> -->
                                        <!-- <AppTextBlock>{{ el.name }}</AppTextBlock> -->
                                    <!-- </li> -->
                                <!-- </ul> -->
                            </li>
                        </ul>
                    </div>
                    <div class="admin__content-crud">
                        <div class="admin__form-arrow" v-if="getDataVis === true">
                            <a href="#" @click.prevent="adminPage('-')">
                                <AppArrowLeft/>
                            </a>
                            <div class="admin__form-arrow---info">
                                <h3 class="title admin__content-title">{{ adminForm.activeTitle }}</h3>
                                <p>{{ getDataPage }}</p>
                            </div>
                            <a href="#" @click.prevent="adminPage('+')">
                                <AppArrowRight/>
                            </a>
                        </div>
                        
                        
                        <div class="admin__content-inner">
                            
                            <template v-if="getDataPage == 0">
                                <div v-if="getDataVis === true">
                                    <AppTable 
                                        :td-list="getData"
                                        :th-list="getDataTableTh"
                                        @update="getDataUpdate"
                                        @destroy="adminDestroy"
                                    />
                                </div>
                                <div class="admin__content-get admin__box" v-else>
                                    <h4>Загрузка...</h4>
                                </div>
                            </template>


                            <div class="admin__content-form admin__box" v-if="adminForm.active && getDataPage == 1">
                                <h4 class="title admin__content-title">Добавление</h4>

                                <div
                                    v-for="elems in  admin__list[adminForm.id].meta"
                                    :key="elems.id"
                                    class="admin__content-form__item"
                                >
                                    <!-- Дополнительные запросы (Группа) -->
                                    <AppLabel :to="elems.id">{{ elems.placeholder }}</AppLabel>  
                                    <select class="input" id="elems.id" v-model="adminForm.data[elems.name]">
                                        <!-- ================= -->
                                        <template v-if="elems.data">
                                            <option
                                                v-for="elem in elems.data"                                          
                                                :key="elem.id"
                                                :value="Number(elem.id)"
                                            >
                                                {{ elem.title || elem.name || elem.text || "Пусто" }}
                                            </option>
                                        </template>
                                        <!-- ================= -->
                                        <template v-else>
                                            <option :value="Number(-1)">Пусто</option>
                                        </template>
                                    </select>    
                                    <p v-if="errors && errors[elems.name]">{{ errors[elems.name] }}</p>
                                </div>

                                <!-- Дополнительные кнопки radio -->
                                <div 
                                    class="admin__content-form__item"
                                    v-for="item in admin__list[adminForm.id].forms"
                                    :key="item.id"
                                >
                                    <AppLabel :to="item.id">{{ item.placeholder }}</AppLabel>  
                                    <div class="admin__content-form__form" v-if="item.form"> 
                                        <div v-for="el in item.form" :key="el.id">
                                            <input
                                                class="input" 
                                                :type="el.type"
                                                :checked="el.checked"
                                                :id="el.id"
                                                :name="el.name"
                                                :value="el.value"
                                                v-model="adminForm.data[el.name]"
                                            >
                                            <AppLabel class="label-radio" :to="el.id">{{ el.title }}</AppLabel>  
                                        </div>
                                    </div>
                                    
                                    <!-- Главные кнопки -->
                                    <input
                                        v-else
                                        class="input"
                                        :type="item.type"
                                        :placeholder="item.placeholder"
                                        :id="item.id"
                                        v-model="adminForm.data[item.name]"
                                    >
                                    <p v-if="errors && errors[item.name]">{{ errors[item.name] }}</p>
                                </div>
                                <button class="button input admin__content-form__btn hover" @click.prevent="adminSet">Добавить</button>
                            </div>


                            <div class="admin__content-form admin__box" v-if="adminForm.active && getDataPage == 2">
                                <h4 class="title admin__content-title">Обновление</h4>
                                <!-- Дополнительные запросы (Группа) -->
                                <div
                                        v-for="elems in  admin__list[adminForm.id].meta"
                                        :key="elems.id"
                                        class="admin__content-form__item"
                                    >
                                        <AppLabel :to="elems.id">{{ elems.placeholder }}</AppLabel>  
                                        <select class="input" id="elems.id" v-model="adminForm.data[elems.name]">
                                            <!-- ================= -->
                                            <template v-if="elems.data">
                                                <option
                                                    v-for="elem in elems.data"                                            
                                                    :key="elem.id"
                                                    :value="Number(elem.id)"
                                                >
                                                    {{ elem.title || elem.name || elem.text || "Пусто" }}
                                                </option>
                                            </template>
                                            <!-- ================= -->
                                            <template v-else>
                                                <option :value="Number(-1)">Пусто</option>
                                            </template>
                                        </select>    
                                        <p v-if="errors && errors[elems.name]">{{ errors[elems.name] }}</p>
                                </div>

                                <!-- Дополнительные кнопки radio -->
                                <div 
                                    class="admin__content-form__item"
                                    v-for="item in admin__list[adminForm.id].forms"
                                    :key="item.id"
                                >
                                
                                    <AppLabel :to="item.id" v-if="item.form">{{ item.placeholder }}</AppLabel>  
                                    <div class="admin__content-form__form" v-if="item.form"> 
                                        <div v-for="el in item.form" :key="el.id">
                                            <input
                                                class="input" 
                                                :type="el.type"
                                                :id="el.id"
                                                :name="el.name"
                                                :value="el.value"
                                                v-model="adminForm.data[el.name]"
                                            >
                                            <AppLabel class="label-radio" :to="el.id">{{ el.title }}</AppLabel>  
                                        </div>
                                    </div>

                                </div>
                                
                                <div 
                                    class="admin__content-form__item"
                                    v-for="item in admin__list[adminForm.id].forms"
                                    :key="item.id"
                                >

                                    <AppLabel :to="item.id">{{ item.placeholder }}</AppLabel>  
                                    <input 
                                        class="input"
                                        :key="item.id" 
                                        :type="item.type" 
                                        :placeholder="item.placeholder" 
                                        :id="item.id" 
                                        v-model="adminForm.data[item.name]" 
                                    >
                                    <p v-if="errors && errors[item.name]">{{ errors[item.name] }}</p>
                                </div>
                                <button class="button input admin__content-form__btn hover" @click.prevent="adminUpdate">Обновить</button>
                            </div>

                        </div>
                        <div class="admin__content-null" v-if="getDataVis === false">
                            <h4 class="title">Ничего не выбрано</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed, watch } from "vue"
    import AppTextBlock from "../components/AppTextBlock.vue"
    import AppLabel from "../components/AppLabel.vue"
    import AppArrowLeft from "../components/AppArrowLeft.vue"
    import AppArrowRight from "../components/AppArrowRight.vue"
    import AppActive from "../components/AppActive.vue";
    import AppTable from "../components/AppTable.vue";
    import axios from "axios";

    const messages = ref([]);
    const errors = ref({})

    const getData = ref([]) // Get запрос 
    const getDataVis = ref(false) // Показать загрузку данных get
    const getDataPage = ref(0) // Переключение внутренних страниц
    const adminForm = ref({ activeTitle: null, active: null, data: {}, id: null, url: null,})

    const getDataUpdate = (item) => {
        getDataPage.value = 2
        adminForm.value.data = {}
        for (let el in item) { adminForm.value.data[el] = item[el] }
    }

    const getDataTableTh = computed(() => {
        // Получение из объекта ключей
        const mas = []
        let getDataFirst = getData.value[0]
        if (getDataFirst) {
            for (let item in getDataFirst) {
                mas.push(item)
            }        
        }; return mas
    })

    const adminSettings = (item, idx, url) => {
        adminForm.value["active"] = item.title
        adminForm.value["id"] = idx
        adminForm.value["url"] = url
        if (typeof item.func === 'function') { item.func(item); }
        getDataVis.value = false
        getDataPage.value = 0
    }

    const adminPage = (item) => { // Переключение страниц
        if (item === "+") {
            getDataPage.value += 1
        }
        else if (item === "-") {
            getDataPage.value -= 1
        }
        if (getDataPage.value >= 2) {
            getDataPage.value = 2
        } else if (getDataPage.value <= 0) {
            getDataPage.value = 0
        }
    }

    const adminSet = async () => {
        try {
            errors.value = {};
            const data = {}; Object.entries(adminForm.value["data"]).forEach((e) => { data[e[0]] =e[1]  })
            console.log(data)
            if (data["start_time"] || data["end_time"]) {
                let start_time = new Date(data["start_time"])
                let end_time = new Date(data["end_time"])
                data["start_time"] = start_time.toISOString().slice(0, 19).replace('T', ' ');
                data["end_time"] = end_time.toISOString().slice(0, 19).replace('T', ' ');
            }
            const res = await axios.post(adminForm.value["url"], data);
            console.log("dadadadad", res)

            // console.log("created", res.data.data)
            const newData = res.data?.data?.data || res.data?.data || res.data;
            if (newData) {
                getData.value.push(newData)
            }
            messages.value.push('Request was successful!');
        } catch (err) {
            console.log(err)
            errors.value = err.response.data.errors
            messages.value.push('Request failed.');
        }
    };

    const findIndexById = (arr, id) => {
        return arr.findIndex(obj => obj.id === id);
    }

    const adminUpdate = async () => {
        try {
            errors.value = {};
            const data = {}; Object.entries(adminForm.value["data"]).forEach((e) => { 
                if (e[1] || e[1] === 0) { data[e[0]] = e[1]  }
            })

            await axios.patch(adminForm.value["url"]+`/${data["id"]}`, data);
            let index = findIndexById(getData.value, data["id"])
            getData.value[index] = data
            
            // getData.value.push(res.data)
            console.log(getData.value)
            messages.value.push('Request was successful!');
        } catch (err) {
            console.log(err)
            errors.value = err.response.data.errors
            messages.value.push('Request failed.');
        }
    }

    const viewDestroy = ref({
        visible: false, // Показать скрыть  
        item: null,
    })
    const adminDestroy = (item) => { // Открытие формы удаления
        viewDestroy.value.visible = true
        viewDestroy.value.item = item
    }
    const adminDestroyBtn = (bool) => { // Нажатие на кнопку да нет
        if (bool === false) {
            viewDestroy.value.visible = false
            return 
        }
        adminDestroys()
    }
    const adminDestroys = async () => { // Удаление если да
        const item = viewDestroy.value.item
        try {
            await axios.delete(adminForm.value["url"]+`/${item["id"]}`);
            getData.value = getData.value.filter((e) => e.id !== item.id)
        } catch(err) {
            console.log(err)
            errors.value = err.response.data.errors
            messages.value.push('Request failed.');
        }
        viewDestroy.value.visible = false
        viewDestroy.value.item = null
    }

    const removeMessage = (index) => { // Удаление сообщений
        messages.value.splice(index, 1);
    }

    const adminListGet = async (item) => {
        try {
            if (item && item.meta) {
                item.meta.forEach(async (e) => {
                    if (e.url) {
                        const res = await axios.get(e.url)
                        e.data = res.data.data
                    }
                })
            }
        } catch (err) {
            console.log(err)
        }

        console.log(item)
        try {
            const res = await axios.get(item.url)
            getData.value = res.data.data
            getDataVis.value = true
        } catch (err) {
                console.log(err)
        }
    }

    watch("start_time", () => {
        console.log('da')
    })

    const admin__list = ref([
        { id: 1, title: "users", name: "Студенты", visible: false, url: "/api/users", inner: [
            { id: 10, name: "Добавить",},
            { id: 11, name: "Обновить" },
            { id: 12, name: "Удалить" },
        ], meta: [
            { id: "meta_1", name: "group_id", title: "Группы", url: "/api/groups", placeholder:"Выберите группу", data: [], }
        ], forms: [
            { id: "form_1", name: "name", type: "text", "placeholder": "Введите имя", id: "name" },
            { id: "form_2", name: "surname", type: "text", "placeholder": "Введите фамилию", id: "surname" },
            { id: "form_3", name: "role", type: "text", "placeholder": "Выберите роль", id: "role", form: [
                { id: "form_3-1", value: 0, name: "role", type: "radio", title: "Пользователь", checked: "checked", },
                { id: "form_3-2", value: 1, name: "role", type: "radio", title: "Админ", },
            ], },
            { id: "form_4", name: "block", type: "text", "placeholder": "Выберите активность пользователя", id: "block", form: [
                { id: "form_4-1", value: 0, name: "block", type: "radio", title: "Активный", checked: "checked", },
                { id: "form_4-2", value: 1, name: "block", type: "radio", title: "Заблокированный", },
            ], },
            // { id: "form_5", name: "group_id", type: "text", "placeholder": "Выберите группу", id: "group_id", },
            { id: "form_6", name: "email", type: "email", "placeholder": "Введите почту", id: "email" },
            { id: "form_7", name: "password", type: "password", "placeholder": "Введите пароль", id: "password" },
            { id: "form_8", name: "password_confirmation", type: "password", "placeholder": "Повторите пароль", id: "password_confirmation" },
        ], func: adminListGet },
        // ========================
        { id: 2, title: "discipline", name: "Дисциплины", visible: false, url: "/api/disciplines", inner: [
            { id: 20, name: "Добавить" },
            { id: 21, name: "Обновить" },
            { id: 22, name: "Удалить" },
        ], forms: [
            { id: "form_1", name: "name", type: "text", "placeholder": "Введите имя", id: "name" },
        ], func: adminListGet },
        // ========================
        { id: 3, title: "authors", name: "Авторы", visible: false, url: "/api/authors", inner: [
            { id: 30, name: "Добавить" },
            { id: 31, name: "Обновить" },
            { id: 32, name: "Удалить" },
        ], forms: [
            { id: "form_1", name: "name", type: "text", "placeholder": "Введите имя", id: "name" },
            { id: "form_2", name: "surname", type: "text", "placeholder": "Введите фамилию", id: "surname" },
            { id: "form_3", name: "patronymic", type: "text", "placeholder": "Введите отчество", id: "patronymic" },
        ], func: adminListGet },
        // ========================
        { id: 4, title: "answer", name: "Ответы", url: "/api/answers", visible: false, inner: [
            { id: 40, name: "Добавить" },
            { id: 41, name: "Обновить" },
            { id: 42, name: "Удалить" },
        ], meta: [
            { id: "meta_1", name: "question_id", title: "Вопросы", url: "/api/questions", placeholder: "Выберите вопрос", data: [], },
        ], forms: [
            { id: "form_2", name: "text", type: "text", "placeholder": "Введите текст", id: "text" },
            { id: "form_3", name: "points", type: "number", "placeholder": "Кол-во баллов", id: "points" },
        ], func: adminListGet },
        // ========================
        { id: 9, title: "student_answer", name: "Ответы студентов", url: "/api/useranswer", visible: false, inner: [
            { id: 90, name: "Добавить" },
            { id: 91, name: "Обновить" },
            { id: 92, name: "Удалить" },
        ], meta: [
            // { id: "meta_1", name: "user_id", title: "Вопросы", url: "/api/users", placeholder: "Выберите пользователя", data: [], },
            // { id: "meta_2", name: "question_id", title: "Вопросы", url: "/api/questions", placeholder: "Выберите вопрос", data: [], },
            // { id: "meta_3", name: "answer_id", title: "Вопросы", url: "/api/answers", placeholder: "Выберите вопрос", data: [], },
        ], func: adminListGet },
        // ========================
        { id: 5, title: "test_schedules", name: "Настройка тестов", url: "/api/testschedules", visible: false, inner: [
            { id: 50, name: "Добавить" },
            { id: 51, name: "Обновить" },
            { id: 52, name: "Удалить" },
        ], meta: [
            { id: "meta_1", type: "number", name: "test_id", title: "Тесты", url: "/api/tests", placeholder:"Выберите тест", data: [], },
            { id: "meta_2", type: "number", name: "group_id", title: "Группы", url: "/api/groups", placeholder:"Выберите группу", data: [], }
        ], forms: [
            { id: "form_1", name: "start_time", type: "datetime-local", "placeholder": "Начало тестирования", id: "start_time" },
            { id: "form_2", name: "end_time", type: "datetime-local", "placeholder": "Конец тестирования", id: "end_time" },
        ], func: adminListGet },
        // ========================
        { id: 6, title: "tests", name: "Тесты", visible: false, url: "/api/tests", inner: [
            { id: 60, name: "Добавить" },
            { id: 61, name: "Обновить" },
            { id: 62, name: "Удалить" },
        ], meta: [
            { id: "meta_1", name: "discipline_id", title: "Дисциплины", url: "/api/disciplines", placeholder: "Выберите дисциплину", data: [], },
            { id: "meta_2", name: "author_id", title: "Авторы", url: "/api/authors", placeholder: "Выберите автора", data: [], },
        ], forms: [
            { id: "form_1", name: "title", type: "text", "placeholder": "Введите название", id: "title" },
            { id: "form_2", name: "description", type: "text", "placeholder": "Введите описание", id: "description" },
            { id: "form_3", name: "duration", type: "number", "placeholder": "Введите время теста", id: "duration" },
        ], func: adminListGet },
        // ========================
        { id: 7, title: "questions", name: "Вопросы", url: "/api/questions", visible: false, inner: [
            { id: 70, name: "Добавить" },
            { id: 71, name: "Обновить" },
            { id: 72, name: "Удалить" },
        ], meta: [
            { id: "meta_1", name: "test_id", title: "Тесты", url: "/api/tests", placeholder:"Выберите тест", data: [], },
        ], forms: [
            { id: "form_2", name: "text", type: "text", "placeholder": "Введите название", id: "text" },
        ], func: adminListGet },
        // ========================
        { id: 8, title: "groups", name: "Группы", visible: false, url: "/api/groups", inner: [
            { id: 80, name: "Добавить" },
            { id: 81, name: "Обновить" },
            { id: 82, name: "Удалить" },
        ], forms: [
            { id: "form_1", name: "name", type: "text", "placeholder": "Введите имя", id: "name" }
        ], func: adminListGet }
    ])
</script>

<style>
    .admin, .admin__inner, .admin__content {
        height: 100%;
    }
    .admin__content {
        display: grid;
        gap: 15px;
        grid-template-columns: 250px 1fr;
    }
    .admin__info-list, .admin__info-item__inner {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .admin__info-item__inner {
        padding: 5px 0 0 20px;
    }
    .admin__info-item--active {
        background-color: var(--clr-secondary);
        color: var(--clr-primary);
    }

    .admin__box + .admin__box {
        margin-top: 15px;
    }

    .admin__content-get {
        border-top: 3px solid var(--clr-secondary);
        border-bottom: 3px solid var(--clr-secondary);
        padding: 10px 20px;
        overflow-y: auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        /* min-height: 500px; */
    }
    .admin__form-arrow {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .admin__form-arrow---info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .admin__content-form {
        max-width: 500px;
        margin: 15px auto 15px;
        text-align: center;
    }
    .admin__content-form__form {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        border-bottom: 2px solid var(--clr-secondary);
        /* padding: 0 0 5px; */
        margin: 5px 0;
    }

    .admin__content-form__item {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .admin__content-form__btn {
        margin: 10px 0;
    }

    .admin__content-crud {
        width: 100%;
        overflow: hidden
    }

    .admin__content-inner {
        width: 100%;
        overflow-x: auto;
        max-width: var(--container-width);
        border: 4px solid var(--clr-secondary);
        border-radius: 4px;
        padding: 10px;
        margin: 10px 0;
    }

    .admin__view-delete {
        background-color: var(--clr-primary);
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border-top: 3px solid var(--clr-secondary);
        border-bottom: 3px solid var(--clr-secondary);
    }

    .admin__view-btn {
        display: flex;
        gap: 50px;
    }

    .admin__view-btn a {
        min-width: 75px;
        text-align: center;
        display: inline-block;
        padding: 2px 15px;
        background-color: var(--clr-primary);
        color: var(--clr-secondary);
        border: 3px solid var(--clr-secondary);
        border-radius: 4px;
    }
</style>