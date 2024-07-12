<template>
    <div class="fav">
        <div class="container">
            <div class="fav__inner">
                <h2>Избранные</h2>
                <div v-if="fav && !fav.length">Пусто</div>
                <div v-else>{{ fav }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref, onMounted, computed } from "vue"
    import axios from "axios"
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';

    const store = useStore();
    const user = ref(null)
    user.value = computed(() => store.state.user)
    
    console.log("123123", user.value)
    const fav = ref([])

    const get = async () => {
        console.log(`/api/favorites/${Number(user.value["id"])}`)
        try {
            const res = await axios.get(`/api/favorites/${Number(user.value["id"])}`)
            fav.value = res.data?.data?.data || res.data?.data || res.data;
            console.log(res)
        } catch(err) {
            console.log(err)
        }
    }; get()
</script>