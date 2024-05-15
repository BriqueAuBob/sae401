import { onMounted, ref, UnwrapRef } from "vue";
import { fetchFromApi, FetchOptions } from "../lib/fetch";

export const useFetch = <T>(endpoint: string, options?: FetchOptions) => {
  const data = ref<T | null>(null);
  const error = ref<any>(null);
  const loading = ref(true);

  const getData = async () => {
    try {
      loading.value = true;
      data.value = await fetchFromApi<T>(endpoint, options) as UnwrapRef<T> | null;
    } catch (err) {
      error.value = err;
    } finally {
      loading.value = false;
    }
  };

  onMounted(getData);

  return { getData, data, error, loading };
};

export default useFetch;