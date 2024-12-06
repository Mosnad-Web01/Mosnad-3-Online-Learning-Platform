
import { cookies } from 'next/headers';

export async function getServerSideProps(context) {
  const csrfToken = await getCookie();

    const cookieStore = cookies();
    const userCookie = cookieStore.get('user');
    const user = userCookie ? JSON.parse(userCookie.value) : null;

    return {
        props: { user },
    };
}
