<script>
import "bootstrap/js/dist/collapse"
import Params from "./Params.vue"
import Response from "./Response.vue"
import Modal from "../../../components/native/modal/Modal.js"
import ModalButton from "../../../components/native/modal/ModalButton.js"
import RequestModal from "../components/modal/RequestModal.vue"
import ResponseModal from "../components/modal/ResponseModal.vue"
import Request from "../../../Request"

const BACKGROUNDS = {
    GET: 'rgba(13, 171, 245, 0.7)',
    POST: 'rgb(11, 175, 46, 0.7)',
    PUT: 'rgb(255, 193, 7 ,0.7)',
    DELETE: 'rgba(245, 48, 13, 0.7)'
}
export default {
    components: { Params, Response },
    props: {
        route: Object,
    },
    data() {
        return {
            id: Math.floor(Math.random() * 10000000000),
            background: BACKGROUNDS[this.route.type]
        }
    },
    methods: {
        request() {
            const modal = new Modal(
                {
                    window: `Petición (${this.route.path})`,
                    accept: new ModalButton({
                        text: "Enviar",
                        icon: "bi bi-printer",
                        classes: "btn-success",
                    }),
                    cancel: new ModalButton({
                        text: "Cancelar",
                        icon: "bi bi-x-circle",
                        classes: "btn-secondary",
                    }),
                    close: new ModalButton({}),
                },
                RequestModal,
                [{ route: this.route }]
            )
            modal.fire().then((result) => {
                if (result.status == "accept") {
                    const form = document.querySelector('#requestForm')
                    const data = new FormData(form)
                    const url = window.location.origin + '/' + data.get('url')
                    if (url.includes("{")) {
                        alert('no se puede procesar')
                    } else {
                        data.delete('url')
                        switch (this.route.type) {
                            case 'GET':
                                Request.get(url).then((response) => {
                                    this.showResponse(response)
                                })
                                break
                            case 'DELETE':
                                Request.delete(url, data).then((response) => {
                                    this.showResponse(response)
                                })
                                break
                            default:
                                data.append('_method', this.route.type)
                                Request.post(url, data).then((response) => {
                                    this.showResponse(response)
                                })
                                break

                        }
                    }
                }
            })
        },
        showResponse(response) {
            console.log(response)
            const modal = new Modal(
                {
                    window: `Respuesta (${this.route.path})`,
                    cancel: new ModalButton({
                        text: "Cerrar",
                        icon: "bi bi-x-circle",
                        classes: "btn-secondary",
                    }),
                    close: new ModalButton({}),
                },
                ResponseModal,
                [{ response: response }]
            )
            modal.fire()
        }
    }
}
</script>
<template>
    <div class="main my-2" :style="{ background: background }">
        <div class="route">
            <div style="width: 5rem;">
                <span class="badge" :style="{ background: background }">{{ route.type }}</span>
            </div>
            <div class="w-100">
                <h5 class="mb-0 text-white">api/{{ route.path }}</h5>
                <p class="mb-0 text-white">{{ route.description }}</p>
            </div>
            <button @click="request" class="btn">
                <i class="bi bi-arrow-up-right-square"></i>
            </button>
            <button class="btn" data-bs-toggle="collapse" :data-bs-target="'#info_' + id">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse mt-2" :id="'info_' + id">
            <div v-if="route.params.length > 0">
                <h6>Parámetros de petición</h6>
                <div class="d-flex">
                    <span class="badge me-1" :style="{ background: background }">application/json</span>
                    <span class="badge" :style="{ background: background }">multipart/form-data</span>
                </div>
                <Params :params="route.params" />
            </div>
            <h6>Respuestas</h6>
            <Response v-for="response in route.responses" :response="response" :background="background" />
        </div>
    </div>
</template>
<style scoped>
.main {
    padding: .5rem;
    border-radius: .5rem;
}

.route {
    display: flex;
    align-items: center;
}
</style>
