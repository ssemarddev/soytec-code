<script>
    import Request from "../../Request.js"
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import ApiAction from "../native/table/ApiAction.js"
    import Action from "../native/action-buttons/Action.js"

    import Modal from "../native/modal/Modal.js"
    import ModalInput from "../native/modal/ModalInput.js"
    import ModalButton from "../native/modal/ModalButton.js"

    import ImagesModal from "./ImagesModal.vue"

    import StoreForm from "./StoreForm.vue"

    export default {
        mixins: [BasicMixin],
        components: { StoreForm },
        data() {
            return {
                title: "Almacén",
                api: {
                    index: new ApiAction({
                        url: "api/products",
                    }),
                    store: new ApiAction({
                        url: "api/products",
                        message: () => {
                            return "El producto fue creado correctamente"
                        },
                    }),
                    update: new ApiAction({
                        type: "post",
                        url: (id, item) => {
                            return `api/products/${id}`
                        },
                        message: () => {
                            return "El producto fue actualizado correctamente"
                        },
                    }),
                    destroy: new ApiAction({
                        url: "api/products",
                        message: (ids) => {
                            return ids.length == 1 ? "El producto fue eliminado correctamente" : "Los productos seleccionados fueron eliminados correctamente"
                        },
                    }),
                    state: new ApiAction({
                        url: "api/products/state",
                        message: (ids) => {
                            return ids.length == 1 ? "El producto no será visible para los clientes" : "Los productos seleccionados no serán visibles para los clientes"
                        },
                    }),
                },
                actions: [
                    new Action({
                        event: "edit",
                        name: "Editar",
                        icon: "bi bi-pencil-square",
                        single: true,
                    }),
                    new Action({
                        event: "remove",
                        name: "Eliminar",
                        icon: "bi bi-trash-fill",
                    }),
                    new Action({
                        event: "state",
                        name: "Inactivar",
                        icon: "bi bi-toggle2-off",
                    }),
                    new Action({
                        event: "offer",
                        name: "Crear oferta",
                        icon: "bi bi-cart-plus",
                        single: true,
                    }),
                    new Action({
                        event: "unoffer",
                        name: "Eliminar oferta",
                        icon: "bi bi-cart-x",
                        single: true,
                    }),
                    new Action({
                        event: "images",
                        name: "Ver imágenes",
                        icon: "bi bi-cart2",
                        single: true,
                    }),
                ],
                columns: {
                    name: new Column({
                        id: "name",
                        type: "text",
                        name: "Nombre",
                        icon: "bi bi-box-seam-fill",
                    }),
                    category: new Column({
                        id: "category",
                        type: "select",
                        name: "Categoría",
                        icon: "bi bi-tag-fill",
                    }),
                    code: new Column({
                        id: "code",
                        type: "number",
                        name: "Código de barras",
                        icon: "bi bi-upc",
                        classes: "text-center",
                        content: (item) => {
                            return `${item.code} (${item.sku})`
                        },
                        html(item) {
                            return `${item.code} (${item.sku})`
                        },
                    }),
                    description: new Column({
                        id: "description",
                        type: "text",
                        name: "Descripción",
                        icon: "bi bi-book-fill",
                        visible: false,
                    }),
                    cost: new Column({
                        id: "cost",
                        type: "range",
                        name: "Costo",
                        icon: "bi bi-cash-stack",
                        classes: "text-center",
                    }),
                    price: new Column({
                        id: "price",
                        type: "range",
                        name: "Precio",
                        icon: "bi bi-cash-coin",
                        classes: "text-center",
                        content(item) {
                            return `${item.price}`
                        },
                        html(item) {
                            let code = item.price
                            if (item.offer !== null && item.offer !== undefined) {
                                code += `<br><span class="badge bg-danger">P. de oferta: ${item.offer}</span>`
                            }
                            return code
                        },
                    }),
                    stock: new Column({
                        id: "stock",
                        type: "text",
                        name: "Stock",
                        icon: "bi bi-boxes",
                        classes: "text-center",
                        content: (item) => {
                            return `${item.stock} (${item.min})`
                        },
                        html(item) {
                            return `${item.stock} (${item.min})`
                        },
                    }),
                    model: new Column({
                        id: "model",
                        type: "text",
                        name: "Marca y modelo",
                        icon: "bi bi-badge-tm-fill",
                        visible: false,
                        content: (item) => {
                            return `${item.trademark} - ${item.model}`
                        },
                        html(item) {
                            return `${item.trademark} - ${item.model}`
                        },
                    }),
                    tags: new Column({
                        id: "tags",
                        type: "tags",
                        name: "Etiquetas",
                        icon: "bi bi-tags",
                        classes: "text-center",
                        visible: false,
                        content: (item) => {
                            return item.tags.join(",")
                        },
                        html(item) {
                            let result = ""
                            for (let tag of item.tags) {
                                result += `<span class="badge bg-secondary me-1">${tag}</span>`
                            }
                            return result
                        },
                    }),
                    type: new Column({
                        id: "type",
                        type: "radio",
                        name: "Tipo",
                        icon: "bi bi-ui-radios",
                        classes: "text-center",
                        visible: false,
                        options: [
                            { value: "Físico", label: "Físico" },
                            { value: "Digital", label: "Digital" },
                        ],
                        html(item) {
                            return item.type
                        },
                    }),
                    state: new Column({
                        id: "state",
                        type: "radio",
                        name: "Estado",
                        icon: "bi bi-toggles",
                        classes: "text-center",
                        options: [
                            { value: "Activo", label: "Activo" },
                            { value: "Inactivo", label: "Inactivo" },
                        ],
                        html(item) {
                            if (item.state == "Activo") {
                                return '<span class="badge bg-success">Activo</span>'
                            } else {
                                return '<span class="badge bg-danger">Inactivo</span>'
                            }
                        },
                    }),
                },
            }
        },
        methods: {
            onoffer(item) {
                const modal = new Modal({
                    background: "#0d6efd",
                    icon: "bi bi-cart-plus-fill",
                    inputs: [
                        new ModalInput({
                            type: "text",
                            label: "Precio de oferta",
                            placeholder: "Escribe el precio de oferta del producto",
                            name: "offer",
                        }),
                    ],
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        result.data.append("_method", "put")
                        Request.post(`api/products/${item.id}/offer`, result.data).then(() => {
                            this.$refs.table.onupdated([item.id], { offer: result.data.get("offer") }, "Se ha creado la oferta correctamente")
                        })
                    }
                })
            },
            onunoffer(item) {
                const modal = new Modal({
                    background: "#dc3545",
                    icon: "bi bi-exclamation-triangle",
                    title: "Eliminar oferta",
                    description: "¿Seguro que desea eliminar la oferta del plan?",
                    accept: new ModalButton({
                        classes: "btn-danger",
                    }),
                })
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        Request.delete(`api/products/${item.id}/offer`, new FormData()).then(() => {
                            this.$refs.table.onupdated([item.id], { offer: null }, "Se ha eliminado la oferta correctamente")
                        })
                    }
                })
            },
            onimages(item) {
                const modal = new Modal(
                    {
                        window: item.name,
                        accept: new ModalButton({
                            text: "Aceptar",
                            classes: "btn-success",
                        }),
                        cancel: new ModalButton({
                            text: "Cerrar",
                            classes: "btn-secondary",
                        }),
                        close: new ModalButton({}),
                    },
                    ImagesModal,
                    [{ product: item }]
                )
                modal.fire().then((result) => {
                    if (result.status == "accept") {
                        this.onreport(item, true)
                    }
                })
            },
        },
        mounted() {
            Request.get("api/categories").then((response) => {
                for (let category of response.data) {
                    this.columns.category.options.push(category.name)
                }
            })
        },
    }
</script>

<template>
    <Carousel ref="carousel" :title="title" :windows="windows">
        <template #content="content">
            <div class="carousel-item" style="padding-top: 2.5rem">
                <StoreForm @submit="onsubmit" />
            </div>
            <div class="carousel-item active">
                <CustomTable @edit="onedit" @images="onimages" @offer="onoffer" @unoffer="onunoffer" ref="table" id="store" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
            <div class="carousel-item" style="padding-top: 2.5rem">
                <StoreForm @submit="onsubmit" :item="updating" />
            </div>
        </template>
    </Carousel>
</template>
