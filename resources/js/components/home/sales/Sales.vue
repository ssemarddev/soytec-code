<script>
import Chart from "chart.js/auto"
import ChartConfig from "./Chart"

import LastSales from "./LastSales.vue"
import Request from "../../../Request"

export default {
    components: { LastSales },
    data() {
        return {
            months: [
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            ]
        }
    },
    methods: {
        build(selector, options) {
            const ctx = document.querySelector(selector).getContext("2d")
            new Chart(ctx, options)
        },
        gradient(context) {
            const chart = context.chart
            const { ctx, chartArea } = chart
            if (!chartArea) {
                // This case happens on initial chart load
                return null
            }
            let width, height, gradient
            const chartWidth = chartArea.right - chartArea.left
            const chartHeight = chartArea.bottom - chartArea.top
            if (!gradient || width !== chartWidth || height !== chartHeight) {
                width = chartWidth
                height = chartHeight
                gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom)
            }
            return gradient
        },
        init() {
            const date = new Date()
            const month = date.toLocaleDateString('es', { month: 'short' })
            const month2 = {
                label: `Ventas de ${date.toLocaleDateString('es', { month: 'long' })}`,
                data: this.months[1],
                borderColor: "rgb(54, 162, 235)",
                backgroundColor: (context) => {
                    const gradient = this.gradient(context)
                    if (gradient == null) return
                    gradient.addColorStop(0, "rgb(54, 162, 235)")
                    gradient.addColorStop(1, "rgba(54, 162, 235, 0)")
                    return gradient
                },
                fill: "start",
            }
            date.setMonth(date.getMonth() - 1)
            const month1 = {
                label: `Ventas de ${date.toLocaleDateString('es', { month: 'long' })}`,
                data: this.months[0],
                borderColor: "rgb(255, 99, 132)",
                backgroundColor: (context) => {
                    const gradient = this.gradient(context)
                    if (gradient == null) return
                    gradient.addColorStop(0, "rgb(255, 99, 132)")
                    gradient.addColorStop(1, "rgba(255, 99, 132, 0)")
                    return gradient
                },
                fill: "start",
            }
            const config = {
                type: "line",
                data: {
                    labels: [`3 ${month}`, `6 ${month}`, `9 ${month}`, `12 ${month}`, `15 ${month}`, `18 ${month}`, `21 ${month}`, `24 ${month}`, `27 ${month}`, `30 ${month}`],
                    datasets: [
                        month2,
                        month1,
                    ],
                },
                options: ChartConfig.CONFIG,
            }
            const ctx = document.querySelector(".line-sales-chart > canvas").getContext("2d")
            new Chart(ctx, config)
        }
    },
    mounted() {
        Request.get('api/sales/compare').then((response) => {
            const today = new Date()
            for (let sale of response.data) {
                const date = new Date(sale.created_at)
                const day = date.getDate()
                let i = date.getMonth() == today.getMonth() ? 1 : 0
                let j = Math.floor(day / 3)
                if (j == 10) j = 9
                this.months[i][j]++;
            }
            this.init()
        })
    }
}
</script>

<style scoped>
.sales {
    display: flex;
    flex-wrap: wrap;
    padding-left: 4rem;
    padding-right: 4rem;
}

.sales>div:nth-child(1) {
    width: calc(62% - 2rem);
    margin-right: 2rem;
}

.sales>div:nth-child(2) {
    width: calc(38% - 2rem);
    margin-left: 2rem;
}

.line-sales-chart {
    border-radius: 0.75rem;
    box-shadow: 0 5px 1rem rgb(0 0 0 / 21%);
    padding-left: 0.5rem;
    padding-bottom: 0.25rem;
}

.sales-resume>p,
.sales-resume>h4 {
    margin-bottom: 0.05rem;
    font-weight: 700;
}

.sales-resume>p {
    color: rgb(0, 0, 0, 0.3);
}

.sales-resume>h4>sup {
    font-size: 0.7em;
    color: rgb(22 193 7);
}

.sales-resume>h4 {
    font-weight: 700;
}

@media (max-width: 1000px) {
    .sales {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-width: 772px) {
    .sales {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

@media (max-width: 1000px) {
    .sales>div:nth-child(1) {
        width: calc(62% - 0.5rem);
        margin-right: 0.5rem;
    }

    .sales>div:nth-child(2) {
        width: calc(38% - 0.5rem);
        margin-left: 0.5rem;
    }
}

@media (max-width: 772px) {
    .sales {
        display: block;
        flex-wrap: wrap;
    }

    .sales>div:nth-child(1),
    .sales>div:nth-child(2) {
        width: 100%;
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .sales>div:nth-child(2) {
        width: 100%;
    }
}

@media (max-width: 635px) {

    .sales>div:nth-child(1),
    .sales>div:nth-child(2) {
        width: 100%;
        padding-left: 0;
        padding-right: 0;
    }
}
</style>

<template>
    <div class="sales mt-5">
        <div>
            <div class="sales-resume mb-2">
                <p><i class="bi bi-cash-coin"></i> Ventas totales</p>
                <h4>
                    $1500.35<sup><i class="bi bi-arrow-up-short"></i>$140.65</sup>
                </h4>
            </div>
            <div class="line-sales-chart">
                <canvas></canvas>
            </div>
        </div>
        <div>
            <LastSales />
        </div>
    </div>
</template>
