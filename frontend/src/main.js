import { createApp } from 'vue'
import { createPinia } from 'pinia'
import vue3GoogleLogin from 'vue3-google-login'

import App from './App.vue'
import router from './router'
import './assets/main.css';
import '../src/style.css';

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(vue3GoogleLogin, {
    clientId: '216752811262-revug38enik2q262uuf9mlms4tpe5fol.apps.googleusercontent.com'
})

app.mount('#app')
