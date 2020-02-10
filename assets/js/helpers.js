export const loadPage = (name) => {
    return () => import(/* webpackChunkName: "page-[request]" */ `../pages/${name}`);
};
