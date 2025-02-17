import '../css/app.css';

import { createApp } from 'vue';

import CreditOffers from './components/CreditOffers.vue';

const app = createApp({});
app.component("credit-offers", CreditOffers);
app.mount("#app");
