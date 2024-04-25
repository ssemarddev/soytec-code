import { computed } from "vue"
import Sidebar from "./Sidebar.vue"
import NotFound from "../errors/NotFound.vue"
import DashboardRoute from "./DashboardRoute.js"

export default {
    components: { NotFound, Sidebar },
    data() {
        const hash = window.location.hash
        const active = hash == "" ? "home" : hash.substring(1)
        return {
            collapse: true,
            active: active,
        }
    },
    props: {
        user: {
            type: Object,
            default: {
                avatar: "avatar_1.jpg",
                name: "Cargando...",
                level: "Cargando...",
            },
        },
        buttons: Array,
    },
    methods: {
        /**
         * Despliega o colapsa el menú lateral del dashboard
         */
        toogle() {
            this.collapse = !this.collapse
        },
        /**
         * Mostrar el componente seleccionado si existe o mostrar información en pantalla si el componente no existe
         * @param {String} componentLink: Link del componente a mostrar
         */
        showComponent(componentLink) {
            if (componentLink == "") {
                this.active = "home"
            } else {
                if (this.isComponentExist(componentLink)) {
                    this.active = componentLink.substring(1)
                } else {
                    this.active = "NotFound"
                }
            }
        },
        /**
         * Retorna true si el componente existe o false si no existe
         * @param {String} name: Nombre del componente
         * @return {Boolean}: <code>true</code> si el componente existe o <code>false</code> si no existe
         */
        isComponentExist(name) {
            return this.buttons.find((button) => {
                if (button.href == name) return true
            })
        },
        temp() {
            console.log("sito")
        },
    },
    provide() {
        return {
            loggedUser: computed(() => this.user),
        }
    },
    mounted() {
        this.emitter.on("select-component", this.select)
        const hash = window.location.hash
        window.onhashchange = () => {
            this.showComponent(window.location.hash)
        }
        if (hash == "") return
        const exist = this.buttons.find((button) => {
            if (button.href == hash) return true
        })
        if (!exist) this.active = "NotFound"
    },
}
