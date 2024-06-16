<template>
    <div class="app__home">
        <div class="container">
            <div class="app__home-inner">
                <h1 class="title">Тестирование</h1>

                <div class="app__home-tests" v-if="tests.length">
                    <div
                        v-for="item in tests"
                        :key="item.id"
                        class="app__home-tests__item hover"
                        @click.prevent="getTest(item.test.id)"
                    >
                    {{ item.test.title }}
                    </div>
                </div>

                <div class="app__home-info">
                    <h2 class="title">Последние результаты</h2>
                    <div v-for="item in results" style="display: flex; gap: 10px;">
                        <p>{{ item.test_title }}</p>
                        <p>{{ item.total_points }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
    import { ref, onMounted } from "vue"
    import axios from "axios"
    import { useRouter } from 'vue-router'
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';

    const store = useStore()
    const router = useRouter()
    const tests = ref([])
    const results = ref([])

    const getTest = (testID) => {
        router.push({ name: "Test", params: { id: testID } })
    }

    onMounted(async () => {
        const groupID = store.state.user.group_id
        const userID = store.state.user.id
        try {
            const res = await axios.get(`/api/testschedules/group/${groupID}/${userID}`)
            tests.value = res.data?.data?.data || res.data?.data || res.data
        } catch(err) {
            console.log(err)
        }
        try {
            const res = await axios.get(`api/testschedules/res/${userID}`)
            results.value = res.data?.data?.data || res.data?.data || res.data
        } catch(err) {
            console.log(err)
        }
    })
</script>

<style>
    .app__home-tests {
        margin: 0 0 25px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }
    .app__home-tests__item {
        cursor: pointer;
        padding: 10px;
        width: 100%;
        background-color: var(--clr-primary);
        border: 2px solid var(--clr-secondary);
        border-radius: 4px;
    }
</style>