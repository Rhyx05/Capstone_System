/// <reference types="vite/client" />

declare function route(name?: string, params?: any, absolute?: boolean): string;
declare namespace route {
    function current(name?: string, params?: any): boolean;
}