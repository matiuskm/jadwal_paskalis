import "./bootstrap";
import "flowbite";
import "flowbite-datepicker";

import.meta.glob(["../images/**"]);

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
        search: "",
        selected: [],
        show: false,
        clearSearch() {
            this.selected.value = "";
            this.selected.label = "";
        },
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
        filteredOptions() {
            return this.options.filter((option, i) => {
                return option.label
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
            });
        },
        selectedValues() {
            return this.selected.map((option) => {
                return this.options[option].value;
            });
        },
    };
});

Alpine.data("multiselect", (config) => {
    return {
        items: config.items ?? [],
        allItems: null,
        selectedItems: null,
        search: config.search ?? "",
        searchPlaceholder: config.searchPlaceholder ?? "Type here...",
        expanded: config.expanded ?? false,
        emptyText: config.emptyText ?? "No items found...",
        allowDuplicates: config.allowDuplicates ?? false,
        size: config.size ?? 4,
        itemHeight: config.itemHeight ?? 40,
        maxItemChars: config.maxItemChars ?? 50,
        maxTagChars: config.maxTagChars ?? 25,
        activeIndex: -1,
        onInit() {
            // Set the allItems array since we want to filter later on and keep the original (items) array as reference
            console.log(this.items);
            this.allItems = this.items.map(($option, $key) => {
                return [
                    {
                        label: $option,
                        value: $key,
                    },
                ];
            });

            this.$watch("filteredItems", (newValues, oldValues) => {
                // Reset the activeIndex whenever the filteredItems array changes
                if (newValues.length !== oldValues.length)
                    this.activeIndex = -1;
            });

            this.$watch("selectedItems", (newValues, oldValues) => {
                if (this.allowDuplicates) return;

                // Remove already selected items from the items (allItems) array (if allowDuplicates is false)
                this.allItems = this.items.filter((item, idx, all) =>
                    newValues.every((n) => n.value !== item.value)
                );
            });

            // Scroll to active element whenever activeIndex changes (if expanded is true and we have a value)
            this.$watch("activeIndex", (newValue, oldValue) => {
                if (
                    this.activeIndex == -1 ||
                    !this.filteredItems[this.activeIndex] ||
                    !this.expanded
                )
                    return;

                this.scrollToActiveElement();
            });

            // Check whether there are selected values or not and set them
            this.selectedItems = this.items
                ? this.items.filter((item) => item.selected)
                : [];
        },
        handleBlur(e) {
            // If the current active element (relatedTarget) is a child element of the component itself, return
            // Note: The current active element must have a tabindex attribute set in order to appear as a relatedTarget
            if (this.$el.contains(e.relatedTarget)) {
                return;
            }

            this.reset();
        },

        reset() {
            // 1) Clear the search value
            this.search = "";

            // 2) Close the list
            this.expanded = false;

            // 3) Reset the active index
            this.activeIndex = -1;
        },

        handleItemClick(item) {
            // 1) Add the item
            this.selectedItems.push(item);

            // 2) Reset the search input
            this.search = "";

            // 3) Keep the focus on the search input
            this.$refs.searchInput.focus();
        },

        selectNextItem() {
            if (!this.filteredItems.length) return;

            // Array count starts at 0, so we abstract 1
            if (this.filteredItems.length - 1 == this.activeIndex) {
                return (this.activeIndex = 0);
            }

            this.activeIndex++;
        },

        selectPrevItem() {
            if (!this.filteredItems.length) return;

            if (this.activeIndex == 0 || this.activeIndex == -1)
                return (this.activeIndex = this.filteredItems.length - 1);

            this.activeIndex--;
        },

        addActiveItem() {
            if (!this.filteredItems[this.activeIndex]) return;

            this.selectedItems.push(this.filteredItems[this.activeIndex]);

            this.search = "";
        },

        scrollToActiveElement() {
            // Remove the first two child elements since they are <template> tags
            const availableListElements = [
                ...this.$refs.listBox.children,
            ].slice(2, -1);

            // Scroll to active <li> element
            availableListElements[this.activeIndex].scrollIntoView({
                block: "end",
            });
        },

        removeElementByIdx(itemIdx) {
            this.selectedItems.splice(itemIdx, 1);

            // Focus the input element to keep the blur functionlity
            // otherwise @focusout on the root element will not be triggered
            if (!this.selectedItems.length) this.$refs.searchInput.focus();
        },

        shortenedLabel(label, maxChars) {
            return !maxChars || label.length <= maxChars
                ? label
                : `${label.substr(0, maxChars)}...`;
        },

        get filteredItems() {
            return this.allItems.filter((item) =>
                item.label.toLowerCase().includes(this.search?.toLowerCase())
            );
        },

        get listBoxStyle() {
            // We add 2 since there is border that takes space
            return {
                maxHeight: `${this.size * this.itemHeight + 2}px`,
            };
        },
    };
});
Alpine.start();
