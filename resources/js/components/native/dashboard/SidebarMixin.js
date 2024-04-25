import Tooltip from "bootstrap/js/dist/tooltip"
import DashboardRoute from "./DashboardRoute.js"

export default {
    props: {
        /**
         * Link del componente activo
         */
        active: {
            type: String,
            default: "NotFound",
        },
        /**
         * Enlaces a las diferentes páginas del módulo
         * @type Array<DashboardRoute>
         */
        buttons: Array,
        /**
         * <code>true</code> si la barra lateral está colapsada o <code>false</code> si está desplegada
         */
        collapse: {
            type: Boolean,
            default: true,
        },
        user: Object,
    },
    mounted() {
        const tooltipList = [...this.$el.querySelectorAll('[data-bs-toggle="tooltip"]')]

        tooltipList.map((el) => new Tooltip(el))
    },
}
