import Tooltip from "bootstrap/js/dist/tooltip"
import Column from "../Column.js"

const TEXT_SORT_DESC = "bi bi-sort-alpha-down"
const TEXT_SORT_ASC = "bi bi-sort-alpha-down-alt"
const NUMBER_SORT_DESC = "bi bi-sort-numeric-down"
const NUMBER_SORT_ASC = "bi bi-sort-numeric-down-alt"
const GENERAL_SORT_DESC = "bi bi-sort-down-alt"
const GENERAL_SORT_ASC = "bi bi-sort-down"

export default {
    /**
     * @inject columns: CustomTable
     * @inject data: CustomTable
     */
    inject: ["columns", "data"],
    props: {
        /**
         * Id de la columna
         */
        id: String,
        /**
         * Datos de la columna
         */
        column: Column,
    },
    methods: {
        /**
         * Organiza las filas de forma ascendente o descendente según los datos de la columna
         */
        sort() {
            //Si las filas no están organizadas según los datos de esta columna organizar de forma ascendente y si ya está organizada de forma ascendente organizar de forma descendente
            const sort = this.column.sort == "DESC" ? "ASC" : "DESC"
            for (let key in this.columns) {
                this.columns[key].sort = undefined
            }
            this.column.sort = sort
            //Llamar a la función sort y pasarle una función personalizada para ordenar
            const _this = this
            this.data.sort((a, b) => {
                //Si la columna está ordenada de forma ascendente ordenarla de forma descendente y viceversa
                if (a[this.id] < b[this.id]) {
                    return sort == "DESC" ? -1 : 1
                } else if (a[this.id] > b[this.id]) {
                    return sort == "DESC" ? 1 : -1
                } else {
                    return 0
                }
            })
        },
    },
    computed: {
        /**
         * 
         * @returns Ícono que muestra si la columna está organizada de forma ascendente, descendente o no está organizada
         */
        orderIcon() {
            if (this.column.sort == undefined) {
                return ""
            } else if (this.column.sort == "ASC") {
                switch (this.column.type) {
                    case "text":
                    case "email":
                        return TEXT_SORT_ASC
                    case "number":
                        return NUMBER_SORT_ASC
                    default:
                        return GENERAL_SORT_ASC
                }
            } else {
                switch (this.column.type) {
                    case "text":
                    case "email":
                        return TEXT_SORT_DESC
                    case "number":
                        return NUMBER_SORT_DESC
                    default:
                        return GENERAL_SORT_DESC
                }
            }
        },
    },
    mounted() {
        new Tooltip(this.$el)
    },
}
