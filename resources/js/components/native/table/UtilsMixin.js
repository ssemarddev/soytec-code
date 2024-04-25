import Alert from "../alert/Alert.js"
import AlertConfig from "../alert/AlertConfig.js"

export default {
    methods: {
        /**
         * Agrega un registro a la tabla y muestra una notificación
         * @param {Object} item Datos del registro a agregar
         * @param {String} message Texto de la notificación
         */
        oncreated(item, message) {
            this.backup.push(item)
            this.notify({ icon: "bi bi-check2-square", text: message })
            // this.change = true
            this.emitter.emit(`${this.id}-data-change`)
        },
        /**
         * Actualiza registros en la tabla y muestra una notificación
         * @param {Array<number>} ids Ids de los registros a actualizar
         * @param {Object} item Datos del registro a actualizar
         * @param {String} message Texto de la notificación
         */
        onupdated(ids, data, message) {
            for (let id of ids) {
                //Actualizar copia de los datos
                for (let item of this.backup) {
                    if (item.id == id) {
                        for (let j in data) {
                            item[j] = data[j]
                        }
                        break
                    }
                }
            }
            // this.change = true
            this.emitter.emit(`${this.id}-data-change`)
            this.notify({ icon: "bi bi-check2-square", text: message })
        },
        /**
         * Elimina registros de la tabla y muestra una notificación
         * @param {Array<number>} ids Ids de los registros a eliminar
         * @param {String} message Texto de la notificación
         */
        onremoved(ids, message) {
            for (let id of ids) {
                const i = this.selection.remove(id)
                //Eliminar de la copia local
                for (let j in this.backup) {
                    if (this.backup[j].id == id) {
                        this.backup.splice(j, 1)
                        break
                    }
                }
                // this.change = true
                this.emitter.emit(`${this.id}-data-change`)
            }
            this.notify({ icon: "bi bi-check2-square", text: message })
        },
        /**
         * Muestra una notificación
         * @param {Object} config Configuración de la notificación
         */
        notify(config) {
            const alert = new Alert(
                new AlertConfig({
                    title: "¡Operación exitosa!",
                    text: config.text,
                    icon: config.icon,
                    color: "#198754",
                })
            )
            alert.fire()
        },
    },
}
