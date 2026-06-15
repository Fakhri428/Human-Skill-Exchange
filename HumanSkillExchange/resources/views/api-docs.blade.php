<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Human Skill Exchange API Docs</title>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/rapidoc/9.3.8/rapidoc-min.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        rapidoc {
            height: 100vh;
        }
    </style>
</head>
<body>
    <rapi-doc
        spec-url="{{ asset('openapi.json') }}"
        render-style="read"
        theme="light"
        primary-color="#0f766e"
        nav-bg-color="#0f172a"
        nav-text-color="#e2e8f0"
        nav-hover-bg-color="#1e293b"
        heading-text="Human Skill Exchange API"
        show-header="true"
        allow-authentication="true"
        allow-spec-url-load="false"
        allow-spec-file-load="false"
        show-method-in-nav-bar="as-colored-block"
        schema-style="tree"
        default-schema-tab="example"
        persist-auth="true"
    ></rapi-doc>
</body>
</html>
