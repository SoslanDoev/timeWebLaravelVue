<template>
    <div class="app__test">
        <div class="container">
            <div class="app__test-inner">
                {{ questions }}
                <div
                    v-for="item in tests.questions" 
                    :key="item.id"
                    class="app__test-items"
                >
                    <h4 class="title">{{ item.text }}</h4>
                    <div v-for="el in item.answers" class="app__test-item">
                        <p
                            @click.prevent="setAnswer(item, el)"
                            :class="{'app__test-item--active': questions[item.id] === el.id}"
                            class="hover"
                        >
                            {{ el.text }}
                        </p>
                    </div>
                </div>
                <button class="button app__test-btn hover" @click.prevent="endQuestion">Закончить</button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue"
    import { useRouter, useRoute } from 'vue-router'
    import axios from "axios"
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';

    const store = useStore();

    const router = useRouter()
    const route = useRoute()

    const testID = route.params.id
    const tests = ref([])

    const questions = ref({})

    const home = () => {
        router.push({ name: "Home", params: { id: -1, } })
    }
    
    const provTestID = async () => {
        try {
            const response = await axios.get(`/api/tests/${testID}`)
            return response.data?.data?.data || response.data?.data || response.data
        } catch(err) {
            home()
        }
    } 

    const setAnswer = (item, el) => {
        console.log(item, el)
        questions.value[item.id] = el.id
        // questions.value[item.id] = item.id
    }

    const endQuestion = async () => {
        const dataMas = [ { user_id: store.state.user.id }, ]
        Object.entries(questions.value).forEach((e) => {
            dataMas.push({
                question_id: Number(e[0]),
                answer_id: Number(e[1]),
            })
        })
        try {
            const res = await axios.post("/api/useranswer/end-quest", dataMas)
            router.push({ name: "Home", params: { id: -1, } })
        } catch (err) {
            console.log(err)
        }
    }

    onMounted(async () => {
        await provTestID()
        try {
            const res = await axios.get(`/api/tests/${testID}/questions`)
            const data = res.data?.data?.data || res.data?.data || res.data
            tests.value = data
        } catch (err) {
            console.log(err)
            home()
        }
    })
</script>

<style>
    .app__test-inner {
        display: flex;
        padding: 0 0 10px 0;
        flex-direction: column;
        justify-content: center;
        gap: 30px;
    }
    .app__test-item {
        padding: 10px 0;
        cursor: pointer;
    }
    .app__test-item p {
        display: inline-block;
        padding: 10px;
        border: 4px solid var(--clr-secondary);
        border-radius: 4px;
        width: 100%;
    }
    .app__test-items {
        padding: 10px; 
        border-radius: 4px;
        border: 4px solid var(--clr-secondary);
    }
    .app__test-item--active {
        background-color: var(--clr-secondary);
        color: var(--clr-primary);
    }
    .app__test-btn {
        max-width: 250px;;
        margin: 0 auto;
    }
</style>