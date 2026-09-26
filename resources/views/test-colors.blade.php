<!DOCTYPE html>
<html>
<head>
    <title>Color Test</title>
    {!! \App\Helpers\ThemeHelper::getThemeStyleTag() !!}
    <style>
        .test-box {
            width: 100px;
            height: 100px;
            margin: 10px;
            display: inline-block;
        }
        .primary { background-color: var(--primary); }
        .secondary { background-color: var(--secondary); }
        .accent { background-color: var(--accent); }
        .category-bg { background-color: var(--category-bg); }
        .header-bg { background-color: var(--header-bg); }
        .footer-bg { background-color: var(--footer-bg); }
    </style>
</head>
<body>
    <h1>Theme Color Test</h1>
    <div class="test-box primary">Primary</div>
    <div class="test-box secondary">Secondary</div>
    <div class="test-box accent">Accent</div>
    <div class="test-box category-bg">Category BG</div>
    <div class="test-box header-bg">Header BG</div>
    <div class="test-box footer-bg">Footer BG</div>
    
    <h2>Generated CSS:</h2>
    <pre>{!! \App\Helpers\ThemeHelper::generateThemeCss() !!}</pre>
</body>
</html>