export default {
    emits: ["submit"],
    props: {
        item: {
            type: Object,
            default: {},
        },
        columns: {
            type: Array,
            default: undefined,
        },
    },
    computed: {
        data() {
            const item = {}
            for (let i in this.item) {
                item[i] = this.item[i]
            }
            return item
        },
    },
    methods: {
        submit(e) {
            const data = new FormData(e.target)
            if (this.item.id == undefined) {
                this.$emit("submit", { id: null, data: data })
            } else {
                data.append("_method", "put")
                this.$emit("submit", { id: this.item.id, data: data })
            }
        },
    },
}
