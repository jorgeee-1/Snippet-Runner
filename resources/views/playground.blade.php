<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Snippet Runner</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1e1e2e; color: #eee; margin: 0; padding: 20px; }
        h1 { margin-top: 0; }
        .bar { display: flex; gap: 10px; margin-bottom: 10px; }
        select, button { padding: 8px 14px; font-size: 15px; border-radius: 6px; border: none; }
        button { background: #4caf50; color: white; cursor: pointer; }
        button:disabled { background: #777; }
        textarea { width: 100%; height: 260px; font-family: Consolas, monospace; font-size: 15px;
                   background: #11111b; color: #cdd6f4; border: 1px solid #444; border-radius: 6px; padding: 10px; box-sizing: border-box; }
        pre { background: #000; color: #a6e3a1; padding: 12px; border-radius: 6px; min-height: 100px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h1>Snippet Runner</h1>

    <div class="bar">
        <select id="language">
            <option value="php">PHP</option>
        </select>
        <button id="runBtn" onclick="runCode()">Run</button>
    </div>

    <textarea id="code">echo "Hello, World!";</textarea>

    <h3>Output</h3>
    <pre id="output">(wala pang output)</pre>

    <script>
        async function runCode() {
            const btn = document.getElementById('runBtn');
            const out = document.getElementById('output');
            btn.disabled = true;
            out.textContent = 'Tumatakbo...';

            try {
                const res = await fetch('/run', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        code: document.getElementById('code').value,
                        language: document.getElementById('language').value
                    })
                });
                const data = await res.json();
                out.textContent = data.output !== undefined ? data.output : JSON.stringify(data);
            } catch (e) {
                out.textContent = 'May error: ' + e.message;
            }
            btn.disabled = false;
        }
    </script>
</body>
</html>