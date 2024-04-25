export default {
    /**
     * @inject config: CustomTable
     */
    inject: ["config"],
    methods: {
        /**
         * Cambia el número de filas visibles por página
         * @param {Event} e Evento del DOM que disparó el método
         */
        change(e) {
            //Obtener el número introducido por el usuario
            const value = parseInt(e.target.value)
            if (isNaN(value) || value == 0) {
                //Si es un número no es válido o si es 0 establecer número de filas visibles por página en 1
                this.config.rows = 1
            } else if (value < 0) {
                //Si es negativo convertir en positivo
                this.config.rows = value * -1
            } else {
                //Establecer número de filas visibles por página
                this.config.rows = value
            }
        },
    },
}
