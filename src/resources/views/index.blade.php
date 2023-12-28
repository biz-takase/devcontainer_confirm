<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <!-- Uncaught Error: @vitejs/plugin-react can't detect preamble. Something is wrong. See -->
    <!-- 上記のエラーが発生し、HMRが効かないが、@viteReactRefreshを追加するエラー解消される -->
    <!-- @see https://readouble.com/laravel/9.x/ja/vite.html -->
    @viteReactRefresh
    <!-- src/public/build/manifest.json -->
    <!-- キー名に一致するvite build でバンドルされたjsが呼び出される -->
    @vite(['resources/sass/app.scss', 'resources/ts/index.tsx'])
</head>
<body>
    <div id="root"></div>
</body>
</html>