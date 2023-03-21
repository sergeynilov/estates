<template>

    <div class="font-sans text-gray-900 antialiased">
        <div v-show="!isDataLoading && estateRows.length > 0" class="text-lg">
            {{ estateRows.length }} estate{{ pluralize(estateRows.length, '', 's') }} found
        </div>
        <div v-show="!isDataLoading && estateRows.length === 0" class="text-sm">
            No estates found
        </div>
        <div v-show="isDataLoading" role="status">
            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor"/>
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>

        <div class="pt-4 bg-gray-100">
            <div class="flex flex-col items-center pt-6">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" v-model="filterName" id="filterName"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder="Enter filter on name"/>
                        <label for="filterName"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">By
                            name</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" v-model="filterPriceFrom" id="filterPriceFrom"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterPriceFrom"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price from</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" v-model="filterPriceTill" id="filterPriceTill"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterPriceTill"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price till</label>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" v-model="filterBedrooms" id="filterBedrooms"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterBedrooms"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bedrooms</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" v-model="filterBathrooms" id="filterBathrooms"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterBathrooms"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bathrooms</label>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" v-model="filterStoreys" id="filterStoreys"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterStoreys"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Storeys</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" v-model="filterGarages" id="filterGarages"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                               placeholder=" " required/>
                        <label for="filterGarages"
                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Garages</label>
                    </div>
                </div>
                <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" @click="loadEstates">
                    Filter
                </button>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Estate name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Bedrooms
                        </th>
                        <th scope="col" class="px-6 py-3">
                            bathrooms
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Storeys
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Garages
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="(estateRow, index) in estateRows" :key="index">
                        <td class="px-6 py-4">
                            {{ estateRow.name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ estateRow.bedrooms }}
                        </td>
                        <td class="px-6 py-4">
                            {{ estateRow.bathrooms }}
                        </td>
                        <td class="px-6 py-4">
                            {{ estateRow.storeys }}
                        </td>
                        <td class="px-6 py-4">
                            {{ estateRow.garages }}
                        </td>
                        <td class="px-6 py-4">
                            {{ formatValue(estateRow.price, 2) }}
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</template>

<script>

import {defineComponent} from 'vue'
import {ref, onMounted} from 'vue'

import {formatValue, pluralize} from '@/commonFuncs'

export default defineComponent({
    name: 'EstateIndex',
    components: {
    },
    setup(props) {
        let estateRows = ref([])
        let filterName = ref('')
        let filterPriceFrom = ref('')
        let filterPriceTill = ref('')
        let filterBathrooms = ref('')
        let filterStoreys = ref('')
        let filterGarages = ref('')
        let filterBedrooms = ref('')
        let isDataLoading = ref(false)

        function loadEstates() {
            let filters = {
                filter_name: filterName.value,
                filter_price_from: filterPriceFrom.value,
                filter_price_till: filterPriceTill.value,
                filter_bathrooms: filterBathrooms.value,
                filter_storeys: filterStoreys.value,
                filter_garages: filterGarages.value,
                filter_bedrooms: filterBedrooms.value,
            }
            isDataLoading.value = true
            axios.post(route('estate.filter'), filters)
                .then(({data}) => {
                    estateRows.value = data.estates
                    isDataLoading.value = false
                })
                .catch(e => {
                    isDataLoading.value = false
                    console.error(e)
                })
        } // loadEstates() {


        function TopCurrenciesOnMounted() {
            loadEstates()
        }

        onMounted(TopCurrenciesOnMounted)

        return { // setup return
            // Page state
            estateRows,
            filterName,
            filterPriceFrom,
            filterPriceTill,
            filterBedrooms,
            filterBathrooms,

            filterStoreys,
            filterGarages,

            isDataLoading,

            // Page actions
            loadEstates,

            // Common methods
            formatValue,
            pluralize
        }
    }, // setup() {

})
</script>
