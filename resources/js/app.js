require('./bootstrap');

import { createApp } from 'vue';
import Calculator from './components/Calculator.vue';

createApp({
    components: {
        Calculator,
    }
}).mount('#calculator');
