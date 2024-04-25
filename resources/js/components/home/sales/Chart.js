export default class ChartConfig {
    static CONFIG = {
        elements: {
            line: {
                tension: 0.3,
            },
        },

        responsive: true,
        plugins: {
            filler: {
                propagate: false,
            },
            title: {
                display: true,
                text: "Estadísticas de ventas",
                align: "start",
            },
        },
        scales: {
            x: {
                grid: {
                    display: false,
                },
            },
            y: {
                grid: {
                    display: false,
                },
            },
        },
        interaction: {
            intersect: false,
        },
    };
}
