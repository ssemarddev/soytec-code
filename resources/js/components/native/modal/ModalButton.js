/**
 * Manejas las configuraciones de los botones del modal
 */
export default class ModalButton {
    /**
     * @param {boolean} show <code>true</code> si se mostrará el botón o <code>false</code> si no
     * @param {String} color Color del texto del botón
     * @param {String} text Texto del botón
     * @param {String} icon Clase a pasarle al botón
     * @param {String} classes Clases a pasarle al botón
     */
    constructor({ show = true, color = "inherit", text = "Aceptar", icon = "", classes = "" }) {
        this.show = show
        this.color = color
        this.text = text
        this.icon = icon
        this.classes = classes
    }
}
