<script>
    import Modal from "../native/modal/Modal.js"
    import ModalButton from "../native/modal/ModalButton.js"

    export default {
        props: {
            service: {
                type: Object,
                default: {},
            },
            index: Number,
        },
        methods: {
            remove() {
                const modal = new Modal({
                    title: "Confirmar operación",
                    background: "#f55555",
                    icon: "bi bi-exclamation-triangle",
                    description: "¿Seguro que quieres eliminar este servicio?",
                    accept: new ModalButton({
                        classes: "btn-danger",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        this.service.remove = true
                    }
                })
            },
        },
    }
</script>

<style scoped>
    textarea {
        min-height: 5rem;
    }
</style>

<template>
    <div v-if="service.remove !== true">
        <button @click="remove" type="button" class="btn btn-danger btn-sm float-end"><i class="bi bi-trash"></i> Eliminar</button>
        <div class="row my-3">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" :name="'services[' + index + '][name]'" placeholder="Nombre del servicio" :value="service.name" />
                    <label>Nombre del servicio <i class="bi bi-check-all"></i></label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" :name="'services[' + index + '][cost]'" placeholder="Costo del servicio" :value="service.cost" />
                    <label>Costo del servicio <i class="bi bi-check-all"></i></label>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" :name="'services[' + index + '][time]'" placeholder="Costo del servicio" :value="service.time" />
                    <label>Tiempo del servicio <i class="bi bi-check-all"></i></label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating mb-1">
                    <textarea class="form-control" :name="'services[' + index + '][description]'" placeholder="Descripción del servicio">{{ service.description }}</textarea>
                    <label>Descripción del servicio <i class="bi bi-check-all"></i></label>
                </div>
            </div>
        </div>
    </div>
</template>
