<template>
    <div>
        <div class="card">
            <div class="card-header">Búsqueda <i class="fa fa-search"></i></div>
            <div class="card-body">
                <form @submit.prevent="search">
                    <div class="row">
                        <!-- State  -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="state">Estado</label>
                                <input
                                    type="text"
                                    name="state"
                                    class="form-control"
                                    v-model="form.state"
                                    :disabled="onSubmit"
                                />
                            </div>
                        </div>
                        <!-- Township -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="township">Municipio</label>
                                <input
                                    type="text"
                                    name="township"
                                    class="form-control"
                                    v-model="form.township"
                                    :disabled="onSubmit"
                                />
                            </div>
                        </div>
                        <!-- Order By -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="orderBy">Orden</label>
                                <select
                                    class="form-control"
                                    name="orderBy"
                                    id="orderBy"
                                    v-model="form.orderBy"
                                    :disabled="onSubmit"
                                >
                                    <option selected value="desc"
                                        >Mayor precio</option
                                    >
                                    <option value="asc">Menor precio</option>
                                </select>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="col-12">
                            <button
                                type="button"
                                @click="search"
                                class="btn btn-block btn-info"
                                :disabled="
                                    onSubmit ||
                                        form.state == null ||
                                        form.state == '' ||
                                        form.township == null ||
                                        form.township == ''
                                "
                            >
                                {{ !onSubmit ? "Buscar" : null }}
                                <!--Loading Start-->
                                <div v-if="onSubmit" class="loading">
                                    <div class="d-flex justify-content-center">
                                        <div
                                            class="spinner-border"
                                            style="width: 1rem; height: 1rem"
                                            role="status"
                                        ></div>
                                    </div>
                                </div>
                                <!--Loading End-->
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
// Form Template
const formTemplate = {
    state: null,
    township: null,
    orderBy: null,
    limit: 100
};

export default {
    name: "FormComponent",
    data: () => ({
        form: Object.assign({}, formTemplate)
    }),
    mounted() {
        this.$set(this, "form", formTemplate);
    },
    methods: {
        search() {
            this.$store.dispatch("search", this.form);
        }
    },
    computed: {
        onSubmit() {
            return this.$store.getters.onSubmit;
        }
    }
};
</script>
