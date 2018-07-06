Yii2 ShellExec Component
========================
Компонент позволяет запускать консольные команды как приложения Yii, так и системные.
```
Важно! Для запуска и работы с компонентом требуется разрешение выполнения shell_exec()
```

Подключение компонента
----------------------
Для подключения компонента можно использовать следующий конфиг:
```
$config = [
    'components' => [
        .....
        'shellExec' => [
            'class' => 'Vistar\ShellExec\ShellExec',
            'file' => '@app/yii',
            'phpBinaryPath' => '/usr/bin/php',
        ],
    ],
];
```

Пример использования
--------------------
```
$shellExecResult = \Yii::$app->shellExec->runShellExec('ifconfig | grep inet');
```