import type { UseFetchOptions } from 'nuxt/app';
import { useRequestHeaders } from "nuxt/app";

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
  const config = useRuntimeConfig();
  let headers: any = {
    accept: "application/json",
    referer: config.public.baseUrl,
  };

  const token = useCookie('XSRF-TOKEN');

  if (token.value) {
    headers['X-XSRF-TOKEN'] = token.value as string;
    headers['Access-Control-Allow-Origin'] = '*';
  }

  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(["cookie"]),
    };
  }

  // If we're on the client side (mounted), use `$fetch` instead of `useFetch`
  if (process.client) {
    return $fetch<T>(config.public.apiBaseUlr + path, {
      credentials: "include",
      ...options,
      headers: {
        ...headers,
        ...options?.headers,
      },
    });
  }

  // For SSR or server-side context, fallback to `useFetch`
  return useFetch<T>(config.public.apiBaseUlr + path, {
    credentials: "include",
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },
  });
}
