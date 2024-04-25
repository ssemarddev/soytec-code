//import "./bootstrap"
import { createApp } from "vue"
import mitt from "mitt"
import Utils from "./Utils.js"
import Root from "./components/Root.vue"

/** Importar componentes de cada módulo */
import Home from "./components/home/Home.vue"
import Categories from "./components/categories/Categories.vue"
import Clients from "./components/clients/Clients.vue"
import Providers from "./components/providers/Providers.vue"
import Store from "./components/store/Store.vue"
import Inventory from "./components/inventory/Inventory.vue"
import Sales from "./components/sales/Sales.vue"
import Shopping from "./components/shopping/Shopping.vue"
import Workshop from "./components/workshop/Workshop.vue"
import Admins from "./components/admins/Admins.vue"
import Reviews from "./components/reviews/Reviews.vue"
import Quotations from "./components/quotations/Quotations.vue"
import Chats from "./components/chats/Chats.vue"

const app = createApp(Root)
app.component("home", Home)
app.component("categories", Categories)
app.component("clients", Clients)
app.component("providers", Providers)
app.component("store", Store)
app.component("inventory", Inventory)
app.component("sales", Sales)
app.component("shopping", Shopping)
app.component("workshop", Workshop)
app.component("admins", Admins)
app.component("reviews", Reviews)
app.component("quotations", Quotations)
app.component("Chats", Chats)

app.config.globalProperties.Utils = Utils

app.config.unwrapInjectedRef = true

/** Implementar bus de eventos */
const emitter = mitt()
app.config.globalProperties.emitter = emitter

app.mount("#app")
