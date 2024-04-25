<script>
    import Utils from "../../Utils.js"

    export default {
        props: {
            quotation: Object,
        },
        data() {
            let totalTime = 0
            let totalPrice = 0
            for (let service of this.quotation.services) {
                totalTime += service.time
                totalPrice += Number(service.cost)
            }
            return {
                time: Utils.timeToString(totalTime),
                price: totalPrice.toFixed(2),
            }
        },
        methods: {
            getTime(time) {
                const days = Math.floor(time / 1340)
                const res = time % 1340
                const hours = Math.floor(res / 60)
                const minutes = Math.floor(res % 60)
                let result = []
                if (days > 0) {
                    result.push(days > 1 ? `${days} días` : `${days} día`)
                }
                if (hours > 0) {
                    result.push(hours > 1 ? `${hours} horas` : `${hours} hora`)
                }
                if (minutes > 0) {
                    result.push(minutes > 1 ? `${minutes} minutos` : `${minutes} minuto`)
                }
                return result.join(", ")
            },
        },
    }
</script>

<template>
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
        <h5><b>Cliente: </b> {{ quotation.client.name }} {{ quotation.client.lastName }}</h5>
        <p class="mb-1">{{ quotation.description }}</p>
        <p class="mb-0"><b>Servicios:</b></p>
        <div class="list-group list-group-flush border-bottom scrollarea">
            <a v-for="service in quotation.services" class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong class="mb-1">{{ service.name }}</strong>
                    <small>{{ service.cost.toFixed(2) }}</small>
                </div>
                <div class="col-10 mb-1 small text-start">{{ service.description }}</div>
                <div class="col-10 mb-1 small text-start">{{ getTime(service.time) }}</div>
            </a>
        </div>
        <div class="mt-2">
            <h6 class="float-end"><b>Tiempo total: </b> {{ time }}</h6>
            <h6><b>Precio total: </b> {{ price }}</h6>
        </div>
    </div>
</template>
