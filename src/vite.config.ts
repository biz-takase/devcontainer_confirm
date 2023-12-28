import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
// nodeの定義ファイル@types/nodeをインストールが必要
import fs from 'fs';
import dns from 'dns';
// nodeの優先をipv6 -> ipv4を優先にする対応
dns.setDefaultResultOrder("ipv4first");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/ts/index.tsx',
            ],
            refresh: true,
        }),
        react()
    ],
    server: {
        // 以下のパラメータを指定しないとpublic/hotファイルのURLが[::]になってしまうため、明示的にlocalhostに変更
        hmr: {
            host: 'localhost'
        },
        // 開発サーバーのhttps対応
        https: {
            key: fs.readFileSync('../.devcontainer/docker/nginx/ssl/server.key'),
            cert: fs.readFileSync('../.devcontainer/docker/nginx/ssl/server.crt')
        }
    }
});
