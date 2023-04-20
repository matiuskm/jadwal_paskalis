import "./bootstrap";
import "flowbite";
import "flowbite-datepicker";

import Alpine from "alpinejs";
import Datepicker from "flowbite-datepicker/Datepicker";
import id from "../../node_modules/flowbite-datepicker/js/i18n/locales/id.js";

window.Alpine = Alpine;

const datepickerEl = document.getElementById("datepickerId");
Datepicker.locales.id = id;
if (datepickerEl != null) {
    new Datepicker(datepickerEl, {
        language: "id",
        weekStart: 1,
        format: "yyyy-mm-dd",
        autohide: true,
    });
}

Alpine.data("dropdown", () => {
    return {
        options: [],
        selected: [],
        show: false,
        open() {
            this.show = true;
        },
        close() {
            this.show = false;
        },
        isOpen() {
            return this.show === true;
        },
        select(index, event) {
            if (!this.options[index].selected) {
                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);
            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false;
            }
        },
        remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);
        },
        init(id) {
            const options = document.getElementById(id).options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected:
                        options[i].getAttribute("selected") != null
                            ? options[i].getAttribute("selected")
                            : false,
                });
                if (options[i].getAttribute("selected") != null)
                    this.select(i, options[i]);
            }
        },
        selectedValues() {
            return this.selected.map((option) => {
                return this.options[option].value;
            });
        },
    };
});
Alpine.start();
