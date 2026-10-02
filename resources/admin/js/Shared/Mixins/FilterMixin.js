import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import {useFilterStore} from "../../stores/filter";

export default {
    props: {
        filters: Object,
    },
    data() {
        return {
            loading: false,
            sorter: {
                order_by: null,
                order_direction: null,
                page: null,
            },
        }
    },
    mounted() {
        useFilterStore().order_by = null;
        useFilterStore().order_direction = null;

        useFilterStore().$subscribe((mutation, state) => {
            this.sorter.order_by = state.order_by;
            this.sorter.order_direction = state.order_direction;
            this.sorter.page = state.page;
        })
    },
    watch: {
        formFilters: {
            deep: true,
            handler: throttle(function () {
                this.getData()
            }, 1550),
        },
        sorter: {
            deep: true,
            handler: function () {
                this.getData()
            },
        },
    },
    methods: {
        reset() {
            this.formFilters = mapValues(this.formFilters, () => null)
        },
        getData() {
            this.$inertia.get(
                this.filterUrl,
                pickBy({...this.formFilters, ...this.sorter}),
                {
                    preserveState: true,
                    onBefore: (visit) => {
                        this.loading = true
                    },
                    onFinish: (visit) => {
                        this.loading = false
                    },
                    headers: {
                        'filter': true,
                    }
                },
            )
        }
    },
}
