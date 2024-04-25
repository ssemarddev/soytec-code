<script>
    import Chart from "chart.js/auto"

    export default {
        props: {
            icon: String,
            name: String,
            value: Number,
        },
        data() {
            const data = []
            let prev = 100
            for (let i = 0; i < 10; i++) {
                prev += 5 - Math.random() * 10
                data.push({ x: i, y: prev })
            }
            const config = {
                type: "line",
                data: {
                    datasets: [
                        {
                            borderColor: "rgb(255, 99, 132)",
                            data: data,
                        },
                    ],
                },
                options: {
                    elements: {
                        line: {
                            tension: 0.5,
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    plugins: {
                        legend: false,
                    },
                    scales: {
                        x: {
                            type: "linear",
                            display: false,
                        },
                        y: {
                            type: "linear",
                            display: false,
                        },
                    },
                },
            }
            return {
                config: config,
            }
        },
        mounted() {
            const ctx = this.$el.querySelector(".chart").getContext("2d")
            new Chart(ctx, this.config)
        },
    }
</script>

<style scoped>
    .main {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        border-radius: 0.75rem;
        box-shadow: 0 5px 1rem rgb(0 0 0 / 21%);
    }

    .main>div {
        width: 50% !important;
        height: 95px;
        padding-left: 3rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        text-align: end;
        border-radius: 0 0.75rem 0.75rem 0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .main>div::before {
        content: " ";
        width: 100%;
        height: 120px;
        background-color: rgb(54, 162, 235);
        border-top-left-radius: 50%;
        border-bottom-left-radius: 50%;
        position: absolute;
        top: -10%;
        left: 0;
        z-index: -1;
    }

    .main>div>div>h5 {
        margin-bottom: 0.15rem;
        color: rgb(231, 231, 231);
    }

    .main>div>div>h3 {
        margin-bottom: 0;
        font-weight: 700;
    }

    .main>canvas {
        width: 50% !important;
        height: 95px !important;
    }

    @media (max-width: 860px) {
        .main>div {
            width: 40% !important;
        }

        .main>canvas {
            width: 60% !important;
        }
    }

    @media (max-width: 672px) {
        .main>div {
            width: 50% !important;
        }

        .main>canvas {
            width: 50% !important;
        }
    }
</style>

<template>
    <div class="main">
        <canvas class="chart p-2"></canvas>
        <div class="p-2">
            <div>
                <h3><i :class="icon"></i> {{value}}</h3>
                <p class="mb-0">{{name}}</p>
            </div>
        </div>
    </div>
</template>
