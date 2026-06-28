$npmGlobal = "C:\Users\aande\AppData\Roaming\npm"
if ($env:Path -notlike "*$npmGlobal*") {
    $env:Path = "$npmGlobal;$env:Path"
}
Remove-Item Env:OPENAI_API_KEY -ErrorAction SilentlyContinue
$env:CLAUDE_CODE_USE_OPENAI = "1"
$env:OPENAI_BASE_URL = "http://localhost:20128/v1"
$env:OPENAI_MODEL = "chat-mode"
openclaude
