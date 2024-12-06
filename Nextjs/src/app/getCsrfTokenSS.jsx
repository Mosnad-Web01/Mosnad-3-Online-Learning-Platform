// In a Server Component (e.g., `src/components/ServerHandler.js`)
import { cookies } from 'next/headers';

export function getCsrfTokenSS() {
    const cookieStore = cookies();
    const csrfToken = cookieStore.get('XSRF-TOKEN');
    return csrfToken?.value;
}
