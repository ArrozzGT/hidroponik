@echo off
set "npmGlobal=C:\Users\aande\AppData\Roaming\npm"
set "PATH=%npmGlobal%;%PATH%"
set CLAUDE_CODE_USE_OPENAI=1
set OPENAI_BASE_URL=http://localhost:20128/v1
set OPENAI_MODEL=chat-mode
openclaude
