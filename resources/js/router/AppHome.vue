<template>
    <div class="app">
        <div class="container">
            <div class="app__inner">
                <div class="app__course-list" style="display: flex; align-items: center; gap: 15px;"> 
                    <div v-for="item in courses" :key="item.id" style="cursor: pointer;">
                        <div @click.prevent="courseItem(item.id)">
                            <h3>{{ item.name }}</h3>
                            <p>Автор: {{ item.user.name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, onMounted } from "vue"
    import { useRouter } from 'vue-router';
    import axios from "axios"

    const router = useRouter();
    const courses = ref([])

    const courseItem = (id) => {
        router.push({ name: 'AppCourseId', params: { id } });
    }

    const getAllCourse = async () => {
        try {
            const response = await axios.get("/api/course")
            courses.value = response.data?.data?.data || response.data?.data || response.data
        } catch (err) {
            console.log(err)
        }
    }
    onMounted(() => {
        getAllCourse()
    })
</script>

<style>
    .app__course-list {
        display: flex;
    }
</style>