<template>
    <div class="container">
        <div class="row my-4">
            <div class="col-sm-12 col-md-4 mb-3">
                <form-component></form-component>
            </div>
            <div class="col-sm-12 col-md-8">
                <map-component
                    :results="results"
                    :count="count"
                ></map-component>
            </div>
            <div class="col-12">
                <table-component
                    :results="results"
                    :count="count"
                ></table-component>
            </div>
        </div>
    </div>
</template>
<script>
import FormComponent from "./FormComponent.vue";
import TableComponent from "./TableComponent.vue";
import MapComponent from "./MapComponent.vue";

export default {
    components: {
        FormComponent,
        TableComponent,
        MapComponent
    },
    computed: {
        results() {
            return this.$store.getters.results;
        },
        count() {
            return this.$store.getters.count;
        }
    }
};
</script>
