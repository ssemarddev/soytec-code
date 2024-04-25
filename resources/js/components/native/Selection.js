/**
 * Maneja la selección de filas de la tabla
 */
export default class Selection {
    constructor() {
        /**
         * Ids de los datos de las filas seleccionadas de la tabla
         * @type {Array<number>}
         * @member
         */
        this.ids = []
    }

    /**
     * Añadir una fila de la tabla a la selección por el id de sus datos
     * @param {number} id Id de los datos de la fila a añadir
     */
    add(id) {
        this.ids.push(id)
    }

    /**
     * Eliminar una fila de la tabla de la selección por el id de sus datos
     * @param {number} id Id de los datos de la fila a eliminar
     */
    remove(id) {
        const index = this.ids.indexOf(id)
        this.ids.splice(index, 1)
    }

    /**
     * Cambia la selección de los registros de la tabla
     * @param {Array<Object>} items Datos de los registros a cambiar su selección
     * @param {} checked <code>true</code> si es para añadir a la selección o <code>false</code> si es para eliminar de la selección
     */
    toogle(items, checked) {
        for (let item of items) {
            const index = this.ids.indexOf(item.id)
            if (checked) {
                if (index == -1) this.add(item.id)
            } else {
                if (index >= 0) this.remove(item.id)
            }
        }
    }

    /**
     * Obtener los registros de la tabla seleccionados de un grupo de registros pasados en el argumento
     * @param {Array<Object>} items Datos de los registros a verificar si están seleccionados o no
     * @return {Array<Object>} Registros pertenecientes al argumento "items" que están seleccionados
     */
    getSelectedIdsInArray(items) {
        const selection = []
        this.ids.map((id) => {
            items.map((item) => {
                if (item.id == id) selection.push(id)
            })
        })
        return selection
    }

    /**
     * Obtener la cantidad de registros seleccionados
     * @return {number} Cantidad de registros seleccionados
     */
    size() {
        return this.ids.length
    }

    /**
     * Verifica si los registros pasados en el argumento están seleccionados
     * @param {Array<Object>} items Datos de los registros a verificar si están seleccionados
     * @return {boolean} <code>true</code> si todos los registros pasados en el argumento están seleccionados o <code>false</code> si al menos un registro no está seleccionado
     */
    contains(items) {
        for (let item of items) {
            if (!this.ids.includes(item.id)) return false
        }
        return true
    }
}
