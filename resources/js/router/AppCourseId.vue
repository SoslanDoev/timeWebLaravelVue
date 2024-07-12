<template>
    <div class="course__page">
        <div class="container">
            <div class="course__page-inner">
                <router-link to="/">Назад</router-link>
                <h2 class="title">{{ course.name }}</h2>
                <div v-html="course.html"></div>
                <div v-if="btnFavorDiv === true">
                    <button v-if="btnFavor == true" class="btn" @click.prevent="favorDelete">Отписаться на курс</button>
                    <button v-else class="btn" @click.prevent="favorAdd">Записаться на курс</button>
                </div>
                <button v-if="btnDelete" class="btn" @click.destroy="deleteCourse">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { useRoute, useRouter } from 'vue-router';
    import { ref, computed, onMounted } from "vue"
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';
    const store = useStore();
    const btnDelete = ref(false)
    
    const user = ref({})

    import axios from "axios"
    const btnFavor = ref(false)
    const btnFavorDiv = ref(false)

    const route = useRoute();
    const router = useRouter();
    
    const pageId = ref(null)
    const course = ref({name: "", html: null})

    onMounted(async () => {
        user.value = computed(() => store.state.user)
        pageId.value = route.params.id;
        try {
            const response = await axios.get(`/api/course/${pageId.value}`)
            course.value = response.data?.data?.data || response.data?.data || response.data
        } catch (err) {
            console.log(err)
        }
        if (course.value.user.id === store.state.user['id']) {
            btnDelete.value = true
        }
        if (store.state.user["role"] === "0" || store.state.user["role"] === 0 ) {
            btnFavorDiv.value = true
        }
        const res = await axios.get(`/api/favorites/${store.state.user["id"]}/${pageId.value}`)
        const newData = res.data?.data?.data || res.data?.data || res.data;
        if (newData === 1) {
            btnFavor.value = true
        } 
    })
    const deleteCourse = async () => {
        const id = Number(pageId.value)
        try {
            const response = await axios.delete(`/api/course/${id}`)
            router.push({ name: 'Home' });
        } catch (err) {
            console.log(err)
        }
    }
    const favorAdd = async () => {
        try {
            const response = await axios.post(`/api/favorites`, {
                "user_id": Number(store.state.user['id']),
                "course_id": Number(pageId.value)
            })
            btnFavor.value = true
        } catch (err) {
            console.log(err)
        }
    }
    const favorDelete = async () => {
        try {
            // const response = await axios.delete(`/api/favorites`, {
            //     "user_id": Number(store.state.user['id']),
            //     "course_id": Number(pageId.value)
            // })
            const response = await axios.delete(`/api/favorites/${Number(store.state.user['id'])}/${Number(pageId.value)}`)
            btnFavor.value = false
        } catch (err) {
            console.log(err)
        }
    }
</script>