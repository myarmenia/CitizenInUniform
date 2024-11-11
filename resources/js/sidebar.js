import { ref, onMounted } from "vue";
import api, { initApi } from "./api";

export function useGoverningBodies(router) {
    const governingBodies = ref([]);

    if (!api.value) {
        initApi(router);
    }

    const getGoverningBodies = async () => {

        try {
            const response = await api.value.get('/api/auth/governing-bodies');
           
            governingBodies.value = response.data.result;
        } catch (error) {
            console.error("Error fetching governing bodies:", error);
        }
    };


    onMounted(() => {
        getGoverningBodies();
    });

    return { governingBodies };
}
