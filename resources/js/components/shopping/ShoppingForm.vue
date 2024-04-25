<script>
    import Form from "../../mixins/Form.js"
    import Request from "../../Request.js"

    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { FormFooter },
        data() {
            return {
                units: [],
                pieces: [],
                providers: [],
                piece: {},
                piece_id: "",
            }
        },
        methods: {
            filled() {
                if (this.piece_id == "") {
                    this.piece = {}
                    return
                }
                for (let piece of this.pieces) {
                    if (piece.id == this.piece_id) {
                        this.piece = piece
                        break
                    }
                }
            },
        },
        created() {
            Request.get("api/units").then((response) => {
                this.units = response.data
            })
            Request.get("api/pieces").then((response) => {
                this.pieces = response.data
            })
            Request.get("api/providers").then((response) => {
                this.providers = response.data
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
    <form class="page-container" v-on:submit.prevent="submit">
        <fieldset class="mb-4">
            <legend><i class="bi bi-tag"></i> &nbsp; Información de la entrada en inventario</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Seleccione una pieza o herramienta existente</label>
                            <select class="form-control" name="piece_id" v-model="piece_id" @change="filled">
                                <template v-for="piece in pieces">
                                    <option :value="piece.id">{{ piece.name }} ({{ piece.model }})</option>
                                </template>
                                <option value="" selected>Agregar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" :class="{ disabled: piece_id != '' }" name="piece[name]" placeholder="Nombre de la entrada" v-model="piece.name" required />
                            <label>Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" :class="{ disabled: piece_id != '' }" name="piece[model]" placeholder="Modelo" v-model="piece.model" required />
                            <label>Modelo <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" :class="{ disabled: piece_id != '' }" name="piece[description]" maxlength="700" placeholder="Descripción" v-model="piece.description">{{ piece.description }}</textarea>
                            <label>Descripción <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" :class="{ disabled: piece_id != '' }" name="piece[stock]" placeholder="Cantidad en stock" v-model="piece.stock" required />
                            <label>Cantidad en stock <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <select class="form-control" :class="{ disabled: piece_id != '' }" name="piece[unit_id]">
                                <template v-for="unit in units">
                                    <option :value="unit.id" :selected="piece.unit_id == unit.id">{{ unit.name }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-tag"></i> &nbsp; Información de la compra</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Seleccione una pieza o herramienta existente</label>
                            <select class="form-control" name="provider_id">
                                <template v-for="provider in providers">
                                    <option :value="provider.id">{{ provider.name }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="number" placeholder="Cantidad" class="form-control" name="quantity" required />
                            <label for="stock">Cantidad <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Precio de compra (Con impuesto incluido)" class="form-control" name="cost" required />
                            <label for="price">Precio de compra (Con impuesto incluido) <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter @import="save" :columns="columns" />
    </form>
</template>

<style scoped>
    .disabled {
        background-color: #e9ecef;
        opacity: 1;
        pointer-events: none;
    }
</style>
