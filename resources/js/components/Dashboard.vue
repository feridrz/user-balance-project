<template>
    <div class="card shadow-sm h-100">
        <div class="card-body">
            <h5 class="card-title mb-2">Текущий баланс</h5>
            <p class="display-5 fw-bold text-primary">{{ balance.toFixed(2) }} ₽</p>

            <h6 class="mt-4 mb-2">Последние операции</h6>

            <ul v-if="transactions.length" class="list-group list-group-flush">
                <li
                    v-for="t in transactions"
                    :key="t.id"
                    class="list-group-item d-flex justify-content-between align-items-center"
                >
                    <div class="me-2 text-truncate" style="max-width: 200px;">
                        {{ t.description }}
                    </div>
                    <div
                        :class="{
              'text-success fw-semibold': t.amount > 0,
              'text-danger fw-semibold': t.amount < 0,
            }"
                    >
                        {{ t.amount > 0 ? '+' : '' }}{{ t.amount.toFixed(2) }}
                    </div>
                </li>
            </ul>

            <div v-else class="text-muted mt-2 text-center">
                Нет операций
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const balance = ref(0);
const transactions = ref([]);

const fetchData = async () => {
    try {
        const res = await axios.get('/api/dashboard');

        balance.value = Number(res.data.balance);
        transactions.value = res.data.transactions.map(t => ({
            ...t,
            amount: Number(t.amount),
        }));
    } catch (e) {
        console.error('Ошибка при загрузке данных:', e);
    }
};

onMounted(() => {
    fetchData();
    setInterval(fetchData, 5000);
});
</script>
