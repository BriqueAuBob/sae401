const BASE_URL = 'http://symfony.mmi-troyes.fr:8313/api/';

type FetchOptions = Omit<RequestInit, 'body'> & {
  body?: string | Record<string, any>;
};

const fetchFromApi = async <T>(endpoint: string, options: FetchOptions = {}): Promise<T> => {
  if (endpoint.startsWith('/')) {
    endpoint = endpoint.slice(1);
  }

  if (options?.body) {
    options.body = JSON.stringify(options.body);
  }

  options.headers = {
    'Content-Type': 'application/json',
    'Authorization': localStorage.getItem('token') ? `Bearer ${localStorage.getItem('token')}` : '',
  };

  try {
    const response = await fetch(`${BASE_URL}${endpoint}`, options as RequestInit);
    if (!response.ok) {
      throw await response.json();
    }
    const data = await response.json();
    return data;
  } catch (err: any) {
    if (err.code === 401 && endpoint !== 'auth/login') {
      localStorage.removeItem('token');
      window.location.reload();
    }
    throw err;
  }
};

export { BASE_URL, fetchFromApi };
export type { FetchOptions };
