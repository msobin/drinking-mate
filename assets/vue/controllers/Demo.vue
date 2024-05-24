<template>
    <div class="container">
        <div class="row align-items-start flex-fill">
            <div class="col-2">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="" v-model="me.name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control" placeholder="" v-model="me.description">
                </div>
                <div class="mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text" class="form-control" placeholder="" v-model="me.latitude">
                </div>
                <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text" class="form-control" placeholder="" v-model="me.longitude">
                </div>
                <button type="submit" class="btn btn-primary mb-3" :disabled="isWannaDrinkDisabled" @click="wannaDrink">
                    Wanna drink!
                </button>
            </div>
            <div class="col-10 vh-100">
                <div id="map"></div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isWannaDrinkDisabled: false,
            me: {
                name: 'test',
                description: "description",
                latitude: 51.14607,
                longitude: 71.420922,
            },
            token: '',
            marker: null,
            map: null,
            matesMarkers: {},
        }
    },
    mounted() {
        this.initMap();
    },
    methods: {
        async wannaDrink() {
            const response = await axios.post('/api/v1/wanna-drink', this.me)
                .catch(function (error) {
                    console.log(error);
                })

            this.token = response.data.token;
            axios.defaults.headers.common = {'Authorization': `Bearer ${this.token}`}
            this.isWannaDrinkDisabled = true;
            this.map.off('click');

            await this.findNearBy();

            setInterval(() => {
                this.findNearBy();
            }, 5000)
        },
        async findNearBy() {
            const response = await axios.get('/api/v1/mates/nearby',)
                .catch(function (error) {
                    console.log(error);
                })

            response.data.forEach((mate) => {
                if (this.matesMarkers[mate.id]) {
                    return;
                }

                this.matesMarkers[mate.id] = new L.marker([mate.point.latitude, mate.point.longitude], {icon: this.getIcon()})
                    .addTo(this.map)
                    .bindPopup(mate.name + '<br>' + mate.description + '<br><br>'
                        + '<input type="button" onclick="alert(123)" class="send-message-btn" value="Send message" data-id="' + mate.id + '">');
            })

            let mateIds = response.data.map((mate) => mate.id);
            for (let mateId in this.matesMarkers) {
                if (!mateIds.includes(mateId)) {
                    this.map.removeLayer(this.matesMarkers[mateId]);
                    delete this.matesMarkers[mateId];
                }
            }
        },
        initMap() {
            let config = {
                minZoom: 7,
                maxZoom: 18,
            };

            const zoom = 16;
            const lat = 51.14607;
            const lng = 71.420922;

            this.map = L.map("map", config).setView([lat, lng], zoom);

            L.tileLayer(
                "https://tile.openstreetmap.org/{z}/{x}/{y}.png",
                {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                }
            ).addTo(this.map);

            this.map.on('click', (e) => {
                this.me.latitude = e.latlng.lat;
                this.me.longitude = e.latlng.lng;

                if (this.marker) {
                    this.map.removeLayer(this.marker);
                }

                this.marker = new L.marker(e.latlng, {icon: this.getIcon('red')}).addTo(this.map).bindPopup('me');
            });
        },
        getIcon(color) {
            let colors = ['blue', 'gold', 'green', 'orange', 'yellow', 'violet', 'grey', 'black'];

            if (color === undefined) {
                color = colors[Math.floor(Math.random() * colors.length)];
            }

            return new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + color + '.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        },
        sendMessage(event) {
        }
    },
    watch: {
        me: {
            deep: true,
            handler() {
                this.isWannaDrinkDisabled = !(this.me.name && this.me.latitude && this.me.longitude && !this.me.token)
            },
        }
    },
}
</script>
