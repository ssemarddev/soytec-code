<script>
    import Modal from "bootstrap/js/dist/modal"

    export default {
        /**
         * @emit accept Se llama cuando se presiona el botón de aceptar del modal
         * - @param {FormData} data Datos del formulario del modal
         * @emit cancel Se llama cuando se presiona el botón de cancelar o se cierra el modal 
         */
        emits: ["cancel", "accept"],
        props: {
            /**
             * Configuración del modal
             */
            config: Object,
        },
        methods: {
            /**
             * Emite el evento de cancelar del modal
             * @event cancel
             */
            cancel() {
                this.$emit("cancel")
            },
            /**
             * Emite el evento de aceptar del modal y pasa los datos del fromulario
             * @event accept
             */
            accept() {
                const form = this.$el.querySelector(".alert-form")
                const data = form !== null ? new FormData(form) : new FormData()
                this.$emit("accept", data)
            },
        },
        mounted() {
            const modal = new Modal(this.$el)
            this.$el.addEventListener("hide.bs.modal", () => {
                this.$el.querySelector(".modal-content").classList.add("modal-hide")
            })
            modal.show()
        },
    }
</script>

<template>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" :style="{ background: config.background }">
                    <h5 v-if="config.window !== false" class="mb-0">{{ config.window }}</h5>
                    <i class="modal-icon" v-if="config.icon !== false" :class="config.icon"></i>
                    <button v-if="config.close.show" type="button" class="btn-close btn-close-white" :class="config.close.icon" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 v-if="config.title !== false" class="modal-title mb-3">{{ config.title }}</h3>
                    <h5 v-if="config.description !== false" class="modal-description">{{ config.description }}</h5>
                    <form v-if="config.inputs.length > 0" class="alert-form mt-3">
                        <template v-for="input in config.inputs">
                            <div v-if="input.type == 'checkbox'" class="form-check m-auto">
                                <input class="form-check-input" type="checkbox" :value="input.value" :name="input.name" :checked="input.checked" />
                                <label class="form-check-label">
                                    {{ input.label }}
                                </label>
                            </div>
                            <div v-else>
                                <label class="form-label">{{ input.label }}</label>
                                <input :name="input.name" :type="input.type" class="form-control" :placeholder="input.placeholder" />
                            </div>
                        </template>
                    </form>
                    <slot></slot>
                    <div class="buttons mt-3">
                        <button v-if="config.accept.show" @click="accept" type="button" class="btn btn-md me-2" :class="config.accept.classes" data-bs-dismiss="modal"><i :class="config.accept.icon"></i> {{ config.accept.text }}</button>
                        <button v-if="config.cancel.show" @click="cancel" type="button" class="btn btn-md" :class="config.cancel.classes" data-bs-dismiss="modal"><i :class="config.cancel.icon"></i> {{ config.cancel.text }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .modal-header {
        padding: 1rem;
        border-top-left-radius: calc(2rem - 1px);
        border-top-right-radius: calc(2rem - 1px);
        min-height: 45px;
    }

    .modal-header > i {
        font-size: 6em;
        margin: auto;
        color: #fff;
    }

    .btn-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .modal-content {
        border-radius: 2rem;
        background-color: transparent;
    }

    .modal-title {
        font-weight: 700;
        color: rgb(46 46 80);
        text-align: center;
    }

    .modal-body {
        background-color: #fff;
        border-bottom-left-radius: calc(2rem - 1px);
        border-bottom-right-radius: calc(2rem - 1px);
    }

    .buttons {
        display: flex;
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
    }

    .buttons > button {
        border-radius: 1.3rem;
    }

    .modal-description {
        color: rgb(82, 82, 82);
        text-align: center;
    }
    @keyframes jackInTheBox {
        from {
            opacity: 0;
            transform: scale(0.1) rotate(30deg);
            transform-origin: center bottom;
        }

        50% {
            transform: rotate(-10deg);
        }

        70% {
            transform: rotate(3deg);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    .modal.show .modal-icon {
        animation-name: jackInTheBox;
        animation-duration: 0.5s;
        animation-fill-mode: both;
        animation-delay: 300ms;
    }

    @keyframes backOutDown {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        20% {
            transform: translateY(0px) scale(0.7);
            opacity: 0.7;
        }

        100% {
            transform: translateY(700px) scale(0.7);
            opacity: 0.7;
        }
    }

    @keyframes backInDown {
        0% {
            transform: translateY(-1200px) scale(0.7);
            opacity: 0.7;
        }

        80% {
            transform: translateY(0px) scale(0.7);
            opacity: 0.7;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal.fade {
        animation-name: backInDown;
        animation-duration: 0.3s;
        animation-fill-mode: both;
    }
    .modal-hide {
        animation-name: backOutDown;
        animation-duration: 0.3s;
        animation-fill-mode: both;
    }
</style>
