<script>
    import Modal from "../native/modal/Modal.js"
    import ModalButton from "../native/modal/ModalButton.js"
    import Request from "../../Request.js"

    export default {
        props: {
            color: {
                type: Object,
                default: {},
            },
            index: Number,
        },
        data() {
            return {
                previews: [],
            }
        },
        methods: {
            remove() {
                const modal = new Modal({
                    title: "Confirmar operación",
                    background: "#f55555",
                    icon: "bi bi-exclamation-triangle",
                    description: "¿Seguro que quieres eliminar este color?",
                    accept: new ModalButton({
                        classes: "btn-danger",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        this.$emit("remove", this.index)
                    }
                })
            },
            deleteImage(id) {
                const modal = new Modal({
                    title: "Confirmar operación",
                    background: "#f55555",
                    icon: "bi bi-exclamation-triangle",
                    description: "¿Seguro que quieres eliminar esta imagen?",
                    accept: new ModalButton({
                        classes: "btn-danger",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        Request.delete(`api/images/${id}`, new FormData()).then((response) => {
                            for (const i in this.color.images) {
                                if (this.color.images[i].id == id) {
                                    this.color.images.splice(i, 1)
                                    break
                                }
                            }
                        })
                    }
                })
            },
        },
        mounted() {
            const input = this.$el.querySelector("[type='file']")
            input.addEventListener("change", () => {
                const files = input.files
                this.previews = []
                for (const file of files) {
                    this.previews.push(URL.createObjectURL(file))
                }
            })
        },
    }
</script>

<style scoped>
    textarea {
        min-height: 5rem;
    }
</style>

<template>
    <div>
        <button @click="remove" type="button" class="btn btn-danger btn-sm float-end"><i class="bi bi-trash"></i> Eliminar</button>
        <div class="row mt-3">
            <input v-if="color.id !== undefined" type="hidden" :name="'colors[' + index + '][id]'" :value="color.id" />
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" :name="'colors[' + index + '][name]'" placeholder="Nombre del color" v-model="color.name" />
                    <label>Nombre del color <i class="bi bi-check-all"></i></label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input type="color" class="form-control" :name="'colors[' + index + '][color]'" placeholder="Valor del color" v-model="color.color" />
                    <label>Valor del color <i class="bi bi-check-all"></i></label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <input class="form-control form-control-sm" id="image" :name="'colors[' + index + '][]'" type="file" multiple />
            </div>
        </div>
        <div class="previews">
            <div v-if="color.images !== undefined" v-for="image in color.images" class="preview">
                <button type="button" @click="deleteImage(image.id)" class="btn-close"></button>
                <img :src="image.url" />
            </div>
            <div class="preview" v-for="preview in previews">
                <img :src="preview" />
            </div>
        </div>
    </div>
</template>

<style scoped>
    input[type="color"]:not(:placeholder-shown) {
        border-radius: 0;
        padding: 0.15rem !important;
    }
    .previews {
        display: grid;
        max-width: 100%;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        grid-gap: 0.5rem;
        text-align: center;
    }
    .preview {
        border-radius: 0.5rem;
        border: solid 1px #d8d8d8;
        padding: 0.25rem;
        position: relative;
    }
    .preview > img {
        max-width: 100%;
        border-radius: 0.5rem;
        max-height: 200px;
    }
    .preview > button {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
</style>
