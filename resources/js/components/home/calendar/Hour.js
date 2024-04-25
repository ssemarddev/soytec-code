export default class Hour {
    constructor(hour) {
        this.events = [];
        this.hour = hour;
    }

    init(events) {
        this.events = [];
        const hour = new Date(`1970-1-1 ${this.hour}`).getTime();
        for (let event of events) {
            const start = new Date(`1970-1-1 ${event.time.start}`).getTime();
            const end = new Date(`1970-1-1 ${event.time.end}`).getTime();
            if (hour + 7200000 > start) {
                if (hour <= start) {
                    this.events.push({
                        type: "start",
                        event: event,
                    });
                } else {
                    if (hour <= end) {
                        if (hour + 7200000 <= end) {
                            this.events.push({
                                type: "middle",
                                event: event,
                            });
                        } else {
                            this.events.push({
                                type: "end",
                                event: event,
                            });
                        }
                    } else {
                        this.events.push(null);
                    }
                }
            } else {
                this.events.push(null);
            }
        }
    }
}
