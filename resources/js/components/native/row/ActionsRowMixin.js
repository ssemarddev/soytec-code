export default {
    /**
     * @inject columns: CustomTable
     * @inject actions: CustomTable
     * @inject id: CustomTable
     */
    inject: ["columns", "actions", "id"],
    props: {
        /**
         * <code>true</code> si se muestran los detalles de la fila o <code>false</code> si no
         */
        details: Boolean,
        /**
         * Datos de la fila
         */
        item: Object,
    },
    data() {
        return {
            /**
             * Colspan a usar para agrupar las columnas cuando se muestren los detalles de la fila
             */
            colspan: Object.keys(this.columns).length + 1
        }
    },
    methods: {
        /**
         * Emite un evento para una acción sobre los registros de la tabla
         * @param {Action} action Acción que fue disparada
         * @event TableActionEvent
         */
        emit(action) {
            if (action.single) {
                this.emitter.emit(`${this.id}-${action.event}`, this.item)
            } else {
                this.emitter.emit(`${this.id}-${action.event}`, [this.item.id])
            }
        },
    },
}
