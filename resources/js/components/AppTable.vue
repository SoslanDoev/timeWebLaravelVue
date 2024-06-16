<template>
    <div v-if="!tdList.length || !thList.length">
        <h2 class="title">Таблица пуста</h2>
    </div>
    <table class="app-table" v-else>
        <thead class="app-table__thead">
            <tr>
                <th v-for="(key, idx) in thList" :key="idx">{{ key }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, rowIndex) in tdList" :key="rowIndex">
                <td class="hover" v-for="(key, colIndex) in thList" :key="colIndex">
                    {{ row[key] || "Пусто" }}
                </td>
                <td class="app-table__btn" @click.prevent="emit('update', row)">Обновить</td>
                <td class="app-table__btn" @click.prevent="emit('destroy', row)">Удалить</td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue';
    
    const emit = defineEmits(["update", "destroy"]);

    const props = defineProps({
        thList: {
            type: Array,
            required: true,
        },
        tdList: {
            type: Array,
            required: true,
        },
    });
</script>

<style scoped>
.app-table {
    text-align: center;
    width: 100%;
    /* border-collapse: collapse; */
    margin: 20px 0;
    font-size: 18px;
}

.app-table__thead th {
    background-color: var(--clr-primary);
    color: var(--clr-secondary);
    font-weight: bold;
    padding: 10px;
    border: 3px solid var(--clr-secondary);
    border-radius: 4px;
}

.app-table tbody tr {
    background-color: var(--clr-primary);
    color: var(--clr-secondary);
}

.app-table tbody tr:hover {
    /* background-color: #fffcc8; */
    /* opacity: .9; */
}

.app-table tbody td {
    padding: 5px 10px;
    border: 3px solid var(--clr-secondary);
    border-radius: 4px;
}

.app-table__btn {
    cursor: pointer;
}


</style>