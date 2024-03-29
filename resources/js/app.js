import './bootstrap';
import 'flowbite';
import Alpine from 'alpinejs'
 
window.Alpine = Alpine
 
Alpine.start()

//for vue components
import { createApp } from 'vue';
import InvoiceCreateApp from './vue/InvoiceCreateApp.vue'
import InvoiceEditApp from './vue/InvoiceEditApp.vue'

const invoiceCreateApp = createApp(InvoiceCreateApp);
const invoiceEditApp = createApp(InvoiceEditApp);

invoiceCreateApp.mount('#invoice-create-app');
invoiceEditApp.mount('#invoice-edit-app');