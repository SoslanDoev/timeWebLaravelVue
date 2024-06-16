<template>
    <div class="app__create-test">
        <div class="container">
            <AppActive
                v-for="(msg, index) in messages"
                :key="index"
                :message="msg"
                @dismissed="removeMessage(index)"
            />
            <div class="app__create-test__header2">
                <h1>Создание теста</h1>
                <div>
                    <AppLabel>Название: </AppLabel>
                    <input type="text" class="input" v-model="tests.title" placeholder="Введите название">
                    <AppLabel>Дисциплина: </AppLabel>
                    <select class="input" id="elems.id" v-model="tests.discipline_id">
                        <!-- ================= -->
                        <template v-if="discipline.length">
                            <option
                                v-for="elem in discipline"                                          
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

                    <AppLabel>Автор: </AppLabel>
                    <select class="input" id="elems.id" v-model="tests.author_id">
                        <!-- ================= -->
                        <template v-if="authors.length">
                            <option
                                v-for="elem in authors"                                          
                                :key="elem.id"
                                :value="Number(elem.id)"
                            >
                                {{ elem.name || "" }}
                                {{ elem.surname || "" }}
                                {{ elem.patronymic || "" }}
                            </option>
                        </template>
                        <!-- ================= -->
                        <template v-else>
                            <option :value="Number(-1)">Пусто</option>
                        </template>
                    </select>    
                </div>
            </div>

            <div class="app__create-test__inner">
                <div class="app__create-content">
                    <div class="app__cretae-test-header">
                        <button class="button input admin__content-form__btn hover" @click.prevent="listsAdd">Добавить новый вопрос</button>
                        <button class="button input admin__content-form__btn hover" @click.prevent="listsRemove">Удалить вопрос</button>
                        <div class="app__create-item--box">
                            <AppArrowLeft @click.prevent="pageClick('-')"/>
                            {{ page }}
                            <AppArrowRight @click.prevent="pageClick('+')" />
                        </div>
                </div>
                    
                    <!-- <div v-for="item in lists" :key="item.id"> -->
                    <div v-for="item in computedLists" class="app__create-quest">
                        <div v-if="item.questions" class="app__create-quest">
                            <AppLabel>Вопрос: </AppLabel>
                            <div>
                                <!-- {{ item }} -->
                                <input 
                                    class="input"
                                    type="text"
                                    placeholder="Введите название вопроса"
                                    v-model="item.questions.text"
                                >
                            </div>
                        </div>

                        <div v-if="item.answers">
                            <div>
                                <div class="app__create-item__block" v-for="(el, idx) in item.answers" :key="idx">
                                    <AppLabel>Ответ: </AppLabel>
                                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                        <input 
                                            class="input"
                                            type="text" 
                                            placeholder="Введите ответ на вопрос"
                                            v-model="el.text"
                                        >
                                        <button class="button input  app__create-absolute hover" @click.prevent="deleteAnswers(item, idx)">-</button>
                                    </div>

                                    <AppLabel>Кол-во баллов: </AppLabel>
                                    <input
                                        class="input"
                                        type="number" placeholder="Кол-во баллов "
                                        v-model="el.points"
                                    >
                                </div>
                            </div>
                            <button class="button input admin__content-form__btn hover" @click.prevent="addAnswers(item)">+</button>
                        </div>

                    </div>
                </div>

                <div class="app__create-info">
                    <ul class="app__create-list" v-if="lists.length">
                        <li v-for="(items, idx) in lists" class="app__create-item hover" @click.prevent="page = idx">
                            <div class="app__create-item--box" :class="{'app__create-item--active': page === idx}">
                                <AppLabel>Вопрос: </AppLabel>
                                <p>{{ items.questions.text }}</p>
                            </div>
                            <div v-for="item in items.answers" class="app__create-item__item">
                                <div class="app__create-item--box">
                                    <AppLabel>Ответ: </AppLabel>
                                    <p>{{ item.text }}</p>
                                </div>
                                <div class="app__create-item--box">
                                    <AppLabel>Кол-во баллов: </AppLabel>
                                    <p>{{ item.points }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <button class="button input admin__content-form__btn hover" @click.prevent="setForms">Отправить</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed, onMounted  } from "vue"
    import axios from "axios"
    import AppActive from "../components/AppActive.vue";
    import AppLabel from "../components/AppLabel.vue"
    import AppArrowLeft from "../components/AppArrowLeft.vue"
    import AppArrowRight from "../components/AppArrowRight.vue"
    const messages = ref([]);
    
    const tests = ref({
        title: "",
        discipline_id: -1,
        author_id: -1
    })
    const lists = ref([
        {
            "questions": {
                "text": "" // Текст вопроса
            }, 
            "answers": [
                {
                    "text": '', // Текст ответа
                    "points": 0, // Кол-во баллов
                }
            ]
        }
    ]) 
    const page = ref(0)
    const pageClick = (item) => {
        if (item === "+") {
            if (page.value+1 >= lists.value.length) {
                page.value = 0            
            } else {
                page.value += 1            
            }
        } else {
            if (page.value <= 0) {
                page.value = lists.value.length - 1
            } else {
                page.value -= 1
            }
        }
    }
    const listsAdd = () => { // Добавление
        lists.value.push(
            {
                "questions": {
                    "text": "" // Текст вопроса
                }, 
                "answers": [
                    {
                        "text": '', // Текст ответа
                        "points": 0, // Кол-во баллов
                    }
                ]
            }
        )
        page.value++
    }
    const listsRemove = () => {
        if (lists.value.length === 1) { return }
        lists.value.splice(page.value, 1)
        page.value = page.value - 1
    }
    const addAnswers = (item) => {
        item.answers.push(
            {
                "text": '', // Текст ответа
                "points": 0, // Кол-во баллов
            }
        )
    }
    const deleteAnswers = (item, index) => { // Удаление ответа
        lists.value[page.value].answers.splice(index, 1)
    }
    const computedLists = computed(() => {
        return [lists.value[page.value]]
    })
    const setForms = async () => {
        const data = [
            {
                "tests": tests.value
            },
            ...lists.value
        ]
        // return 
        try {
            const response = await axios.post("/api/tests/setall", data)
            messages.value.push('Успешно. Тест добавлен!');
            console.log(response)
        } catch(err) {
            messages.value.push('Ошибка. Перепроверьте данные.');
            console.log(err)
        }
    }
    const removeMessage = (index) => { // Удаление сообщений
        messages.value.splice(index, 1);
    }
    const discipline = ref([])
    const authors = ref([])
    onMounted (async () => {
        try {
            const res = await axios.get("/api/disciplines")
            discipline.value = res.data?.data?.data || res.data?.data || res.data;
        } catch(err) {
            console.log(err)
        }
        try {
            const res = await axios.get("/api/authors")
            authors.value = res.data?.data?.data || res.data?.data || res.data;
        } catch(err) {
            console.log(err)
        }
    })
</script>

<style>
    .app__create-test__inner {
        display: grid;
        gap: 50px;
        grid-template-columns: 1fr 450px;
    }
    .app__create-test__header2 {
        display: flex;
        flex-direction: column;
        gap: 25px;
        margin: 10px 0;
    }
    .app__create-test__header2 > div{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .app__cretae-test-header {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--clr-secondary);
        padding: 10px 0;
    }
    .app__cretae-test-header .arrow-6 svg {
        margin: 0 5px;
    }
    .app__create-info {
        min-height: 60vh;
        padding: 10px;
        border-radius: 4px;
        border: 2px solid var(--clr-secondary);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .app__create-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: scroll;
        max-height: 50vh;
    }
    .app__create-item {
        padding: 0 0 0 10px;
        cursor: pointer;
    }
    .app__create-item--active {
        background-color: var(--clr-secondary);
        color: var(--clr-primary);
        padding: 5px;
        border-bottom: 2px solid var(--clr-secondary);
        border-radius: 4px;
    }
    .app__create-item__item {
        padding: 0 0 0 10px;
    }
    .app__create-item--box {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .app__create-item > .app__create-item__item {
        padding: 10px  0 10px 10px;
        border-bottom: 2px solid var(--clr-secondary);
    }
    .app__create-quest {
        margin: 10px 0;
    }
    .app__create-item__block {
        position: relative;
    }
    .app__create-absolute {
        width: 50px;
        padding: 2px 0;
    }
    .app__create-item__block + .app__create-item__block {
        border-top: 2px solid var(--clr-secondary);
        margin: 10px 0 0 0;
    }
</style>
<!-- {
"items": [
        {
            "test": {
                "id": -1,
                "name": "Text123"
            },
            "question": {
                "id": -1,
                "text": "Test123",
                "points": 5
            }
        },
        {
            "test": {
                "id": -1,
                "name": "Text123"
            },
            "question": {
                "id": -1,
                "text": "Test123",
                "points": 5
            }
        },
        {
            "test": {
                "id": -1,
                "name": "Text123"
            },
            "question": {
                "id": -1,
                "text": "Test123",
                "points": 5
            }
        }
    ]
} -->