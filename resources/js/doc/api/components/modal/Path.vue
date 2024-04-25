<script>
const BACKGROUNDS = {
    GET: 'rgba(13, 171, 245, 0.7)',
    POST: 'rgb(11, 175, 46, 0.7)',
    PUT: 'rgb(255, 193, 7 ,0.7)',
    DELETE: 'rgba(245, 48, 13, 0.7)'
}
export default {
    emits: ['change'],
    props: {
        route: Object,
    },
    data() {
        const parts = []
        let literal = this.route.path
        while (literal.includes("{")) {
            const start = literal.indexOf("{")
            const end = literal.indexOf("}")
            const name = literal.substring(start + 1, end)
            parts.push({
                type: 'string',
                value: literal.substring(0, start)
            })
            let param = this.route.params.filter((p) => {
                if (p.name == name) return p
            })
            parts.push({
                type: 'param',
                value: param[0]
            })
            literal = literal.substring(0, start) + literal.substring(end + 1)
        }
        if (this.route.path.indexOf("}") < this.route.path.length - 1) {
            parts.push({
                type: 'string',
                value: this.route.path.substring(this.route.path.indexOf("}") + 1)
            })
        }

        return {
            parts: parts,
            color: BACKGROUNDS[this.route.type]
        }
    },
    methods: {
        change() {
            let url = 'api/'
            this.parts.forEach((part) => {
                if (part.type == 'string') {
                    url += part.value
                } else {
                    const value = this.$el.querySelector(`[name="${part.value.name}"]`).value
                    if (value.length == 0) {
                        url += `{${value.name}}`
                    } else {
                        url += value
                    }

                }
            })
            this.$emit('change', url)
        }
    },
    mounted() {
        this.change()
    }
}
</script>
<template>
    <div class="d-flex align-items-center">
        <span class="badge me-2" :style="{ background: color }">{{ route.type }}: </span>
        <p class="mb-1">api/</p>
        <template v-for="part in parts">
            <p class="mb-1" v-if="part.type == 'string'">
                {{ part.value }}
            </p>
            <div v-else class="form-floating" style="max-width: 5rem;">
                <input @input="change" @change="change" type="text" class="form-control" :name="part.value.name"
                    :placeholder="part.value.name" :required="part.value.required" />
                <label>{{ part.value.name }} <i v-if="part.value.required" class="bi bi-check-all"></i></label>
            </div>
        </template>
    </div>
</template>
