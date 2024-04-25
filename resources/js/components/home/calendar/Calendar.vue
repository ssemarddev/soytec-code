<script>
import Request from '../../../Request.js'
import HourInfo from './HourInfo.vue'
import Hour from './Hour'

export default {
    components: { HourInfo },
    data() {
        const days = []
        const today = new Date()
        const month = new Date(today.getFullYear(), today.getMonth(), 1)
        for (let i = 0; i < month.getDay(); i++) {
            days.push({
                day: "",
                events: [],
            })
        }
        month.setMonth(month.getMonth() + 1)
        const max = new Date(month.setDate(0)).getDate()
        console.log(max)
        for (let i = 1; i <= max; i++) {
            days.push({
                day: i,
                events: [],
            })
        }
        const hours = [
            new Hour("06:00 AM"),
            new Hour("08:00 AM"),
            new Hour("10:00 AM"),
            new Hour("12:00 PM"),
            new Hour("02:00 PM"),
            new Hour("04:00 PM"),
            new Hour("06:00 PM"),
            new Hour("08:00 PM"),
            new Hour("10:00 PM"),
        ]
        return {
            title: today.toLocaleDateString("es", {
                month: "short",
                weekday: "long",
                day: "numeric",
            }),
            today: today,
            days: days,
            hours: hours,
            select: today.getDate(),
        }
    },
    methods: {
        selected(day) {
            this.select = day
            this.events()
        },
        events() {
            for (let day of this.days) {
                if (day.day == this.select) {
                    for (let i in this.hours) {
                        this.hours[i].init(day.events)
                    }
                    break
                }
            }
        },
    },
    mounted() {
        this.events()
    },
    created() {
        const month = this.today.getMonth() + 1
        Request.get(`api/events/${month}`).then((response) => {
            for (let event of response.data) {
                const date = new Date(event.date)
                let start = new Date('1970-1-1 ' + event.start)
                start = start.getHours() + ':' + start.getMinutes()
                let end = new Date('1970-1-1 ' + event.end)
                end = end.getHours() + ':' + end.getMinutes()
                this.days[date.getDate()].events.push({
                    type: "ready",
                    name: event.name,
                    time: {
                        start: start,
                        end: end,
                    },
                    color: "rgb(54, 162, 235)",
                })
            }
        })
    }
}
</script>

<template>
    <div class="main">
        <div class="resume mb-2">
            <p><i class="bi bi-calendar-event-fill"></i> Agenda</p>
            <h6>5 Eventos hoy</h6>
        </div>
        <div class="content">
            <div>
                <div class="controls">
                    <i class="bi bi-chevron-left"></i>
                    <i class="bi bi-chevron-right"></i>
                </div>
                <p>{{ title }}</p>
                <div class="weekdays">
                    <div>D</div>
                    <div>L</div>
                    <div>M</div>
                    <div>M</div>
                    <div>J</div>
                    <div>V</div>
                    <div>S</div>
                </div>
                <div class="days">
                    <div v-for="day in days" class="pys-2" @click="selected(day.day)"
                        :class="{ active: day.day != '' && day.events.length > 0, today: today.getDate() == day.day, select: day.day == select }">
                        {{ day.day }}
                    </div>
                </div>
                <form>
                    <label class="text-center w-100">Crear evento</label>
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" name="name" placeholder="Nombre del evento" required />
                        <label>Nombre del evento <i class="bi bi-check-all"></i></label>
                    </div>
                    <div class="input-group">
                        <input placeholder="Hora de inicio" type="time" class="form-control" />
                        <input placeholder="Hora de fin" type="time" class="form-control" />
                    </div>
                </form>
            </div>
            <div class="hours">
                <p><i class="bi bi-calendar2-week-fill"></i> Eventos</p>
                <HourInfo v-for="(hour, index) in hours" :hour="hour" :index="index" :hours="hours" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.main>div:not(.resume) {
    border-radius: 0.75rem;
    box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.123);
    padding: 0.75rem;
}

.resume>p {
    margin-bottom: 0.05rem;
    font-weight: 700;
    color: rgb(0, 0, 0, 0.3);
    margin-bottom: .1rem;
}

.resume>p {
    color: rgb(0, 0, 0, 0.3);
}

.resume>h6 {
    line-height: 1.1em;
    max-width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    margin-bottom: .1rem;
    font-weight: 700;
    height: 1.1em;
}

@media (max-width: 772px) {
    .content {
        display: flex;
        grid-column-gap: .75rem;
    }

    .content>div {
        width: calc(50% - .75rem);
    }
}

@media (max-width: 635px) {
    .content {
        display: block;
    }

    .content>div {
        width: 100%;
    }
}

.controls {
    float: right;
}

.controls,
p {
    color: rgb(54, 162, 235);
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.weekdays {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(to right, rgba(5, 98, 238, 0.048), rgba(5, 98, 238, 0.137), rgba(5, 98, 238, 0.048));
}

.days {
    margin-top: 0.5rem;
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    row-gap: 0.2rem;
}

.weekdays>div,
.days>div {
    padding: 0.25rem 0.5rem;
    font-weight: 700;
    margin-left: auto;
    margin-right: auto;
}

.weekdays>div {
    color: rgb(160, 160, 160);
    font-size: 0.8em;
}

.days {
    color: rgb(185, 185, 185);
    font-size: 0.75em;
}

.days>div {
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: border ease-in 0.2s;
}

.active {
    background-color: rgb(54, 162, 235);
    color: #fff;
}

.today {
    border: 4px dashed rgb(54, 162, 235);
    color: #000;
}

.select:not(.active) {
    border: 4px solid rgb(255, 99, 132);
    color: #000;
}

.select.active {
    box-shadow: 0 0 .3rem rgb(255, 99, 132);
}

.select.today {
    border: 4px dashed rgb(255, 99, 132);
}

.hours>p {
    margin-top: 0.75rem;
    font-weight: normal;
}

.hours>div:last-of-type {
    border-bottom: 0;
}
</style>
