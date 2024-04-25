import Popover from "bootstrap/js/dist/popover"
import { createApp } from "vue"
import PopoverContent from "./PopoverContent.vue"
import Request from "../../Request.js"

const API_URL = "http://127.0.0.1:8000/api/"
export default class ChatForm {
    constructor(el, apikey, oncreate, onerror) {
        const element = el.querySelector("[data-bs-toggle='popover']")
        const popover = new Popover(element, {
            title: "Añadir chat",
            html: true,
            content: '<div id="chatForm"></div>',
        })
        PopoverContent.mixins = [
            {
                data() {
                    return {
                        name: "",
                    }
                },
                methods: {
                    close() {
                        popover.hide()
                    },
                    save(e) {
                        const data = new FormData(e.target)
                        data.title = this.name
                        Request.post(API_URL + "client/chats/" + apikey, data).catch((error) => {
                            console.log(error)
                            // onerror()
                        })
                        oncreate(this.name)
                        popover.hide()
                    },
                },
            },
        ]
        element.addEventListener("shown.bs.popover", (e) => {
            const app = createApp(PopoverContent)
            app.mount("#chatForm")
        })
    }
}
