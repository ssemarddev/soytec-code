<script>
    import FiltersType from "./FiltersTypeMixin.js"

    export default {
        /**
         * @mixin: ./FiltersTypeMixin.js
         */
        mixins: [FiltersType],
        data() {
            return {
                /**
                 * Entrada del usuario
                 * @type String
                 */
                input: "",
            }
        },
        computed: {
            /**
             * Etiquetas introducidas por el usuario
             * @type array<String>
             */
            tags() {
                if (this.params[this.column.id] !== undefined) {
                    return this.params[this.column.id].split(",")
                } else {
                    return []
                }
            },
        },
        methods: {
            /**
             * Añadir entrada del usuario a las etiquetas del parámetro de búsqueda
             */
            select() {
                //Comprobar que la entrada del usuario no esté vacía
                if (this.input !== "") {
                    //Añadir a la lista de etiquetas
                    this.tags.push(this.input)
                    //Limpiar entrada del usuario
                    this.input = ""
                    //Actualizar parámetro de búsqueda (Etiquetas separadas por comas)
                    this.params[this.column.id] = this.tags.join(",")
                    //Notificar de cambio en el parámetro
                    this.change()
                }
            },
            /**
             * Eliminar una etiqueta de la lista de etiquetas del parámetro de búsqueda
             * @param {String} tag Etiqueta a eliminar
             */
            unselect(tag) {
                //Obtener el índice de la etiqueta a eliminar
                const index = this.tags.indexOf(tag)
                //Comprobar si existe la etiqueta
                if (index >= 0) {
                    //Eliminar de la lista de eqtiquetas
                    this.tags.splice(index, 1)
                    //Actualizar parámetro de búsqueda (Etiquetas separadas por comas)
                    this.params[this.column.id] = this.tags.join(",")
                    //Notificar de cambio en el parámetro
                    this.change()
                }
            },
        },
    }
</script>

<style scoped>
    div > span:not(.input-group-text) {
        margin: 0.15rem;
    }
</style>

<template>
    <div>
        <span class="badge bg-secondary" v-for="(tag, index) in tags" @click="unselect(tag)">{{ tag }} <i class="bi bi-x"></i></span>
    </div>
    <div class="input-group">
        <span class="input-group-text"><i :class="column.icon"></i></span>
        <input @keyup.enter="select" @input.stop="" @change.stop="" type="text" placeholder="Etiquetas" class="form-control" v-model="input" />
        <button @click="select" class="btn btn-outline-secondary" type="button"><i class="bi bi-hand-index-fill"></i></button>
    </div>
</template>
