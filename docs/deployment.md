# Deployment

Workflow доставляет отслеживаемые файлы из `www/` на dev-сервер. Пока SSH-секреты не настроены, он запускается только вручную (`workflow_dispatch`). После проверки подключения для него следует включить запуск при push в ветку `develop`.

Workflow намеренно не использует `rsync --delete`: ядро Битрикса, пользовательские загрузки и серверные конфиги не хранятся в Git и не должны удаляться.

Для GitHub Environment `development` необходимо создать секреты:

- `DEV_HOST` — адрес dev-сервера;
- `DEV_PORT` — SSH-порт, обычно `22`;
- `DEV_USER` — отдельный непривилегированный пользователь деплоя;
- `DEV_PATH` — корень сайта на dev-сервере;
- `DEV_SSH_KEY` — приватный SSH-ключ пользователя деплоя;
- `DEV_KNOWN_HOSTS` — проверенная строка host key сервера.

Секреты добавляются в GitHub: `Settings → Environments → development → Environment secrets`.

Продакшн-деплой следует оформлять отдельным workflow из ветки `main` с ручным подтверждением через protected environment.
