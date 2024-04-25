<script>
import Chart from "chart.js/auto"

import Calendar from "../calendar/Calendar.vue"
import TopProducts from "./TopProducts.vue"

import Request from "../../../Request"

const COLORS = ["rgb(255, 99, 132)", "rgb(54, 162, 235)", "rgb(255, 159, 64)", "rgb(153, 102, 255)"]

export default {
    components: { Calendar, TopProducts },
    data() {
        return {
            items: [],
        }
    },
    methods: {
        init() {
            const data = [],
                labels = [],
                backgroundColor = []
            for (let i in this.items) {
                let item = this.items[i]
                labels.push(item.name)
                data.push(item.price)
                backgroundColor.push(item.color)
            }
            const config = {
                type: "doughnut",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Reparación en curso",
                            data: data,
                            backgroundColor: backgroundColor,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                        },
                    },
                },
            }
            const ctx = this.$el.querySelector(".chart").getContext("2d")
            new Chart(ctx, config)
        }
    },
    mounted() {
        Request.get('api/repairs/latest').then((response) => {
            this.items = response.data
            for (let i in this.items) {
                this.items[i].color = COLORS[i]
            }
            this.init()
        })
    }
}
</script>

<template>
    <div class="jobs mt-5">
        <div>
            <div class="resume mb-1">
                <p><i class="bi bi-tools"></i> Próximos trabajos</p>
                <h4>
                    $6800.00<sup class="text-danger"><i class="bi bi-arrow-down-short"></i>$321.00</sup>
                </h4>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <canvas class="chart"></canvas>
                </div>
                <div class="col-sm-6 m-auto">
                    <div v-for="item in items" class="job" :style="{ 'background-color': item.color }">
                        <h6 class="job-name">{{ item.name }}</h6>
                        <p class="job-state">{{ item.state }}</p>
                    </div>
                </div>
            </div>
            <TopProducts />
        </div>
        <div>
            <Calendar />
        </div>
    </div>
</template>

<style scoped>
.resume>p,
.resume>h4 {
    margin-bottom: 0.05rem;
    font-weight: 700;
    color: rgb(0, 0, 0, 0.3);
    margin-bottom: .5rem;
}

.resume>p {
    color: rgb(0, 0, 0, 0.3);
}

.resume>h4>sup {
    font-size: 0.7em;
}

.resume>h4 {
    font-weight: 700;
    color: #000;
}

.jobs {
    display: flex;
    flex-wrap: wrap;
    padding-left: 4rem;
    padding-right: 4rem;
}

.jobs>div:nth-child(1) {
    width: calc(62% - 2rem);
    margin-left: 2rem;
    order: 2;
}

.jobs>div:nth-child(2) {
    width: calc(38% - 2rem);
    margin-right: 2rem;
    order: 1;
}

@media (max-width: 1000px) {
    .jobs {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (max-width: 772px) {
    .jobs {
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

@media (max-width: 1000px) {
    .jobs>div:nth-child(1) {
        width: calc(62% - 0.5rem);
        margin-left: 0.5rem;
    }

    .jobs>div:nth-child(2) {
        width: calc(38% - 0.5rem);
        margin-right: 0.5rem;
    }
}

@media (max-width: 772px) {
    .jobs {
        display: block;
        flex-wrap: wrap;
    }

    .jobs>div:nth-child(1) {
        margin: 0;
    }

    .jobs>div:nth-child(2) {
        margin: 0;
    }

    .jobs>div:first-child {
        width: 100%;
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .jobs>div:nth-child(2) {
        width: 100%;
    }
}

@media (max-width: 635px) {
    .jobs>div:first-child {
        width: 100%;
        padding-left: 0;
        padding-right: 0;
    }
}

@media (max-width: 576px) {
    .col-sm-6 {
        padding-top: 1rem;
    }
}

.job {
    width: 100%;
    grid-column-gap: .15rem;
    flex-wrap: wrap;
    position: relative;
    border-radius: 0 2rem 0 2rem;
    padding: .2rem .2rem .2rem 1rem;
    margin-bottom: .4rem;
}

.job-name,
.job-state {
    color: #fff;
    white-space: nowrap;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .15rem;
}

.job-state {
    color: #eee;
}
</style>
