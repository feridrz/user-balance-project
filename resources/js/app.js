import { createApp } from 'vue';
import Dashboard from './components/Dashboard.vue';
import TransactionHistory from './components/TransactionHistory.vue';
import 'bootstrap/dist/js/bootstrap.bundle';
import '../scss/app.scss';

const app = createApp({});

app.component('Dashboard', Dashboard);
app.component('TransactionHistory', TransactionHistory);

app.mount('#app');
