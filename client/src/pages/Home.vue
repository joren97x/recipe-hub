<script setup>

</script>

<template>
    <v-container fluid style="background-color: rgb(255,240,233);">
        <v-container>
            <v-row>
                <v-col cols="6" id="dumbass_div">
                    <div>
                        <p class="text-h2 font-weight-bold">Lorem ipsum dolor, sit amet consectetur. 
                            <span id="linear">Dolores, ambatukam.</span>
                        </p>
                        <p class="my-4">
                            Lorem ipsum dolor sit amet. chat, does she miss me? consectetur adipisicing elit. Esse in mollitia impedit quo aliquam praesentium?
                        </p>
                        <v-btn color="orange" size="large" to="/recipes" class="text-white">Call to action button</v-btn>
                    </div>
                </v-col>
                <v-col cols="6">
                    <v-img height="70vh" src="https://m.media-amazon.com/images/I/516inySU30L._AC_UF1000,1000_QL80_.jpg"></v-img>
                </v-col>
            </v-row>
            <v-divider/>
            <p class="text-h4 mt-10 font-weight-bold text-center">Lorem ipsum dolor. 
                <span id="linear">Skibidi, toilet.</span>
            </p>
            <v-row>
                <v-col cols="6" id="dumbass_div">
                    <div>
                        <p class="text-h5 font-weight-bold">Lorem ipsum dolor, sit amet consectetur.  Dolores, numquam.</p>
                        <p class="my-4">
                            Lorem ipsum dolor sit amet consectetur im hungry ahh hell bruh elit. Esse in mollitia impedit quo aliquam praesentium?
                        </p>
                        <v-btn color="orange" size="large" class="text-white">Call to action button :V</v-btn>
                    </div>
                </v-col>
                <v-col cols="6">
                    <v-img height="70vh" src="https://m.media-amazon.com/images/I/516inySU30L._AC_UF1000,1000_QL80_.jpg"></v-img>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6">
                    <v-img height="70vh" src="https://m.media-amazon.com/images/I/516inySU30L._AC_UF1000,1000_QL80_.jpg"></v-img>
                </v-col>
                <v-col cols="6" id="dumbass_div">
                    <div>
                        <p class="text-h5 font-weight-bold">Lorem ipsum dolor, sit amet consectetur.  Dolores, numquam.</p>
                        <p class="my-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse in mollitia impedit quo aliquam praesentium?
                        </p>
                        <v-btn color="orange" size="large" class="text-white">Call to action button :V</v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<style scoped>

    #linear {
        background: linear-gradient(to right, #FF9800, #2C7865);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    #dumbass_div {
        height: 70vh;
        display: flex; 
        justify-content: center; 
        align-items: center;
    }

</style>