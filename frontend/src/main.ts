import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import {createAuth0} from "@auth0/auth0-vue";
import authConfig from "../auth_config.json";

const app = createApp(App)

app
    .use(
        createAuth0({
            domain: authConfig.domain,
            clientId: authConfig.clientId,
            authorizationParams: {
                redirect_uri: window.location.origin,
                audience: authConfig.audience,
            }
        })
    )
    .mount('#app')
