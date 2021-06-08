<template>
    <div>
        <div class="card">
            <div class="card-header">Mapa <i class="fa fa-map"></i></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <gmap-map
                            :center="center"
                            :zoom="zoom"
                            style="width: 100%; height: 290px"
                        >
                            <gmap-marker
                                v-for="(m, index) in markers"
                                :position="m.position"
                                :clickable="true"
                                :draggable="true"
                                @click="center = m.position"
                                :key="index"
                            ></gmap-marker>
                        </gmap-map>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["results", "count"],
    data: () => ({
        zoom: 5,
        center: {
            lat: 24.283528,
            lng: -102.393913
        },
        markers: []
    }),
    mounted() {
        this.$set(this, "zoom", 5);
    },
    methods: {
        loadMarkers() {
            var point = {};
            this.markers = [];
            this.results.forEach(marker => {
                if (marker.latitude != 0 || marker.longitude != 0) {
                    point = {
                        lat: Number(marker.latitude),
                        lng: Number(marker.longitude)
                    };
                    this.markers.push({
                        position: point
                    });
                }
            });
            this.$set(this, "center", point);
            this.$set(this, "zoom", 8);
        }
    },
    watch: {
        results() {
            if (this.count > 0) this.loadMarkers();
        }
    }
};
</script>
