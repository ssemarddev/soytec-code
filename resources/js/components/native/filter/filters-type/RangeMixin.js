export default {
    data() {
        return {
            /**
             * Límite mínimo (entrada del usuario)
             * @type String
             */
            start: "",
            /**
             * Límite máximo (entrada del usuario)
             * @type String
             */
            end: "",
        }
    },
    methods: {
        /**
         * Crear el parámetro de búsqueda (límite mínimo y límite máximo) a partir de las dos entradas del usuario
         * @param {String} param Nombre del parámetro de búsqueda
         */
        assign(param) {
            //Comporbar si se han introducido los dos valores
            if (this.start != "" && this.start != "") {
                if (this.column.type == "date") {
                    //Si la columna es del tipo Date crear la fecha de inicio y fecha de fin
                    this.params[param] = {
                        start: new Date(this.start),
                        end: new Date(this.end),
                    }
                } else {
                    //Si la columna es de otro tipo (number) crear los límites mínimo y máximo
                    this.params[param] = {
                        start: this.start,
                        end: this.end,
                    }
                }
            } else {
                this.params[param] = ""
            }
            //Notificar cambio en el parámetro de búsqueda
            this.change()
        },
    },
}
