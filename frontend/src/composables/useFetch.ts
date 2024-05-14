import { onMounted, ref } from "vue";
import { fetchFromApi, FetchOptions } from "../lib/fetch";

export const useFetch = <T>(endpoint: string, options?: FetchOptions) => {
  const data = ref<T | null>(null);
  const error = ref<any>(null);
  const loading = ref(false);

  const getData = async () => {
    try {
      loading.value = true;
      return await fetchFromApi<T>(endpoint, options);
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  };

  onMounted(getData);

  return { getData, data, error, loading };
};
