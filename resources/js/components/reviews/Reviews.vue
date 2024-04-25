<script>
    import Request from "../../Request.js"
    import BasicMixin from "../../mixins/Basic.js"
    import Column from "../native/Column.js"
    import Action from "../native/action-buttons/Action.js"
    import ApiAction from "../native/table/ApiAction.js"
    import CarouselPage from "../native/carousel/CarouselPage.js"

    export default {
        mixins: [BasicMixin],
        data() {
            return {
                title: "Reseñas",
                api: {
                    index: new ApiAction({
                        url: "api/reviews",
                    }),
                    destroy: new ApiAction({
                        url: "api/reviews",
                        message: (ids) => {
                            return ids.length == 1 ? "La reseña fue eliminada correctamente" : "Las reseñas seleccionadas fueron eliminadas correctamente"
                        },
                    }),
                },
                actions: [
                    new Action({
                        event: "remove",
                        name: "Eliminar",
                        icon: "bi bi-trash-fill",
                    }),
                    new Action({
                        event: "confirmed",
                        name: "Aprobar",
                        icon: "bi bi-clipboard-check-fill",
                    }),
                    new Action({
                        event: "unconfirmed",
                        name: "No aprobar",
                        icon: "bi bi-clipboard-x-fill",
                    }),
                ],
                columns: {
                    client: new Column({
                        id: "client",
                        type: "text",
                        name: "Cliente",
                        icon: "bi bi-person-circle",
                        content(item) {
                            return `${item.client.name} ${item.client.lastName}`
                        },
                        html(item) {
                            return `<img src="${item.client.avatar}" /> ${item.client.name} ${item.client.lastName}`
                        },
                    }),
                    review: new Column({
                        id: "review",
                        type: "range",
                        name: "Calificación",
                        icon: "bi bi-star-fill",
                        classes: "text-center",
                        html(item) {
                            let result = ""
                            for (let i = 0; i < 5; i++) {
                                if (i < item.review) {
                                    result += '<i class="bi bi-star-fill text-warning"></i>'
                                } else {
                                    result += '<i class="bi bi-star text-warning"></i>'
                                }
                            }
                            return result
                        },
                    }),
                    comment: new Column({
                        id: "comment",
                        type: "text",
                        name: "Reseña",
                        icon: "bi bi-chat-square-heart-fill",
                    }),
                    created_at: new Column({
                        id: "created_at",
                        type: "date",
                        name: "Fecha de creación",
                        icon: "bi bi-calendar-day",
                        classes: "text-center",
                    }),
                    confirmed: new Column({
                        id: "confirmed",
                        type: "radio",
                        name: "Estado",
                        icon: "bi bi-check-circle-fill",
                        classes: "text-center",
                        options: [
                            { value: "Aprobada", label: "Aprobada" },
                            { value: "No aprobada", label: "No aprobada" },
                        ],
                        content(item) {
                            return item.confirmed ? "Aprobada" : "No aprobada"
                        },
                        html(item) {
                            if (item.confirmed) {
                                return '<span class="badge bg-success">Aprobada</span>'
                            } else {
                                return '<span class="badge bg-danger">No aprobada</span>'
                            }
                        },
                    }),
                },
                windows: [
                    new CarouselPage({
                        id: "list",
                        name: "Reseñas",
                        active: true,
                    }),
                ],
            }
        },
        methods: {
            onconfirmed(ids) {
                const data = new FormData()
                data.append("_method", "put")
                data.append("ids", ids)
                Request.post("api/reviews/confirmed", data).then(() => {
                    const message = ids.length == 1 ? "La reseña ha sido aprobadas" : "Las reseñas han sido aprobadas"
                    this.$refs.table.onupdated(ids, { confirmed: true }, message)
                })
            },
            onunconfirmed(ids) {
                const data = new FormData()
                data.append("_method", "put")
                data.append("ids", ids)
                Request.post("api/reviews/unconfirmed", data).then(() => {
                    const message = ids.length == 1 ? "La reseña no ha sido aprobadas" : "Las reseñas no han sido aprobadas"
                    this.$refs.table.onupdated(ids, { confirmed: false }, message)
                })
            },
        },
    }
</script>

<template>
    <Carousel ref="carousel" :title="title" :windows="windows">
        <template #content="content">
            <div class="carousel-item active">
                <CustomTable ref="table" @confirmed="onconfirmed" @unconfirmed="onunconfirmed" id="reviews" :config="config" :api="api" :columns="columns" :actions="actions" />
            </div>
        </template>
    </Carousel>
</template>
