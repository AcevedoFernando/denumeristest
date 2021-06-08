<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Resultados <i class="fa fa-table"></i></span>
                <!-- Results count -->
                <span><i class="fa fa-hashtag"></i> {{ count }}</span>
            </div>
            <div class="card-body content__scroll">
                <!-- Results table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Razón Social</th>
                            <th>Premium</th>
                            <th>Regular</th>
                            <th>Calle</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="result in results">
                            <th>{{ result.razonsocial }}</th>
                            <td>
                                $ {{ result.premium ? result.premium : "?" }}
                            </td>
                            <td>
                                $ {{ result.regular ? result.regular : "?" }}
                            </td>
                            <td>{{ result.calle }}</td>
                            <td>{{ result.municipio }}</td>
                            <td>{{ result.estado }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ["results", "count"]
};
</script>

<style scoped>
.content__scroll {
    height: 250px;
    overflow-y: auto;
}
</style>
