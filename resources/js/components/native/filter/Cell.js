import Column from "../Column.js"
/**
 * @class Representa una celda de la tabla, maneja las funciones de filtrado de datos
 */
export default class Cell {
    /**
     *
     * @param {Column} column: Columna de la celda
     * @param {Object} row: Datos de la fila
     */
    constructor(column, row) {
        /**
         * @member
         * @type Column
         */
        this.column = column
        this.row = row
    }

    /**
     * Filtra los datos de una celda según el parámetro de búsqueda pasado
     *
     * @param {String|Object} param: Cadena de búsqueda a filtrar
     * @param {Boolean} caseSensitive: <code>true</code> si la búsqueda distinguirá entre mayúsculas y minúsculas
     * @returns {Boolean}: <code>true</code> si la celda coincide con el parámetro de filtrado o <code>false</code> si no coincide
     */
    filter(param, caseSensitive = false) {
        if (param == "") return true

        if (typeof param == "object" || caseSensitive) {
            return this.compare(param)
        } else {
            return this.compare(param.toLowerCase())
        }
    }

    /**
     * Compara los datos de la celda con el parámetro pasado según el tipo de columna
     *
     * @param {String|Object} param: Parámetro de búsqueda
     * @returns <code>true</code> si la celda coincide con el parámetro de filtrado o <code>false</code> si no coincide
     */
    compare(param) {
        //Filtrar el parámetro de acuerdo al tipo de datos de la columna
        switch (this.column.type) {
            case "text":
            case "email":
            case "url":
            case "tel":
                //Comparar si el registro tiene la subcadena de búsqueda
                return this.row.includes(param.toString())
            case "number":
            case "radio":
            case "select":
                //Comparar si el registro es igual a la cadena de búsqueda
                return this.row == param
            case "tags":
                param = param.split(",")
                this.row = this.row.split(",")
                for (let tag of param) {
                    if (this.row.indexOf(tag) >= 0) {
                        return true
                    }
                }
                return false
            case "date":
                this.row = new Date(this.row)
                if (this.row < param.start || this.row > param.end) return false
                return true
            case "range":
                this.row = Number(this.row)
                if (this.row < param.start || this.row > param.end) return false
                return true
        }
    }
}
