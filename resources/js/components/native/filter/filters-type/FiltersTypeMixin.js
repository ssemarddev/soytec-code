import Column from "../../Column.js"

export default {
    emits: ["change"],
    props: {
        /**
         * Todos los parámetros de búsuqeda
         */
        params: Object,
        /**
         * Columna a la que está asociado este parámetro de búsqueda
         */
        column: Column,
    },
    methods: {
        /**
         * Notificar sobre cambios el parámetro de búsqueda
         * @event change
         */
        change() {
            this.$emit("change")
        },
    },
}
