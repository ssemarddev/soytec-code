import ActionsRow from "./ActionsRow.vue"

export default {
    /**
     * @inject columns: CustomTable
     * @inject actions: CustomTable
     * @inject selection: CustomTable
     * @inject id: CustomTable
     */
    inject: ["columns", "actions", "selection", "id"],
    components: { ActionsRow },
    props: {
        /**
         * Datos de la fila
         */
        item: Object,
    },
    data() {
        return {
            /**
             * <code>true</code> si se muestran los detalles de la fila o <code>false</code> si no
             * @type {boolean}
             */
            details: false,
        }
    },
    methods: {
        /**
         * Alternar selección de la fila
         * @param {Event} e
         */
        toogleCheck(e) {
            //Determinar si se seleccionó la fila o se deseleccionó
            if (e.target.checked) {
                //Añadir a la selección
                this.selection.add(this.item.id)
            } else {
                //Eliminar de la selección
                this.selection.remove(this.item.id)
            }
        },
        /**
         * Mostrar u ocultar detalles de la fila
         * @param {Event} e
         */
        toogleDetails(e) {
            if (e.target.nodeName == "TD") {
                this.details = !this.details
            }
        },
    },
    computed: {
        /**
         * <code>true</code> si la fila está seleccionada o <code>false</code> si no
         * @returns
         */
        checked() {
            return this.selection.contains([this.item])
        },
    },
}
