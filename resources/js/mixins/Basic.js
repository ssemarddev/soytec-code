import Carousel from "../components/native/carousel/Carousel.vue"
import CustomTable from "../components/native/table/CustomTable.vue"

export default {
    components: { Carousel, CustomTable },
    data() {
        return {
            updating: {},
            config: {
                rows: 10,
                page: 0,
            },
            windows:  [
                {
                    id: "new",
                    name: "Agregar",
                },
                {
                    id: "list",
                    name: "Lista de registros",
                    active: true,
                },
                {
                    id: "edit",
                    name: "Actualizar",
                    hidden: true,
                },
            ],
        }
    },

    methods: {
        onedit(item) {
            this.updating = item
            this.$refs.carousel.goPageById("edit")
        },
        onsubmit(data) {
            this.$refs.table.onsubmit(data).then(() => {
                this.$refs.carousel.goPageById("list")
                this.$refs.carousel.hidePageById("edit")
            })
        },
    },
}
