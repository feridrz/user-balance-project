<template>
    <div class="card shadow-sm h-100">
        <div class="card-body">
            <h5 class="card-title">История операций</h5>

            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    v-model="search"
                    placeholder="Поиск по описанию"
                    @keyup.enter="load(1)"
                />
                <button class="btn btn-outline-secondary" @click="load(1)">Найти</button>
            </div>

            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th @click="toggleSort" role="button" style="user-select: none;">
                        Дата
                        <i :class="sort === 'asc' ? 'bi-caret-up' : 'bi-caret-down'"></i>
                    </th>
                    <th>Описание</th>
                    <th class="text-end">Сумма</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="t in data.data" :key="t.id">
                    <td>{{ formatDate(t.created_at) }}</td>
                    <td>{{ t.description }}</td>
                    <td
                        class="text-end"
                        :class="{ 'text-success': t.amount > 0, 'text-danger': t.amount < 0 }"
                    >
                        {{ t.amount > 0 ? '+' : '' }}{{ Number(t.amount).toFixed(2) }}
                    </td>
                </tr>
                </tbody>
            </table>

            <nav v-if="data.total > data.per_page">
                <ul class="pagination justify-content-center">
                    <li :class="['page-item', { disabled: !data.prev_page_url }]">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="data.prev_page_url && load(data.current_page - 1)"
                        >
                            Назад
                        </a>
                    </li>
                    <li :class="['page-item', { disabled: !data.next_page_url }]">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="data.next_page_url && load(data.current_page + 1)"
                        >
                            Вперёд
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';

const data = ref({ data: [] });
const search = ref('');
const sort = ref('desc');

const load = async (page = 1) => {
    const params = new URLSearchParams({
        page,
        search: search.value,
        sort: sort.value,
    });

    try {
        const res = await axios.get('/api/transactions?' + params.toString());

        data.value = res.data;
    } catch (e) {
        console.error('Ошибка при получении данных:', e);
    }
};

const toggleSort = () => {
    sort.value = sort.value === 'asc' ? 'desc' : 'asc';
    load();
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

watchEffect(() => {
    load();
});
</script>
